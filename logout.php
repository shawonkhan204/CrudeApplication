<?php 

session_start();

session_unset();

?>

<!-- logout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logout</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5 text-center">
  <h3>You have been logged out.</h3>
  <a href="login.php" class="btn btn-primary mt-3">Login Again</a>
</div>
</body>
</html>
