<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Admission;

class AdmissionConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admission;

    public function __construct(Admission $admission)
    {
        $this->admission = $admission;
    }

    public function build()
    {
        return $this->subject('Admission Confirmation - ' . $this->admission->course->name)
            ->view('emails.admission-confirmation')
            ->with([
                'admission' => $this->admission,
                'user' => $this->admission->user,
                'course' => $this->admission->course
            ]);
    }
}