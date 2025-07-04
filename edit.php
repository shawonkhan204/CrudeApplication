<?php 

session_start();

include("connect.php");

if(isset($_GET['id'])){
  
$userprofile = $_SESSION['user_name'];

if($userprofile == true){
  
}else{
   header("Location: login.php");
}
  $id = $_GET['id'];

  $sql = "SELECT * FROM `registerform` WHERE  id = $id";

  $result = mysqli_query($conn,$sql);

  $data = mysqli_fetch_assoc($result);
}
  
if (isset($_POST['register'])) {
  $name     = $_POST['name'];
  $email    = $_POST['email'];
  $phone    = $_POST['phone'];
  $password = $_POST['password'];
  $gender   = $_POST['gender'];
  $dob      = $_POST['dob'];
  $street   = $_POST['street'];
  $area     = $_POST['area'];
  $district = $_POST['district'];
  $message  = $_POST['message'];
  $hobbies  = implode(",", $_POST['hobbies']);

  // Handle image uploads (only update if new image uploaded)
  $profile_image = $data['profile_image'];
  if (!empty($_FILES['profile_image']['name'])) {
    $profile_image = time() . '_' . $_FILES['profile_image']['name'];
    move_uploaded_file($_FILES['profile_image']['tmp_name'], 'uploads/' . $profile_image);
  }

  $nid_passport = $data['nid_passport'];
  if (!empty($_FILES['nid_passport']['name'])) {
    $nid_passport = time() . '_' . $_FILES['nid_passport']['name'];
    move_uploaded_file($_FILES['nid_passport']['tmp_name'], 'uploads/' . $nid_passport);
  }

  $update = "UPDATE registerform SET 
    name='$name',
    email='$email',
    phone='$phone',
    password='$password',
    gender='$gender',
    dob='$dob',
    street='$street',
    area='$area',
    district='$district',
    message='$message',
    hobbies='$hobbies',
    profile_image='$profile_image',
    nid_passport='$nid_passport'
    WHERE id = $id";

  $result = mysqli_query($conn, $update);

  if ($result) {
    echo "<script>alert('User profile updated successfully!');</script>";
    header("Location: profile.php");
  } else {
    echo "<script>alert('Failed to update user!');</script>";
  }
}


?>


<!-- edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
  <h3 class="h3">Edit User Profile</h3>
  <form action="" method="POST" enctype="multipart/form-data" novalidate>
      <div class="row g-4">
        <!-- Name -->
        <div class="col-md-6">
          <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
          <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name"  value="<?= $data['name'] ?>" required />
        </div>

        <!-- Email -->
        <div class="col-md-6">
          <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" id="email" name="email" class="form-control" placeholder="example@mail.com"  value="<?= $data['email'] ?>" required />
        </div>

        <!-- Phone -->
        <div class="col-md-6">
          <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
          <input type="tel" id="phone" name="phone" class="form-control" placeholder="phone" value="<?= $data['phone'] ?>" required />
        </div>

        <!-- Password -->
        <div class="col-md-6">
          <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Create password" value="<?= $data['password'] ?>" required />
        </div>

        <!-- Profile Image -->
        <div class="col-md-6">
          <label for="profile_image" class="form-label">Profile Image <small>(Max 2MB, jpg/png/jpeg/gif)</small></label>
          <input type="file" id="profile_image" name="profile_image" class="form-control" accept=".jpg,.jpeg,.png,.gif">
          <?php if (!empty($data['profile_image'])): ?>
            <div class="mt-2">
              <img src="uploads/<?= $data['profile_image'] ?>" alt="Profile Image" width="120" height="120" style="object-fit: cover; border-radius: 6px;">
            </div>
          <?php endif; ?>

        </div>

        <!-- Gender -->
        <div class="col-md-6">
          <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
          <select id="gender" name="gender" class="form-select" required>
            <option value="" disabled <?= empty($data['gender']) ? 'selected' : '' ?>>Select gender</option>
            <option value="Male" <?= ($data['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= ($data['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= ($data['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
          </select>
        </div>

        <!-- Hobbies -->
        <?php $hobbyList = explode(',', $data['hobbies']); ?>
        <div class="col-12 hobbies-group">
          <label class="form-label d-block">Hobbies</label>

          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="hobby_reading" name="hobbies[]" value="Reading" <?= in_array("Reading", $hobbyList) ? "checked" : "" ?>>
            <label class="form-check-label" for="hobby_reading">Reading</label>
          </div>

          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="hobby_traveling" name="hobbies[]" value="Traveling" <?= in_array("Traveling", $hobbyList) ? "checked" : "" ?>>
            <label class="form-check-label" for="hobby_traveling">Traveling</label>
          </div>

          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="hobby_gaming" name="hobbies[]" value="Gaming" <?= in_array("Gaming", $hobbyList) ? "checked" : "" ?>>
            <label class="form-check-label" for="hobby_gaming">Gaming</label>
          </div>
        </div>

        <!-- Message -->
        <div class="col-12">
          <label for="message" class="form-label">Message</label>
          <textarea id="message" name="message" rows="3" class="form-control" placeholder="Write something about yourself..."><?= $data['message'] ?></textarea>
        </div>

        <!-- Date of Birth -->
        <div class="col-md-6">
          <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
          <input type="date" id="dob" name="dob" class="form-control" required value="<?= $data['dob'] ?>"/>
        </div>

        <!-- NID/Passport -->
        <div class="col-md-6">
          <label for="nid_passport" class="form-label">NID / Passport <small>(Max 2MB, jpg/png/jpeg/gif)</small></label>
          <input type="file" id="nid_passport" name="nid_passport" class="form-control" accept=".jpg,.jpeg,.png,.gif">
          <?php if (!empty($data['nid_passport'])): ?>
            <div class="mt-2">
             <img src="uploads/<?= $data['nid_passport'] ?>" alt="NID/Passport" width="120" height="120" style="object-fit: cover; border-radius: 6px;">
           </div>
<?php endif; ?>

        </div>

        <!-- Street -->
        <div class="col-md-4">
          <label for="street" class="form-label">Street <span class="text-danger">*</span></label>
          <input type="text" id="street" name="street" class="form-control" placeholder="Street address" required value="<?= $data['street'] ?>"/>
        </div>

        <!-- Area -->
        <div class="col-md-4">
          <label for="area" class="form-label">Area <span class="text-danger">*</span></label>
          <input type="text" id="area" name="area" class="form-control" placeholder="Area" required value="<?= $data['area'] ?>"/>
        </div>

        <!-- District -->
        <div class="col-md-4">
          <label for="district" class="form-label">District <span class="text-danger">*</span></label>
          <select id="district" name="district" class="form-select" required>
            <option value="" disabled <?= empty($data['district']) ? 'selected' : '' ?>>Select district</option>
            <option value="Dhaka" <?= ($data['district'] == 'Dhaka') ? 'selected' : '' ?>>Dhaka</option>
            <option value="Chattogram" <?= ($data['district'] == 'Chattogram') ? 'selected' : '' ?>>Chattogram</option>
            <option value="Khulna" <?= ($data['district'] == 'Khulna') ? 'selected' : '' ?>>Khulna</option>
            <option value="Rajshahi" <?= ($data['district'] == 'Rajshahi') ? 'selected' : '' ?>>Rajshahi</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary mt-4" name="register">Update Now</button>
    </form>
</div>
</body>
</html>

