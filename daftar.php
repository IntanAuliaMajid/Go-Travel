<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Wonderfull World</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            display: flex;
            width: 900px;
            height: 650px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            overflow: hidden;
            background-color: white;
        }

        .left-side {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .right-side {
            flex: 1;
            background: linear-gradient(rgba(0, 97, 158, 0.7), rgba(4, 147, 190, 0.7)), 
                        url('/api/placeholder/800/800') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .logo {
            margin-bottom: 30px;
        }

        .logo img {
            height: 35px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 25px;
            color: #333;
        }

        .sub-heading {
            font-size: 16px;
            margin-bottom: 30px;
            color: #666;
        }

        .input-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
            flex: 1;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .input-field {
            width: 100%;
            padding: 14px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #0493be;
            outline: none;
            box-shadow: 0 0 0 2px rgba(4, 147, 190, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .checkbox-group input {
            margin-right: 10px;
            width: 16px;
            height: 16px;
            accent-color: #0493be;
        }

        .checkbox-group label {
            font-size: 14px;
            color: #555;
        }

        .checkbox-group a {
            color: #0493be;
            text-decoration: none;
        }

        .checkbox-group a:hover {
            text-decoration: underline;
        }

        .signup-btn {
            width: 100%;
            padding: 15px;
            background-color: #0493be;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .signup-btn:hover {
            background-color: #00617e;
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        .login-link a {
            color: #0493be;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .social-signup {
            margin-top: 25px;
            text-align: center;
        }

        .social-signup p {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
            position: relative;
        }

        .social-signup p::before,
        .social-signup p::after {
            content: "";
            display: block;
            width: 30%;
            height: 1px;
            background-color: #e0e0e0;
            position: absolute;
            top: 50%;
        }

        .social-signup p::before {
            left: 0;
        }

        .social-signup p::after {
            right: 0;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f7fa;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: #e0e0e0;
        }

        .right-side h2 {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .right-side p {
            font-size: 16px;
            margin-bottom: 30px;
            max-width: 80%;
        }

        .features {
            margin-top: 20px;
            text-align: left;
            width: 80%;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .feature-icon {
            margin-right: 12px;
            width: 22px;
            height: 22px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-text {
            font-size: 14px;
        }

        @media (max-width: 900px) {
            .container {
                width: 95%;
                flex-direction: column;
                height: auto;
            }

            .right-side {
                display: none;
            }

            .input-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-side">
            <div class="logo">
                <img src="/api/placeholder/140/35" alt="Wonderfull World Logo">
            </div>
            <h1>Create an Account</h1>
            <form>
                <div class="input-row">
                    <div class="input-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" class="input-field" placeholder="Enter your first name" required>
                    </div>
                    <div class="input-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" class="input-field" placeholder="Enter your last name" required>
                    </div>
                </div>
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" class="input-field" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="input-field" placeholder="Create a password" required>
                </div>
                <div class="input-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" class="input-field" placeholder="Confirm your password" required>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                </div>
                <button type="submit" class="signup-btn">Sign Up</button>
            </form>
            <div class="login-link">
                Already have an account? <a href="login.php">Log in</a>
            </div>
            <div class="social-signup">
                <p>Or sign up with</p>
                <div class="social-icons">
                    <div class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#1877F2">
                            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
                        </svg>
                    </div>
                    <div class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#DB4437">
                            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2.917 16.083c-2.258 0-4.083-1.825-4.083-4.083s1.825-4.083 4.083-4.083c1.103 0 2.024.402 2.735 1.067l-1.107 1.068c-.304-.292-.834-.63-1.628-.63-1.394 0-2.531 1.155-2.531 2.579 0 1.424 1.138 2.579 2.531 2.579 1.616 0 2.224-1.162 2.316-1.762h-2.316v-1.4h3.855c.036.204.064.408.064.677.001 2.332-1.563 3.988-3.919 3.988zm9.917-3.5h-1.75v1.75h-1.167v-1.75h-1.75v-1.166h1.75v-1.75h1.167v1.75h1.75v1.166z"/>
                        </svg>
                    </div>
                    <div class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#000000">
                            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm-3.5 8c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5-.672-1.5-1.5-1.5zm7 0c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5-.672-1.5-1.5-1.5zm-3.5 6.433c2.275 0 4.118-1.843 4.357-4.151l-1.993-.363c-.132 1.433-1.322 2.514-2.364 2.514-1.041 0-2.232-1.081-2.364-2.514l-1.993.363c.239 2.309 2.082 4.151 4.357 4.151z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-side">
            <h2>GO-Travel</h2>
            <p>Bergabunglah dengan komunitas pelancong kami dari seluruh dunia.</p>
            
            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white">
                            <path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/>
                        </svg>
                    </div>
                    <div class="feature-text">Dapatkan penawaran perjalanan eksklusif.</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white">
                            <path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/>
                        </svg>
                    </div>
                    <div class="feature-text">Buat rencana perjalanan yang dipersonalisasi.</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white">
                            <path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/>
                        </svg>
                    </div>
                    <div class="feature-text">Jalin koneksi dengan para traveler</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white">
                            <path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/>
                        </svg>
                    </div>
                    <div class="feature-text">Nikmati tips dan panduan perjalanan eksklusif hanya untukmu!</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>