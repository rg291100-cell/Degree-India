<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Letter - {{ config('app.name') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap');

        :root {
            --primary-color: #034280;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
            --text-color: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background: #fff;
            padding: 20px;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .no-print {
                display: none !important;
            }
        }

        .letter-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border: 1px solid var(--border-color);
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
        }

        .letterhead {
            background: linear-gradient(135deg, var(--primary-color), #1a252f);
            color: white;
            padding: 40px 50px;
            position: relative;
            overflow: hidden;
        }

        .letterhead::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .letterhead::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .institute-info {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .institute-name {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .institute-tagline {
            font-size: 16px;
            font-weight: 300;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .admission-title {
            font-size: 28px;
            font-weight: 600;
            margin-top: 20px;
            color: #fff;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        .admission-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--accent-color);
        }

        .letter-body {
            padding: 50px;
        }

        .letter-date {
            text-align: right;
            margin-bottom: 40px;
            color: #666;
            font-size: 14px;
        }

        .recipient-info {
            margin-bottom: 40px;
        }

        .recipient-name {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .recipient-details {
            color: #666;
            line-height: 1.8;
        }

        .letter-content {
            margin-bottom: 40px;
        }

        .salutation {
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .subject {
            font-weight: 600;
            color: var(--primary-color);
            margin: 25px 0;
            font-size: 18px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin: 30px 0;
        }

        .detail-card {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .detail-card .title {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .detail-card .value {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .payment-details {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 30px;
            margin: 40px 0;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .payment-header h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            text-align: center;
        }

        .payment-item {
            padding: 15px;
        }

        .payment-item .amount {
            font-size: 24px;
            font-weight: 700;
            margin: 10px 0;
        }

        .amount.total {
            color: var(--primary-color);
        }

        .amount.paid {
            color: #27ae60;
        }

        .amount.due {
            color: var(--accent-color);
        }

        .payment-progress {
            margin-top: 20px;
            background: #ecf0f1;
            height: 10px;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #27ae60, #2ecc71);
            border-radius: 5px;
            transition: width 1s ease-in-out;
        }

        .course-details {
            background: #f8f9fa;
            border-left: 4px solid var(--secondary-color);
            padding: 25px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }

        .terms-conditions {
            margin: 40px 0;
        }

        .terms-conditions h4 {
            color: var(--primary-color);
            margin-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
        }

        .terms-list {
            list-style: none;
        }

        .terms-list li {
            margin-bottom: 12px;
            padding-left: 30px;
            position: relative;
        }

        .terms-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #27ae60;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 60px;
            text-align: center;
        }

        .signature-line {
            width: 300px;
            height: 1px;
            background: #333;
            margin: 40px auto 20px;
        }

        .signature-info {
            margin-top: 10px;
        }

        .footer {
            background: var(--primary-color);
            color: white;
            padding: 30px 50px;
            margin-top: 50px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .footer-column h4 {
            font-size: 16px;
            margin-bottom: 15px;
            color: #ecf0f1;
        }

        .footer-column p {
            font-size: 14px;
            line-height: 1.8;
            opacity: 0.9;
        }

        .print-actions {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        .print-btn {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .badge.approved {
            background: #d4edda;
            color: #155724;
        }

        .badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge.completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot.approved {
            background: #28a745;
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
        }

        .status-dot.pending {
            background: #ffc107;
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
        }

        .status-dot.completed {
            background: #17a2b8;
            box-shadow: 0 0 10px rgba(23, 162, 184, 0.5);
        }

        @media (max-width: 768px) {
            .letter-container {
                margin: 10px;
            }

            .letterhead {
                padding: 30px 20px;
            }

            .letter-body {
                padding: 30px 20px;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .payment-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .print-btn {
                padding: 10px 20px;
                font-size: 14px;
            }

            .institute-name {
                font-size: 24px;
            }

            .admission-title {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="letter-container">
        <!-- Letterhead -->
        <div class="letterhead">
            <div class="institute-info">
                <h1 class="institute-name">{{ config('app.name', 'EDU INSTITUTE') }}</h1>
                <p class="institute-tagline">Empowering Education, Enriching Lives</p>
                <h2 class="admission-title">OFFICIAL ADMISSION LETTER</h2>
                <p style="margin-top: 15px; opacity: 0.9;">Certificate No:
                    {{ str_pad($admission->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Letter Body -->
        <div class="letter-body">
            <!-- Date -->
            <div class="letter-date">
                Date: {{ date('F d, Y') }}
            </div>

            <!-- Recipient Info -->
            <div class="recipient-info">
                <h3 class="recipient-name">{{ $admission->user->name }}</h3>
                <div class="recipient-details">
                    <p>{{ $admission->user->email }}</p>
                    <p>Phone: {{ $admission->user->phone ?? 'Not Provided' }}</p>
                    <p>Student ID: STU{{ str_pad($admission->user->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <!-- Salutation -->
            <div class="letter-content">
                <p class="salutation">Dear <strong>{{ $admission->user->name }}</strong>,</p>

                <p class="subject">
                    SUBJECT: Confirmation of Admission to {{ $admission->course->name }}
                </p>

                <p style="margin-bottom: 20px; line-height: 1.8;">
                    We are delighted to inform you that your application for admission has been reviewed and
                    <strong
                        class="badge {{ $admission->admission_status }}">{{ strtoupper($admission->admission_status) }}</strong>.
                    On behalf of {{ config('app.name') }}, we extend our warmest congratulations and welcome you to our
                    academic community.
                </p>

                <!-- Status Indicator -->
                <div class="status-indicator">
                    <span class="status-dot {{ $admission->admission_status }}"></span>
                    <span><strong>Admission Status:</strong> {{ ucfirst($admission->admission_status) }}</span>
                </div>
            </div>

            <!-- Course Details -->
            <div class="course-details">
                <h3 style="color: var(--primary-color); margin-bottom: 15px;">
                    <i class="fas fa-graduation-cap"></i> Course Information
                </h3>
                <div class="details-grid">
                    <div class="detail-card">
                        <div class="title">Course Name</div>
                        <div class="value">{{ $admission->course->title }}</div>
                    </div>
                    <div class="detail-card">
                        <div class="title">Course Category / Type</div>
                        <div class="value">{{ $admission->course->category->name ?? 'N/A' }} /
                            {{ $admission->course->course_type ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="detail-card">
                        <div class="title">Duration</div>
                        <div class="value">{{ $admission->course->duration ?? 'N/A' }}
                            {{ $admission->course->duration_unit ?? '' }}</div>
                    </div>
                    <div class="detail-card">
                        <div class="title">Total Sessions</div>
                        <div class="value">{{ $admission->course->total_sessions ?? 'N/A' }} Sessions</div>
                    </div>
                    <div class="detail-card">
                        <div class="title">Admission Date</div>
                        <div class="value">{{ $admission->created_at->format('F d, Y') }}</div>
                    </div>
                    <div class="detail-card">
                        <div class="title">Expected Completion</div>
                        <div class="value">{{ $admission->expected_completion ?? 'To be announced' }}</div>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="payment-details">
                <div class="payment-header">
                    <h3>Fee Structure & Payment Summary</h3>
                    <p>All amounts are in Indian Rupees (₹)</p>
                </div>

                <div class="payment-grid">
                    <div class="payment-item">
                        <div class="title">Total Course Fees</div>
                        <div class="amount total">₹{{ number_format($admission->total_fees, 2) }}</div>
                        <small>Inclusive of all charges</small>
                    </div>
                    <div class="payment-item">
                        <div class="title">Amount Paid</div>
                        <div class="amount paid">₹{{ number_format($admission->paid_amount, 2) }}</div>
                        <small>Payment Status: {{ ucfirst(str_replace('_', ' ', $admission->payment_status)) }}</small>
                    </div>
                    <div class="payment-item">
                        <div class="title">Balance Due</div>
                        <div class="amount due">₹{{ number_format($admission->due_amount, 2) }}</div>
                        <small>To be paid before course commencement</small>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="payment-progress">
                    @php
                        $percentage = ($admission->paid_amount / $admission->total_fees) * 100;
                    @endphp
                    <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                </div>
                <div style="text-align: center; margin-top: 10px; font-size: 14px; color: #666;">
                    Payment Progress: {{ round($percentage, 1) }}% Complete
                </div>
            </div>

            <!-- Student Commitments -->
            <div style="margin: 40px 0;">
                <h4 style="color: var(--primary-color); margin-bottom: 15px;">Student Declaration</h4>
                <p style="line-height: 1.8;">
                    I, <strong>{{ $admission->user->name }}</strong>, hereby acknowledge that I have read and
                    understood all the terms and conditions
                    of admission. I agree to abide by the rules and regulations of {{ config('app.name') }} and commit
                    to attending all
                    scheduled sessions regularly.
                </p>
            </div>

            <!-- Terms & Conditions -->
            <div class="terms-conditions">
                <h4>Terms & Conditions</h4>
                <ul class="terms-list">
                    <li>This admission letter is valid only after full payment of course fees or as per the approved
                        payment plan</li>
                    <li>All original documents must be submitted for verification within 15 working days</li>
                    <li>The institute reserves the right to modify the schedule with prior notice</li>
                    <li>Fees once paid are non-refundable except under special circumstances</li>
                    <li>Attendance must be maintained at 75% minimum to be eligible for certification</li>
                    <li>Any misconduct may lead to cancellation of admission without refund</li>
                    <li>Installment payments must be made as per the agreed schedule</li>
                </ul>
            </div>

            <!-- Next Steps -->
            <div style="background: #e8f4fc; padding: 25px; border-radius: 8px; margin: 30px 0;">
                <h4 style="color: var(--primary-color); margin-bottom: 15px;">Next Steps</h4>
                <ol style="padding-left: 25px; line-height: 1.8;">
                    <li>Complete the remaining payment (if any) within the specified deadline</li>
                    <li>Submit all required documents to the admission office</li>
                    <li>Attend the orientation session on the commencement date</li>
                    <li>Collect your student ID card and course materials</li>
                </ol>
            </div>

            <!-- Signature Section -->
            <div class="signature-section">
                <div style="margin-bottom: 30px;">
                    <p>We look forward to welcoming you to our campus and wish you a successful academic journey.</p>
                </div>

                <div class="signature-line"></div>

                <div class="signature-info">
                    <p style="font-weight: 600; font-size: 18px;">Authorized Signatory</p>
                    <p>Admission Officer</p>
                    <p>{{ config('app.name') }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-grid">
                <div class="footer-column">
                    <h4>Contact Information</h4>
                    <p>{{ config('app.address', '123 Education Street, Knowledge City') }}</p>
                    <p>Phone: {{ config('app.phone', '+91 9876543210') }}</p>
                    <p>Email: {{ config('app.email', 'admissions@institute.com') }}</p>
                </div>
                <div class="footer-column">
                    <h4>Office Hours</h4>
                    <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                    <p>Saturday: 10:00 AM - 4:00 PM</p>
                    <p>Sunday: Closed</p>
                </div>
                <div class="footer-column">
                    <h4>Important Links</h4>
                    <p>Website: {{ config('app.url', 'www.institute.com') }}</p>
                    <p>Student Portal: portal.institute.com</p>
                    <p>Help Desk: help.institute.com</p>
                </div>
            </div>

            <div
                style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                <p style="font-size: 12px; opacity: 0.8;">
                    This is a computer-generated document. No signature is required. Valid only with official stamp.
                </p>
                <p style="font-size: 12px; opacity: 0.8;">
                    Generated on: {{ date('Y-m-d H:i:s') }} | Document ID: ADM{{ $admission->id }}{{ date('Ymd') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <div class="print-actions no-print">
        <button class="print-btn" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                viewBox="0 0 16 16">
                <path
                    d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                <path
                    d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
            </svg>
            Print Admission Letter
        </button>
    </div>

    <script>
        // Add print functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-print option (optional)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('print') === 'true') {
                setTimeout(() => {
                    window.print();
                }, 1000);
            }

            // Add watermark for draft status
            if ('{{ $admission->admission_status }}' === 'pending') {
                const watermark = document.createElement('div');
                watermark.innerHTML = `
                    <div style="
                        position: fixed;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%) rotate(-45deg);
                        font-size: 80px;
                        color: rgba(0,0,0,0.1);
                        font-weight: bold;
                        pointer-events: none;
                        z-index: 9999;
                    ">
                        PROVISIONAL
                    </div>
                `;
                document.body.appendChild(watermark);
            }
        });

        // PDF Generation option
        function generatePDF() {
            // This would require a PDF generation library
            alert('PDF generation feature would require additional setup with jsPDF or similar library');
        }
    </script>
</body>

</html>
