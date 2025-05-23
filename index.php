<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hotel Management | Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/login.css">
  <link rel="stylesheet" href="./css/flash.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
</head>

<body>
<section id="auth_section">
  <div class="logo">
    <img src="./image/hotellogo.png" alt="Hotel Logo" class="bluebirdlogo">
    <p>Hotel Management</p>
  </div>

  <div class="auth_container">
    <div id="Log_in">
      <h2>Login</h2>

      <div class="role_btn">
        <div class="btns active">User</div>
        <div class="btns">Admin</div>
      </div>

      <?php
      if (isset($_POST['user_login_submit'])) {
        $email = $_POST['Email'];
        $password = $_POST['Password'];

        $query = mysqli_query($conn, "SELECT * FROM signup WHERE Email = '$email' AND Password = BINARY '$password'");
        if ($query->num_rows > 0) {
          $_SESSION['usermail'] = $email;
          header("Location: home.php");
        } else {
          echo "<script>swal({ title: 'Invalid login', icon: 'error' });</script>";
        }
      }
      ?>

      <form method="POST" class="user_login authsection active">
        <div class="form-floating">
          <input type="text" class="form-control" name="Username" placeholder=" ">
          <label>Username</label>
        </div>
        <div class="form-floating">
          <input type="email" class="form-control" name="Email" placeholder=" ">
          <label>Email</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" name="Password" placeholder=" ">
          <label>Password</label>
        </div>
        <button type="submit" name="user_login_submit" class="auth_btn">Log in</button>
        <div class="footer_line">
          <h6>Don't have an account? <span class="page_move_btn" onclick="signuppage()">Sign up</span></h6>
        </div>
      </form>

      <?php
      if (isset($_POST['Emp_login_submit'])) {
        $email = $_POST['Emp_Email'];
        $password = $_POST['Emp_Password'];

        $query = mysqli_query($conn, "SELECT * FROM emp_login WHERE Emp_Email = '$email' AND Emp_Password = BINARY '$password'");
        if ($query->num_rows > 0) {
          $_SESSION['usermail'] = $email;
          header("Location: admin/admin.php");
        } else {
          echo "<script>swal({ title: 'Invalid login', icon: 'error' });</script>";
        }
      }
      ?>

      <form method="POST" class="employee_login authsection">
        <div class="form-floating">
          <input type="email" class="form-control" name="Emp_Email" placeholder=" ">
          <label>Email</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" name="Emp_Password" placeholder=" ">
          <label>Password</label>
        </div>
        <button type="submit" name="Emp_login_submit" class="auth_btn">Log in</button>
      </form>
    </div>

    <?php
    if (isset($_POST['user_signup_submit'])) {
      $username = $_POST['Username'];
      $email = $_POST['Email'];
      $password = $_POST['Password'];
      $confirm = $_POST['CPassword'];

      if ($username === "" || $email === "" || $password === "") {
        echo "<script>swal({ title: 'Please fill in all fields', icon: 'error' });</script>";
      } else if ($password !== $confirm) {
        echo "<script>swal({ title: 'Passwords do not match', icon: 'error' });</script>";
      } else {
        $check = mysqli_query($conn, "SELECT * FROM signup WHERE Email = '$email'");
        if ($check->num_rows > 0) {
          echo "<script>swal({ title: 'Email already registered', icon: 'error' });</script>";
        } else {
          $insert = mysqli_query($conn, "INSERT INTO signup (Username, Email, Password) VALUES ('$username', '$email', '$password')");
          if ($insert) {
            $_SESSION['usermail'] = $email;
            header("Location: home.php");
          } else {
            echo "<script>swal({ title: 'Signup failed. Try again.', icon: 'error' });</script>";
          }
        }
      }
    }
    ?>

    <div id="sign_up">
      <h2>Sign Up</h2>
      <form method="POST" class="user_signup">
        <div class="form-floating">
          <input type="text" class="form-control" name="Username" placeholder=" ">
          <label>Username</label>
        </div>
        <div class="form-floating">
          <input type="email" class="form-control" name="Email" placeholder=" ">
          <label>Email</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" name="Password" placeholder=" ">
          <label>Password</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" name="CPassword" placeholder=" ">
          <label>Confirm Password</label>
        </div>
        <button type="submit" name="user_signup_submit" class="auth_btn">Sign up</button>
        <div class="footer_line">
          <h6>Already have an account? <span class="page_move_btn" onclick="loginpage()">Log in</span></h6>
        </div>
      </form>
    </div>
  </div>
</section>

<section class="carousel_section carousel slide" id="carouselExampleControls" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active"><img class="carousel-image" src="./image/hotel1.jpg"></div>
    <div class="carousel-item"><img class="carousel-image" src="./image/hotel2.jpg"></div>
    <div class="carousel-item"><img class="carousel-image" src="./image/hotel3.jpg"></div>
    <div class="carousel-item"><img class="carousel-image" src="./image/hotel4.jpg"></div>
  </div>
</section>

<script src="./javascript/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
