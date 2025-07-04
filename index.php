<?php 
session_start(); 

include("connect.php");

if (isset($_POST['login'])) {
    $username = $_POST['email'];
    $pwd = md5($_POST['password']);

    $sql = "SELECT * FROM registerform WHERE email = '$username' AND password = '$pwd'";
    $data = mysqli_query($conn, $sql);
    $totall = mysqli_num_rows($data);

    if ($totall == 1) {
        $_SESSION['user_name'] = $username;
        header("Location: profile.php");
        exit();
    } else {
        echo "login failed";
    }
}
?>
<!-- login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">User Login</h2>
  <form method="post" action="#">
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
  </form>

  <!-- New Links -->
  <div class="mt-3 d-flex justify-content-between">
    <a href="forgot_password.php">Forgot Password?</a>
    <a href="register.php">New User? Register</a>
  </div>
</div>
</body>
</html>
