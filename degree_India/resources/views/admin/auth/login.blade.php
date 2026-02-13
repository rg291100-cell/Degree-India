<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Degree India - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-blue: #1d4ed8;
            --light-blue: #eff6ff;
            --accent-blue: #3b82f6;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --border-color: #cbd5e1;
            --error-red: #ef4444;
            --success-green: #10b981;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            display: flex;
            width: 1000px;
            min-height: 580px;
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(37, 99, 235, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .left-section {
            background: linear-gradient(145deg, var(--primary-blue), var(--secondary-blue));
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
            position: relative;
            overflow: hidden;
        }

        .left-section::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            top: -100px;
            left: -100px;
        }

        .left-section::after {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            bottom: -80px;
            right: -80px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            z-index: 2;
        }

        .logo-icon {
            font-size: 32px;
            color: white;
            background: rgba(255, 255, 255, 0.15);
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .logo-text {
            font-size: 28px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }

        .left-content {
            color: white;
            max-width: 380px;
            text-align: center;
            z-index: 2;
        }

        .left-content h1 {
            font-size: 2.5rem;
            margin-bottom: 24px;
            font-weight: 800;
            line-height: 1.2;
        }

        .left-content p {
            font-size: 1.15rem;
            line-height: 1.7;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .features-list {
            text-align: left;
            margin-top: 30px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            font-size: 1rem;
        }

        .feature-icon {
            background: rgba(255, 255, 255, 0.2);
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .right-section {
            width: 50%;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: var(--white);
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-title {
            font-size: 2.4rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--text-dark);
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-subtitle {
            color: var(--text-light);
            font-size: 1.1rem;
            line-height: 1.5;
        }

        /* Role Selection Styles */
        .role-selection {
            margin-bottom: 20px;
        }

        .role-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .role-options {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .role-option {
            flex: 1;
            min-width: 120px;
        }

        .role-radio {
            display: none;
        }

        .role-label-card {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 16px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            background: var(--light-blue);
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            color: var(--text-dark);
            text-align: center;
        }

        .role-radio:checked+.role-label-card {
            border-color: var(--primary-blue);
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .role-label-card:hover {
            border-color: var(--primary-blue);
            transform: translateY(-2px);
        }

        .role-icon {
            font-size: 18px;
        }

        .login-form {
            width: 100%;
        }

        .input-group {
            margin-bottom: 28px;
            position: relative;
        }

        .input-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 16px 20px;
            padding-right: 50px;
            border-radius: 12px;
            border: 2px solid var(--border-color);
            font-size: 1rem;
            transition: all 0.3s;
            background-color: var(--light-blue);
            color: var(--text-dark);
        }

        .input-wrapper input:focus {
            border-color: var(--primary-blue);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            background-color: white;
        }

        .input-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            cursor: pointer;
            transition: color 0.3s;
        }

        .input-icon:hover {
            color: var(--primary-blue);
        }

        .forgot-password {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .forgot-password a {
            color: var(--primary-blue);
            font-size: 0.95rem;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .forgot-password a:hover {
            color: var(--secondary-blue);
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            height: 54px;
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            font-size: 1.1rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s;
            font-weight: 700;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }

        .login-btn:hover {
            background: linear-gradient(90deg, var(--secondary-blue), #1e40af);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Alert styling */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 2px solid #fecaca;
            color: #991b1b;
        }

        .alert-success {
            background-color: #f0fdf4;
            border: 2px solid #bbf7d0;
            color: #166534;
        }

        .alert-icon {
            font-size: 20px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .login-container {
                flex-direction: column;
                width: 95vw;
                max-width: 500px;
            }

            .left-section,
            .right-section {
                width: 100%;
            }

            .left-section {
                min-height: 300px;
                padding: 40px 30px;
            }

            .right-section {
                padding: 40px 30px;
            }

            .login-title {
                font-size: 2rem;
            }

            .left-content h1 {
                font-size: 2rem;
            }

            .role-options {
                flex-direction: column;
            }

            .role-option {
                min-width: 100%;
            }
        }

        @media (max-width: 480px) {

            .left-section,
            .right-section {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="left-section">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="mdi mdi-school"></i>
                </div>
                <div class="logo-text">Degree India</div>
            </div>

            <div class="left-content">
                <h1>Welcome Back!</h1>
                <p>Access your personalized dashboard to manage your education journey.</p>

                <div class="features-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="mdi mdi-book-open-variant"></i>
                        </div>
                        <span>Browse Courses & Colleges</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="mdi mdi-account-tie-voice"></i>
                        </div>
                        <span>Connect with Experts</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="mdi mdi-chart-timeline-variant"></i>
                        </div>
                        <span>Track Your Progress</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="mdi mdi-bell-ring"></i>
                        </div>
                        <span>Get Personalized Updates</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-section">
            <div class="login-header">
                <div class="login-title">Login to Degree India</div>
                <div class="login-subtitle">Sign in to access your account</div>
            </div>

            <!-- Error Messages -->
            @if (session('error'))
                <div class="alert alert-error">
                    <i class="mdi mdi-alert-circle alert-icon"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="mdi mdi-check-circle alert-icon"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="mdi mdi-alert-circle alert-icon"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.loginSubmit') }}" class="login-form">
                @csrf
                <div class="input-group">
                    <label class="input-label">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}"
                            required>
                        <i class="mdi mdi-email-outline input-icon"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" placeholder="Enter your password"
                            required>
                        <i class="mdi mdi-eye-outline input-icon" id="togglePassword"></i>
                    </div>
                </div>



                <button type="submit" class="login-btn">
                    <i class="mdi mdi-login"></i>
                    Sign In to Your Account
                </button>


            </form>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle eye icon
            this.classList.toggle('mdi-eye-outline');
            this.classList.toggle('mdi-eye-off-outline');
        });

        // Add focus effects to inputs
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Handle form submission with role-based redirect
        const loginForm = document.querySelector('.login-form');
        loginForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.login-btn');
            const originalText = submitBtn.innerHTML;
            const role = document.querySelector('input[name="role"]:checked').value;

            submitBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Signing In...';
            submitBtn.disabled = true;

            // Store role in session for redirect
            sessionStorage.setItem('selectedRole', role);

            // Reset after 2 seconds (simulating API call)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });

        // Dynamically update form action based on role selection
        const roleRadios = document.querySelectorAll('input[name="role"]');
        roleRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                // You can change form action based on role if needed
                const role = this.value;
                console.log('Selected role:', role);
            });
        });
    </script>
</body>

</html>
