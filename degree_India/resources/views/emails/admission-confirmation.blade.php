<!DOCTYPE html>
<html>

<head>
    <title>Admission Confirmation</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e8ed;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .header h2::before {
            content: '🎉';
            font-size: 32px;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 25px;
        }

        .greeting span {
            color: #4a5568;
            font-weight: 500;
        }

        .course-card {
            background: linear-gradient(135deg, #f6f9ff 0%, #f0f4ff 100%);
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            border-left: 5px solid #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        }

        .course-card h3 {
            margin: 0 0 15px 0;
            color: #2d3748;
            font-size: 20px;
            font-weight: 600;
        }

        .course-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-label {
            font-size: 14px;
            color: #718096;
            font-weight: 500;
        }

        .info-value {
            font-size: 16px;
            color: #2d3748;
            font-weight: 600;
        }

        .payment-section {
            margin: 30px 0;
        }

        .payment-section h4 {
            color: #2d3748;
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #edf2f7;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-section h4::before {
            content: '💳';
            font-size: 20px;
        }

        .payment-methods {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .method-list {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }

        .method-item {
            background: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            color: #4a5568;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 25px 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .payment-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .payment-table th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 500;
            font-size: 15px;
        }

        .payment-table tbody tr {
            background: white;
            transition: background 0.3s ease;
        }

        .payment-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .payment-table tbody tr:hover {
            background: #f0f4ff;
        }

        .payment-table td {
            padding: 18px 15px;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
        }

        .amount-cell {
            font-weight: 600;
            color: #2d3748;
            font-size: 16px;
        }

        .due-amount {
            color: #e53e3e;
        }

        .paid-amount {
            color: #38a169;
        }

        .total-amount {
            color: #2d3748;
        }

        .payment-status {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            margin-left: 10px;
        }

        .status-pending {
            background: #feebc8;
            color: #c05621;
        }

        .status-paid {
            background: #c6f6d5;
            color: #22543d;
        }

        .important-notes {
            background: #fffaf0;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            border: 1px solid #fed7d7;
        }

        .important-notes h4 {
            color: #c05621;
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .important-notes h4::before {
            content: '📌';
            font-size: 18px;
        }

        .notes-list {
            margin: 0;
            padding-left: 20px;
            color: #4a5568;
        }

        .notes-list li {
            margin-bottom: 10px;
        }

        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4a5568;
            font-size: 14px;
        }

        .contact-item i {
            font-size: 16px;
            color: #667eea;
        }

        .signature {
            color: #2d3748;
            margin-top: 25px;
            font-size: 15px;
        }

        .signature strong {
            color: #667eea;
            font-size: 16px;
        }

        .logo {
            font-size: 22px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
        }

        .highlight {
            background: linear-gradient(120deg, #f0f4ff 0%, #ffffff 100%);
            padding: 3px 8px;
            border-radius: 6px;
            color: #667eea;
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .email-container {
                margin: 20px;
                border-radius: 15px;
            }

            .content {
                padding: 25px 20px;
            }

            .course-info {
                grid-template-columns: 1fr;
            }

            .header h2 {
                font-size: 22px;
                flex-direction: column;
                gap: 10px;
            }

            .method-list {
                flex-direction: column;
            }

            .contact-info {
                flex-direction: column;
                gap: 15px;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h2>🎉 Admission Confirmed!</h2>
        </div>

        <div class="content">
            <div class="greeting">
                Dear <span>{{ $user->name }}</span>,
            </div>

            <p style="color: #4a5568; font-size: 16px; margin-bottom: 25px;">
                We are thrilled to inform you that your admission application has been <span
                    class="highlight">successfully approved</span>.
                Welcome to our academic community!
            </p>

            <div class="course-card">
                <h3>{{ $course->name }}</h3>
                <div class="course-info">
                    <div class="info-item">
                        <span class="info-label">Admission ID </span>
                        <span class="info-value"># {{ str_pad($admission->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Admission Date </span>
                        <span class="info-value"> {{ $admission->created_at->format('F d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Fees </span>
                        <span class="info-value" style="color: #667eea; font-size: 18px;">
                            ₹ {{ number_format($admission->total_fees, 2) }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Status </span>
                        <span
                            class="payment-status {{ $admission->paid_amount == $admission->total_fees ? 'status-paid' : 'status-pending' }}">
                            {{ $admission->paid_amount == $admission->total_fees ? 'Fully Paid' : 'Payment Pending' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="payment-section">
                <h4>Payment Details</h4>

                <table class="payment-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Total Course Fees</strong></td>
                            <td class="amount-cell total-amount" style="text-align: right;">
                                ₹ {{ number_format($admission->total_fees, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Amount Paid</strong></td>
                            <td class="amount-cell paid-amount" style="text-align: right;">
                                ₹ {{ number_format($admission->paid_amount, 2) }}</td>
                        </tr>
                        <tr style="background: #fff8f8;">
                            <td><strong>Balance Due</strong></td>
                            <td class="amount-cell due-amount" style="text-align: right;">
                                ₹ {{ number_format($admission->due_amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="payment-methods">
                    <p style="margin: 0 0 15px 0; color: #4a5568; font-weight: 500;">
                        Complete your payment through any of the following methods:
                    </p>
                    <div class="method-list">
                        <div class="method-item">
                            <span style="color: #667eea;">🏦</span> Online Portal Payment
                        </div>
                        <div class="method-item">
                            <span style="color: #667eea;">🏧</span> Bank Transfer
                        </div>
                        <div class="method-item">
                            <span style="color: #667eea;">💵</span> Cash at Office
                        </div>
                        <div class="method-item">
                            <span style="color: #667eea;">💳</span> Credit/Debit Card
                        </div>
                    </div>
                </div>
            </div>

            <div class="important-notes">
                <h4>Important Notes</h4>
                <ul class="notes-list">
                    <li>Please complete the payment within 7 days to confirm your seat</li>
                    <li>Keep your Admission ID (#{{ str_pad($admission->id, 6, '0', STR_PAD_LEFT) }}) for all future
                        communications</li>
                    <li>Submit required documents within 15 days of admission</li>
                    <li>Orientation date will be communicated via email soon</li>
                </ul>
            </div>

            <p
                style="color: #4a5568; font-size: 16px; text-align: center; margin: 30px 0; padding: 20px; background: #f8fafc; border-radius: 12px;">
                We are excited to have you join us! 🎓
            </p>
        </div>

        <div class="footer">
            <div class="logo">{{ config('app.name') }}</div>

            <div class="contact-info">
                <div class="contact-item">
                    <span>📧</span> {{ config('app.email', 'admissions@institute.com') }}
                </div>
                <div class="contact-item">
                    <span>📱</span> {{ config('app.phone', '+91 9876543210') }}
                </div>
                <div class="contact-item">
                    <span>📍</span> {{ config('app.address', '123 Education Street, City') }}
                </div>
            </div>

            <div class="signature">
                Best regards,<br>
                <strong>Admission Department</strong><br>
                {{ config('app.name') }}
            </div>

            <p style="color: #a0aec0; font-size: 12px; margin-top: 25px;">
                This is an automated email. Please do not reply directly to this message.
            </p>
        </div>
    </div>
</body>

</html>
