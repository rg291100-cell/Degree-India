{{-- admin/course/partials/pricing.blade.php --}}
<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-4">
            <label for="fees" class="form-label">
                <i class="fas fa-rupee-sign mr-1"></i> Actual Course Fees *
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">₹</span>
                </div>
                <input type="number" class="form-control @error('fees') is-invalid @enderror" id="fees"
                    name="fees" value="{{ old('fees', $course->fees ?? '') }}" step="0.01" min="0"
                    required>
            </div>
            @error('fees')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="discount_percentage" class="form-label">
                <i class="fas fa-percentage mr-1"></i> Discount Percentage
            </label>
            <div class="input-group">
                <input type="number" class="form-control @error('discount_percentage') is-invalid @enderror"
                    id="discount_percentage" name="discount_percentage"
                    value="{{ old('discount_percentage', $course->discount_percentage ?? '') }}" min="0"
                    max="100" step="0.01">
                <div class="input-group-append">
                    <span class="input-group-text">%</span>
                </div>
            </div>
            @error('discount_percentage')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <input type="hidden" id="discounted_fees" name="discounted_fees"
                value="{{ old('discounted_fees', $course->discounted_fees ?? '') }}">
        </div>

        <div id="discountPreview" style="display: none;"></div>

        <div class="form-group mb-4">
            <label for="admission_fee" class="form-label">
                <i class="fas fa-file-invoice-dollar mr-1"></i> Admission Fee
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">₹</span>
                </div>
                <input type="number" class="form-control @error('admission_fee') is-invalid @enderror"
                    id="admission_fee" name="admission_fee"
                    value="{{ old('admission_fee', $course->admission_fee ?? '') }}" step="0.01" min="0">
            </div>
            @error('admission_fee')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


    </div>

    <div class="col-md-4">
        <div class="form-group mb-4">
            <label for="currency" class="form-label">
                <i class="fas fa-money-bill-wave mr-1"></i> Currency *
            </label>
            <select class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency"
                required>
                <option value="INR" {{ old('currency', $course->currency ?? 'INR') == 'INR' ? 'selected' : '' }}>
                    INR (₹)</option>
                <option value="USD" {{ old('currency', $course->currency ?? '') == 'USD' ? 'selected' : '' }}>USD
                    ($)</option>
                <option value="EUR" {{ old('currency', $course->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR
                    (€)</option>
                <option value="GBP" {{ old('currency', $course->currency ?? '') == 'GBP' ? 'selected' : '' }}>GBP
                    (£)</option>
            </select>
            @error('currency')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>





        <div class="form-group">
            <label class="form-label d-block">
                <i class="fas fa-file-pdf mr-1"></i> Prospectus
            </label>
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" class="custom-control-input" id="has_prospectus" name="has_prospectus"
                    value="1" {{ old('has_prospectus', $course->has_prospectus ?? 0) ? 'checked' : '' }}>
                <label class="custom-control-label" for="has_prospectus">
                    Course has prospectus
                </label>
            </div>
            @error('has_prospectus')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <div id="prospectusFile"
                style="{{ old('has_prospectus', $course->has_prospectus ?? 0) ? '' : 'display: none;' }}">
                <!-- For Edit Mode: Show existing prospectus if available -->
                @isset($course)
                    @if ($course->prospectus_file)
                        <div class="alert alert-info mb-2">
                            <i class="fas fa-file-pdf mr-1"></i>
                            Current file:
                            <a href="{{ Storage::url($course->prospectus_file) }}" target="_blank" class="ml-1">
                                View Prospectus
                            </a>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="remove_prospectus"
                                name="remove_prospectus" value="1">
                            <label class="custom-control-label text-danger" for="remove_prospectus">
                                Remove current file
                            </label>
                        </div>
                    @endif
                @endisset

                <div class="custom-file">
                    <input type="file"
                        class="form-control custom-file-input @error('prospectus_file') is-invalid @enderror"
                        id="prospectus_file" name="prospectus_file" accept=".pdf,.doc,.docx">
                    <label class="custom-file-label" for="prospectus_file">
                        @isset($course)
                            @if ($course->prospectus_file)
                                Replace file...
                            @else
                                Choose file...
                            @endif
                        @else
                            Choose file...
                        @endisset
                    </label>
                </div>
                @error('prospectus_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                    PDF or Word document (Max 10MB)
                </small>
            </div>
        </div>


    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            // Prospectus toggle
            $('#has_prospectus').change(function() {
                if ($(this).is(':checked')) {
                    $('#prospectusFile').slideDown();
                } else {
                    $('#prospectusFile').slideUp();
                    $('#prospectus_file').val('');
                    $('#remove_prospectus').prop('checked', false);
                }
            });

            // Installment toggle
            $('#installment_available').change(function() {
                if ($(this).val() == '1') {
                    $('#installmentDetails').slideDown();
                } else {
                    $('#installmentDetails').slideUp();
                    $('#installment_details').summernote('code', '');
                }
            });

            // Scholarship toggle
            $('#scholarship_available').change(function() {
                if ($(this).val() == '1') {
                    $('#scholarshipDetails').slideDown();
                } else {
                    $('#scholarshipDetails').slideUp();
                    $('#scholarship_details').summernote('code', '');
                }
            });

            // Currency symbol update
            $('#currency').change(function() {
                const currency = $(this).val();
                let symbol = '₹';
                switch (currency) {
                    case 'USD':
                        symbol = '$';
                        break;
                    case 'EUR':
                        symbol = '€';
                        break;
                    case 'GBP':
                        symbol = '£';
                        break;
                    default:
                        symbol = '₹';
                }

                // Update all currency symbols in the form
                $('.input-group-prepend .input-group-text').text(symbol);

                // Recalculate discount if needed
                calculateDiscount();
            });

            // Calculate discount on input
            $('#fees, #discount_percentage, #tax_percentage, #additional_charges').on('input', calculateDiscount);

            function calculateDiscount() {
                const fees = parseFloat($('#fees').val()) || 0;
                const discount = parseFloat($('#discount_percentage').val()) || 0;
                const tax = parseFloat($('#tax_percentage').val()) || 0;
                const additional = parseFloat($('#additional_charges').val()) || 0;
                const currency = $('#currency').val() || 'INR';
                let symbol = '₹';

                switch (currency) {
                    case 'USD':
                        symbol = '$';
                        break;
                    case 'EUR':
                        symbol = '€';
                        break;
                    case 'GBP':
                        symbol = '£';
                        break;
                    default:
                        symbol = '₹';
                }

                if (discount > 0 && discount <= 100) {
                    const discounted = fees - (fees * discount / 100);
                    const totalWithTax = discounted + (discounted * tax / 100);
                    const finalTotal = totalWithTax + additional;

                    $('#discounted_fees').val(discounted.toFixed(2));

                    $('#discountPreview').html(`
                    <div class="alert alert-info mt-3">
                        <h6>Price Breakdown:</h6>
                        <p class="mb-1">
                            <span class="original-price">Original: ${symbol} ${fees.toFixed(2)}</span>
                            <span class="badge bg-danger ms-2">${discount}% OFF</span>
                        </p>
                        <p class="mb-1">Discounted Price: <strong>${symbol} ${discounted.toFixed(2)}</strong></p>
                        ${tax > 0 ? `<p class="mb-1">Tax (${tax}%): ${symbol} ${(discounted * tax / 100).toFixed(2)}</p>` : ''}
                        ${additional > 0 ? `<p class="mb-1">Additional Charges: ${symbol} ${additional.toFixed(2)}</p>` : ''}
                        <hr class="my-2">
                        <h4 class="text-primary">Final Price: ${symbol} ${finalTotal.toFixed(2)}</h4>
                        <small class="text-success">You save: ${symbol} ${(fees - discounted).toFixed(2)}</small>
                    </div>
                `).show();
                } else {
                    $('#discounted_fees').val('');
                    const totalWithTax = fees + (fees * tax / 100);
                    const finalTotal = totalWithTax + additional;

                    if (tax > 0 || additional > 0) {
                        $('#discountPreview').html(`
                        <div class="alert alert-info mt-3">
                            <h6>Price Breakdown:</h6>
                            <p class="mb-1">Base Price: <strong>${symbol} ${fees.toFixed(2)}</strong></p>
                            ${tax > 0 ? `<p class="mb-1">Tax (${tax}%): ${symbol} ${(fees * tax / 100).toFixed(2)}</p>` : ''}
                            ${additional > 0 ? `<p class="mb-1">Additional Charges: ${symbol} ${additional.toFixed(2)}</p>` : ''}
                            <hr class="my-2">
                            <h4 class="text-primary">Final Price: ${symbol} ${finalTotal.toFixed(2)}</h4>
                        </div>
                    `).show();
                    } else {
                        $('#discountPreview').hide();
                    }
                }
            }

            // Initialize discount calculation if values exist
            @if (isset($course) || old('fees'))
                calculateDiscount();
            @endif

            // File input label update
            $('#prospectus_file').change(function(e) {
                var fileName = e.target.files[0].name;
                $(this).next('.custom-file-label').html(fileName);
            });
        });
    </script>
@endsection
