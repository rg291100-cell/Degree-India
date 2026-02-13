<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'phone',
        'gender',
        'dob',
        'location',
        'city',
        'state',
        'education_level',
        'career_interest',
        'profile_picture',
        'status',
        'role_id',
        'otp',
        'otp_expire_at',
        'is_verified',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    protected $attributes = [
        'is_admin' => 0,
        'status' => 'active',
    ];

    // Gender constants for easy access
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHER = 'other';

  
    public static function getGenderOptions()
    {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
            self::GENDER_OTHER => 'Other',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }

    public function scopeRegularUsers($query)
    {
        return $query->where('is_admin', false);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }
    

   // Relationship with Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Check if user has specific role
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    // Check if user has any of the given roles
    public function hasAnyRole(array $roles)
    {
        return $this->role && in_array($this->role->name, $roles);
    }

      // Check if user has permission
    public function hasPermission($permissionSlug)
    {
        if ($this->role->slug === 'super-admin') {
            return true;
        }

        return $this->role->permissions()
            ->where('slug', $permissionSlug)
            ->exists();
    }
    
    // Relationship with colleges through pivot
    public function managedColleges()
    {
        return $this->belongsToMany(College::class, 'college_user')
                    ->withPivot('role_id', 'permissions')
                    ->withTimestamps();
    }
    
    // Check specific role for a college
    public function hasCollegeRole($collegeId, $roleSlug)
    {
        $role = Role::where('slug', $roleSlug)->first();
        
        if (!$role) return false;
        
        return $this->managedColleges()
                    ->wherePivot('college_id', $collegeId)
                    ->wherePivot('role_id', $role->id)
                    ->exists();
    }
    
    // Get all colleges where user is college-admin
    public function collegeAdminColleges()
    {
        $collegeAdminRole = Role::where('slug', 'college-admin')->first();
        
        return $this->managedColleges()
                    ->wherePivot('role_id', $collegeAdminRole->id);
    }
    
    // Check if user is admin of any college
    public function isCollegeAdmin($collegeId = null)
    {
        if ($this->role->slug === 'super-admin') {
            return true;
        }
        
        $query = $this->collegeAdminColleges();
        
        if ($collegeId) {
            return $query->where('college_id', $collegeId)->exists();
        }
        
        return $query->exists();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'student_id');
    }

    // Bookings where user acted as counselor
    public function bookingsAsCounselor()
    {
        return $this->hasMany(Booking::class, 'counselor_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function paymentsCollected()
    {
        return $this->hasMany(AdmissionFeePayment::class, 'collected_by');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function colleges()
    {
        return $this->hasMany(College::class);
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            // Detach pivot relations (managed colleges)
            try {
                $user->managedColleges()->detach();
            } catch (\Exception $e) {
                // ignore detach errors
            }

            // Delete notifications
            $user->notifications()->delete();

            // Delete bookings where user is student or counselor
            $user->bookings()->delete();
            $user->bookingsAsCounselor()->delete();

            // Delete admissions and their fee payments (force delete for soft-deletable models)
            foreach ($user->admissions()->get() as $admission) {
                $admission->feePayments()->delete();
                if (method_exists($admission, 'forceDelete')) {
                    $admission->forceDelete();
                } else {
                    $admission->delete();
                }
            }

            // Delete payments where user was collector
            $user->paymentsCollected()->delete();

            // Delete blogs
            $user->blogs()->delete();

            // Delete courses (force delete if available)
            foreach ($user->courses()->get() as $course) {
                if (method_exists($course, 'forceDelete')) {
                    $course->forceDelete();
                } else {
                    $course->delete();
                }
            }

            // Delete colleges (force delete if available)
            foreach ($user->colleges()->get() as $college) {
                if (method_exists($college, 'forceDelete')) {
                    $college->forceDelete();
                } else {
                    $college->delete();
                }
            }

            // If user had notifications created in other contexts, ensure they are removed
            // (already covered by notifications relation)
        });
    }
}
