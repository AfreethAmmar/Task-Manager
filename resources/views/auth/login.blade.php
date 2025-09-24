<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign In - Your App</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      line-height: 1.6;
    }

    .container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.2);
      padding: 48px;
      width: 100%;
      max-width: 440px;
      position: relative;
      overflow: hidden;
    }

    .container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
      background-size: 200% 100%;
      animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
      0%, 100% { background-position: 200% 0; }
      50% { background-position: -200% 0; }
    }

    .logo {
      text-align: center;
      margin-bottom: 32px;
    }

    .logo-icon {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: 16px;
      margin: 0 auto 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    }

    .logo-icon::after {
      content: '🔐';
      font-size: 24px;
      filter: brightness(0) invert(1);
    }

    h1 {
      font-size: 28px;
      font-weight: 700;
      color: #1a1a1a;
      text-align: center;
      margin-bottom: 8px;
      letter-spacing: -0.5px;
    }

    .subtitle {
      color: #6b7280;
      text-align: center;
      margin-bottom: 32px;
      font-size: 15px;
    }

    .errors {
      background: linear-gradient(135deg, #fef2f2, #fee2e2);
      border: 1px solid #fca5a5;
      color: #dc2626;
      padding: 16px;
      margin-bottom: 24px;
      border-radius: 12px;
      font-size: 14px;
      animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .errors ul {
      list-style: none;
      margin: 0;
    }

    .errors li {
      position: relative;
      padding-left: 20px;
    }

    .errors li::before {
      content: '⚠';
      position: absolute;
      left: 0;
      top: 0;
    }

    form {
      display: grid;
      gap: 24px;
    }

    .form-group {
      display: grid;
      gap: 8px;
    }

    label {
      font-weight: 600;
      color: #374151;
      font-size: 14px;
      letter-spacing: 0.025em;
    }

    .input-wrapper {
      position: relative;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 16px;
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      font-size: 16px;
      transition: all 0.2s ease;
      background: #fff;
      color: #1a1a1a;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      transform: translateY(-1px);
    }

    input[type="email"]:hover,
    input[type="password"]:hover {
      border-color: #d1d5db;
    }

    .checkbox-wrapper {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 8px 0;
    }

    input[type="checkbox"] {
      width: 18px;
      height: 18px;
      accent-color: #667eea;
      cursor: pointer;
    }

    .checkbox-label {
      font-size: 14px;
      color: #6b7280;
      cursor: pointer;
      font-weight: 500;
    }

    .submit-btn {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none;
      padding: 16px 24px;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
      letter-spacing: 0.025em;
      margin-top: 8px;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
    }

    .submit-btn:active {
      transform: translateY(0);
    }

    .divider {
      text-align: center;
      margin: 32px 0 24px;
      position: relative;
      color: #9ca3af;
      font-size: 14px;
    }

    .divider::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 1px;
      background: #e5e7eb;
    }

    .divider span {
      background: rgba(255, 255, 255, 0.95);
      padding: 0 16px;
    }

    .register-link {
      text-align: center;
      color: #6b7280;
      font-size: 14px;
    }

    .register-link a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .register-link a:hover {
      color: #764ba2;
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .container {
        padding: 32px 24px;
        margin: 20px;
        border-radius: 16px;
      }
      
      h1 {
        font-size: 24px;
      }
      
      .submit-btn {
        padding: 14px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <div class="logo-icon"></div>
      <h1>Welcome back</h1>
      <p class="subtitle">Sign in to your account to continue</p>
    </div>

    @if ($errors->any())
      <div class="errors">
        <ul>
          @foreach ($errors->all() as $e) 
            <li>{{ $e }}</li> 
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      
      <div class="form-group">
        <label for="email">Email address</label>
        <div class="input-wrapper">
          <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrapper">
          <input type="password" id="password" name="password" required placeholder="Enter your password">
        </div>
      </div>

      <div class="checkbox-wrapper">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember" class="checkbox-label">Keep me signed in</label>
      </div>

      <button type="submit" class="submit-btn">
        Sign in
      </button>
    </form>

    <div class="divider">
      <span>Don't have an account?</span>
    </div>

    <div class="register-link">
      <a href="{{ route('register') }}">Create your account</a>
    </div>
  </div>
</body>
</html>