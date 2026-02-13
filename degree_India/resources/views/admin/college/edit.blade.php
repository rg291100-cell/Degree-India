@extends('admin.layouts.master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit College: {{ $college->name }}</h1>
            <div>
                <a href="{{ route('admin.colleges.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <a href="{{ route('admin.colleges.show', $college) }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> View
                </a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('admin.colleges.update', $college) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.college.partials.form')

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update College
                        </button>
                        <a href="{{ route('admin.colleges.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let baseUrl = "{{ config('app.url') }}";
        // Add more gallery images
        document.getElementById('add-gallery-image').addEventListener('click', function() {
            const container = document.getElementById('gallery-images-container');
            const newInput = document.createElement('div');
            newInput.className = 'input-group mb-2';
            newInput.innerHTML = `
            <input type="file" name="gallery_images[]" class="form-control" accept="image/*">
            <button type="button" class="btn btn-danger remove-gallery-image">
                <i class="fas fa-times"></i>
            </button>
        `;
            container.appendChild(newInput);
        });

        // Remove gallery image
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-gallery-image')) {
                e.target.closest('.input-group').remove();
            }
        });

        // Remove existing gallery image
        function removeGalleryImage(index) {
            if (confirm('Are you sure you want to remove this image?')) {
                // Correct route with imageIndex parameter
                fetch(`{{ route('admin.colleges.remove-gallery-image', ['college' => $college, 'imageIndex' => '__INDEX__']) }}`
                        .replace('__INDEX__', index), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Failed to remove image');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error removing image');
                    });
            }
        }

        // Course management
        const courseSelect = document.getElementById('course-select');
        const selectedCourses = document.getElementById('selected-courses');

        document.getElementById('add-course').addEventListener('click', function() {
            const selectedOption = courseSelect.options[courseSelect.selectedIndex];
            if (!selectedOption.value) return;

            const courseId = selectedOption.value;
            const courseName = selectedOption.text;

            // Check if already added
            if (document.querySelector(`input[name="courses[]"][value="${courseId}"]`)) {
                alert('Course already added!');
                return;
            }

            const courseDiv = document.createElement('div');
            courseDiv.className = 'card mb-3 course-item';
            courseDiv.innerHTML = `
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>${courseName}</strong>
                        <input type="hidden" name="courses[]" value="${courseId}">
                        <button type="button" class="btn btn-sm btn-danger remove-course float-end">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="course_fees[${courseId}]" 
                               class="form-control form-control-sm" 
                               placeholder="Fees" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="course_duration[${courseId}]" 
                               class="form-control form-control-sm" 
                               placeholder="Duration">
                    </div>
                    <div class="col-md-2">
                        <select name="course_intake[${courseId}]" class="form-control form-control-sm">
                            <option value="yearly">Yearly</option>
                            <option value="january">January</option>
                            <option value="july">July</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="course_seats[${courseId}]" 
                               class="form-control form-control-sm" 
                               placeholder="Seats">
                    </div>
                </div>
            </div>
        `;

            selectedCourses.appendChild(courseDiv);
        });

        // Remove course
        selectedCourses.addEventListener('click', function(e) {
            if (e.target.closest('.remove-course')) {
                e.target.closest('.course-item').remove();
            }
        });

        // JSON format validation for textareas
        function formatJSON(textareaId) {
            const textarea = document.getElementById(textareaId);
            try {
                const json = JSON.parse(textarea.value);
                textarea.value = JSON.stringify(json, null, 4);
            } catch (e) {
                // If not valid JSON, leave as is
            }
        }

        // Format JSON on page load
        document.addEventListener('DOMContentLoaded', function() {
            ['eligibility_criteria', 'top_recruiters'].forEach(id => {
                formatJSON(id);
            });
        });
    </script>
@endsection
