<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --secondary-color: #f3f4f6;
            --text-color: #374151;
            --error-color: #ef4444;
        }

        body {
            background-color: #f9fafb;
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            max-width: 450px;
            width: 100%;
            padding: 2rem;
            margin: 2rem auto;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header h1 {
            font-weight: 700;
            font-size: 1.875rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: #6b7280;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
        }

        .auth-footer a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .invalid-feedback {
            color: var(--error-color);
            font-size: 0.875rem;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            color: #6b7280;
        }

        .form-floating>label {
            padding-left: 1rem;
        }

        .form-floating>.form-control {
            padding: 1rem;
            height: calc(3.5rem + 2px);
        }

        .password-container {
            position: relative;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 0.5rem;
        }

        .forgot-password {
            text-align: right;
        }

        .social-login {
            margin-top: 2rem;
            text-align: center;
        }

        .social-login p {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .social-login p:before,
        .social-login p:after {
            content: "";
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background-color: #e5e7eb;
        }

        .social-login p:before {
            left: 0;
        }

        .social-login p:after {
            right: 0;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .social-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }

        .social-button:hover {
            background-color: #f3f4f6;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="Email Address" value="{{ old('email') }}" required
                        autocomplete="username">
                    <label for="email">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-floating mb-3 password-container">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Password" required autocomplete="current-password">
                    <label for="password">Password</label>
                    <span class="password-toggle" onclick="togglePassword('password')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye" viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                        </svg>
                    </span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <div class="remember-me">
                            <input type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Remember me</label>
                        </div>
                    </div>
                    <div class="col-6 forgot-password">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Sign In</button>
                </div>

                <div class="auth-footer">
                    Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                </div>

                <div class="social-login">
                    <p><span class="px-2">Or continue with</span></p>
                    <div class="social-buttons">
                        <a href="#" class="social-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="#DB4437">
                                <path
                                    d="M7.8,13.4H12V16.4H7.8C6.8,16.4 6,15.6 6,14.6C6,13.6 6.8,12.8 7.8,12.8C7.8,12.8 7.8,13.4 7.8,13.4M13,11.2H7.8V8.2H13M18,14.6C18,15.6 17.2,16.4 16.2,16.4C15.2,16.4 14.4,15.6 14.4,14.6C14.4,13.6 15.2,12.8 16.2,12.8C17.2,12.8 18,13.6 18,14.6M7.8,4C11.2,4 14.4,5.2 16.8,7.2L14,10C12.8,9.2 10.6,8 7.8,8C3.6,8 0,11.6 0,16C0,20.4 3.6,24 7.8,24C12,24 14.4,21.4 15.6,18.2H7.8V14.2H20V16C20,20.4 16.4,24 12,24C7.6,24 4,20.4 4,16C4,11.6 7.6,8 12,8C13.6,8 15,8.6 16.2,9.4L19.4,6.2C17.2,4.2 14.2,3 11,3H7.8" />
                            </svg>
                        </a>
                        <a href="#" class="social-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="#1877F2">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="social-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="#000000">
                                <path
                                    d="M22.2125 5.65605C21.4491 5.99375 20.6395 6.21555 19.8106 6.31411C20.6839 5.79132 21.3374 4.9689 21.6493 4.00005C20.8287 4.48761 19.9305 4.83077 18.9938 5.01461C18.2031 4.17106 17.098 3.66555 15.9418 3.66555C13.6326 3.66555 11.7597 5.52702 11.7597 7.82216C11.7597 8.14716 11.7973 8.47029 11.8676 8.77955C8.39047 8.60841 5.31007 6.95841 3.24678 4.45893C2.87784 5.09261 2.67191 5.79132 2.67191 6.53748C2.67191 7.95225 3.24678 9.21939 4.14287 9.97811C3.41894 9.95452 2.72579 9.75841 2.11596 9.43384C2.11596 9.45175 2.11596 9.47152 2.11596 9.49112C2.11596 11.5284 3.57564 13.2325 5.49207 13.6125C5.13404 13.7055 4.76261 13.7496 4.37495 13.7496C3.99949 13.7496 3.6808 13.7228 3.36584 13.6619C4.00949 15.3392 5.57132 16.5477 7.38904 16.5889C5.9397 17.7013 4.13291 18.3562 2.20728 18.3562C1.85936 18.3562 1.51854 18.3367 1.17773 18.2937C3.00147 19.4772 5.14818 20.134 7.41749 20.134C15.9418 20.134 20.5439 13.8161 20.5439 8.30073C20.5439 8.12452 20.5439 7.94995 20.5338 7.77452C21.3635 7.1839 22.0916 6.45877 22.6999 5.63048C22.6999 5.63048 22.6999 5.63048 22.2125 5.65605Z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle eye icon
            const eyeIcon = event.currentTarget.querySelector('svg');
            if (type === 'text') {
                eyeIcon.innerHTML = `
                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                    <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                `;
            }
        }
    </script>
</body>

</html>
