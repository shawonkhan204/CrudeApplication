<?php 

include ("connect.php");

if(isset($_POST['register'])){
  $name          = $_POST['name']; 
  $email         = $_POST['email']; 
  $phone         = $_POST['phone'];
  $password      = md5($_POST['password']);
  $gender        = isset($_POST['gender']) ? $_POST['gender'] : '';
  $message       = $_POST['message']; 
  $dob           = $_POST['dob'];
  $street        = $_POST['street']; 
  $area          = $_POST['area']; 
  $district      = isset($_POST['district']) ? $_POST['district'] : '';
  $hobbies       = isset($_POST['hobbies']) ? implode(",", $_POST['hobbies']) : '';
  $profile_image = $_FILES['profile_image']['name'];
  $nid_passport  = $_FILES['nid_passport']['name'];

  if($name != "" && $email != "" && $phone != "" && $password != "" && $gender != "" && $message != "" && $dob != "" && $street != "" && $area != "" && $district != "") {

    // File size check (Max 2MB)
    $maxSize = 2 * 1024 * 1024;

    if($_FILES['profile_image']['size'] > $maxSize){
      die(" Profile image must be less than 2MB.");
    }

    if($_FILES['nid_passport']['size'] > $maxSize){
      die(" NID/Passport file must be less than 2MB.");
    }

    // Allowed file types
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext1 = strtolower(pathinfo($profile_image, PATHINFO_EXTENSION));
    $ext2 = strtolower(pathinfo($nid_passport, PATHINFO_EXTENSION));

    if(!in_array($ext1, $allowed)){
      die("Invalid profile image format. Allowed: JPG, JPEG, PNG, GIF");
    }

    if(!in_array($ext2, $allowed)){
      die("Invalid NID/Passport file format. Allowed: JPG, JPEG, PNG, GIF");
    }

    // Upload files
    move_uploaded_file($_FILES['profile_image']['tmp_name'], "uploads/" . $profile_image);
    move_uploaded_file($_FILES['nid_passport']['tmp_name'], "uploads/" . $nid_passport);

    // Insert into DB
    $sql = "INSERT INTO registerform (name, email, phone, password, profile_image, gender, hobbies, message, dob, nid_passport, street, area, district)
            VALUES ('$name', '$email', '$phone', '$password', '$profile_image', '$gender', '$hobbies', '$message', '$dob', '$nid_passport', '$street', '$area', '$district')";

    if(mysqli_query($conn, $sql)) {
      echo "✅ Registration successful!";
    header("Location: thankyou.php");
    } else {
      echo " Error: " . mysqli_error($conn);
    }

  } else {
    echo " <script>alert('Please fill in all required fields')</script>";
  }
}

?>




<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Curd Application</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap & Custom CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container" >
    <h2>User Registration</h2>
    <form action="" method="POST" enctype="multipart/form-data" novalidate>
      <div class="row g-4">
        <!-- Name -->
        <div class="col-md-6">
          <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
          <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" required />
        </div>

        <!-- Email -->
        <div class="col-md-6">
          <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" id="email" name="email" class="form-control" placeholder="example@mail.com" required />
        </div>

        <!-- Phone -->
        <div class="col-md-6">
          <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
          <input type="tel" id="phone" name="phone" class="form-control" placeholder="" required />
        </div>

        <!-- Password -->
        <div class="col-md-6">
          <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Create password" required />
        </div>

        <!-- Profile Image -->
        <div class="col-md-6">
          <label for="profile_image" class="form-label">Profile Image <small>(Max 2MB, jpg/png/jpeg/gif)</small></label>
          <input type="file" id="profile_image" name="profile_image" class="form-control" accept=".jpg,.jpeg,.png,.gif"  >
        </div>

        <!-- Gender -->
        <div class="col-md-6">
          <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
          <select id="gender" name="gender" class="form-select" required>
            <option value="" disabled selected>Select gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <!-- Hobbies -->
        <div class="col-12 hobbies-group">
          <label class="form-label d-block">Hobbies</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="hobby_reading" name="hobbies[]" value="Reading" />
            <label class="form-check-label" for="hobby_reading">Reading</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="hobby_traveling" name="hobbies[]" value="Traveling" />
            <label class="form-check-label" for="hobby_traveling">Traveling</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="hobby_gaming" name="hobbies[]" value="Gaming" />
            <label class="form-check-label" for="hobby_gaming">Gaming</label>
          </div>
        </div>

        <!-- Message -->
        <div class="col-12">
          <label for="message" class="form-label">Message</label>
          <textarea id="message" name="message" rows="3" class="form-control" placeholder="Write something about yourself..."></textarea>
        </div>

        <!-- Date of Birth -->
        <div class="col-md-6">
          <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
          <input type="date" id="dob" name="dob" class="form-control" required />
        </div>

        <!-- NID/Passport -->
        <div class="col-md-6">
          <label for="nid_passport" class="form-label">NID / Passport <small>(Max 2MB, jpg/png/jpeg/gif)</small></label>
          <input type="file" id="nid_passport" name="nid_passport" class="form-control" accept=".jpg,.jpeg,.png,.gif"  >
        </div>

        <!-- Street -->
        <div class="col-md-4">
          <label for="street" class="form-label">Street <span class="text-danger">*</span></label>
          <input type="text" id="street" name="street" class="form-control" placeholder="Street address" required />
        </div>

        <!-- Area -->
        <div class="col-md-4">
          <label for="area" class="form-label">Area <span class="text-danger">*</span></label>
          <input type="text" id="area" name="area" class="form-control" placeholder="Area" required />
        </div>

        <!-- District -->
        <div class="col-md-4">
          <label for="district" class="form-label">District <span class="text-danger">*</span></label>
          <select id="district" name="district" class="form-select" required>
            <option value="" disabled selected>Select district</option>
            <option value="Dhaka">Dhaka</option>
            <option value="Chattogram">Chattogram</option>
            <option value="Khulna">Khulna</option>
            <option value="Rajshahi">Rajshahi</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary mt-4" name="register">Register Now</button>
    </form>
  </div>
</body>
</html>
