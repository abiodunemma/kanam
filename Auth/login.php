<?php 
include '../config/db.php';
session_start(); ?>

<!-- 
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    </head>
    <body>
        <form action="login_process.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
    </body>
</html>
</body -->



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="/assets/css/login.css" />
</head>
<body>

  <div class="login-wrapper">

    <!-- LEFT: Logo / Branding -->
    <div class="login-left">
      <div class="brand">
        <img src="/assets/img/Logo-2.png" alt="Company Logo" class="logo" />
       
        <p class="brand-tagline">Welcome back. Sign in to continue.</p>
      </div>
    </div>

    <!-- RIGHT: Login Form -->
    <div class="login-right">
      <div class="form-card">
        <h2 class="form-title">Sign In</h2>
        <p class="form-subtitle">Enter your credentials to access your account</p>

        <!-- ACTION points to your PHP handler -->
       <form action="login_process.php" method="post">

          <div class="form-group">
            <label for="email">Email Address</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="you@example.com"
              required
              autocomplete="email"
            />
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="••••••••"
              required
              autocomplete="current-password"
            />
          </div>

          <div class="form-options">
            <label class="remember-me">
              <input type="checkbox" name="remember" /> Remember me
            </label>
            <a href="forgot-password.php" class="forgot-link">Forgot password?</a>
          </div>

          <button type="submit" class="btn-login">Sign In</button>

        </form>

        <p class="register-link">
          Don't have an account? <a href="register.php">Create one</a>
        </p>
      </div>
    </div>

  </div>

</body>
</form>
</html>

