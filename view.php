<?php 
include("connect.php");

$id = $_GET['id'];
$sql = "SELECT * FROM registerform WHERE id = $id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!-- view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View User</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
  <h3 class="mb-4 text-primary">User Details</h3>
  <div class="card p-4 shadow-sm">
    <div class="text-center mb-3">
      <img src="uploads/<?php echo htmlspecialchars($user['profile_image'] ?: 'profile.jpg'); ?>" 
           class="img-thumbnail rounded-circle" width="150" height="150" alt="User Image">
    </div>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
    <p><strong>Hobbies:</strong> <?php echo htmlspecialchars($user['hobbies']); ?></p>
    <p><strong>Message:</strong> <?php echo htmlspecialchars($user['message']); ?></p>
    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
    <p><strong>Address:</strong>
      <?php 
        echo htmlspecialchars($user['street']) . ", " . 
             htmlspecialchars($user['area']) . ", " . 
             htmlspecialchars($user['district']); 
      ?>
    </p>
    <a href="profile.php" class="btn btn-primary  mt-3">Back to List</a>
  </div>
</div>
</body>
</html>