<?php

include("connect.php");

session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM registerform WHERE id = $id";
    $data = mysqli_query($conn, $sql);

    if ($data) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Failed to delete user.";
    }
} else {
    echo "Invalid request. ID not found.";
}
?>
