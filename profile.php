<?php 
session_start(); 
include("connect.php");

$userprofile = $_SESSION['user_name'];
if($userprofile == true){
  }else{
   header("Location: login.php");
}
$user_query = "SELECT * FROM `registerform` WHERE email = '$userprofile' LIMIT 1";
$user_result = mysqli_query($conn,$user_query);
$logged_in_user = mysqli_fetch_assoc($user_result);

$query = "SELECT * FROM `registerform`";
$data  = mysqli_query($conn, $query);
?>

<!-- profile.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<div class="container-fluid px-4 py-5">
  <div class="row g-4">

    <!-- Sidebar -->
    <div class="col-lg-4 col-md-5">
      <div class="profile-sidebar text-center border p-3 rounded shadow-sm">
        <img src="uploads/<?php echo ($logged_in_user [ 'profile_image'] ?: 'profile.jpg') ?>" alt="Profile Image" width="120" height="120" class="rounded-circle mb-3" />
       <h4><?php echo htmlspecialchars($logged_in_user['name']); ?></h4>
        <p><?php echo htmlspecialchars($logged_in_user['district']); ?></p>
        <a href="edit.php?id=<?php echo $logged_in_user['id']; ?>" class="btn btn-primary w-100 mt-3">Edit Profile</a>
        <a href="logout.php" class="btn btn-primary w-100 mt-2">Logout</a>
      </div>
    </div>

    <!-- Main content (table of users) -->
    <div class="col-lg-8 col-md-7">
      <div class="card shadow-sm p-4">
        <h4 class="mb-4 text-primary">All Registered Users</h4>
        <div class="table-responsive">
          <table class="table align-middle table-hover">
            <thead class="table-primary">
              <tr>
                <th>SL</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $sl = 1;
              while($row = mysqli_fetch_assoc($data)) { ?>
                <tr>
                  <td><?php echo $sl++; ?></td>
                  <td>
                    <img src="uploads/<?php echo htmlspecialchars($row['profile_image']); ?>" 
                         alt="user" width="40" height="40" class="rounded-circle" />
                  </td>
                  <td><?php echo htmlspecialchars($row['name']); ?></td>
                  <td><?php echo htmlspecialchars($row['email']); ?></td>
                  <td><?php echo htmlspecialchars($row['phone']); ?></td>
                  <td class="action-btns">
                    <a href="view.php?id=<?php echo $row['id']; ?>" title="View" class="text-primary me-2"><i class="bi bi-eye"></i></a>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" title="Edit" class="text-success me-2"><i class="bi bi-pencil"></i></a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" title="Delete" class="text-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

</body>
</html>
