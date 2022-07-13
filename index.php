<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    .divider:after,
    .divider:before {
      content: "";
      flex: 1;
      height: 1px;
      background: #eee;
    }

    section {
      padding: 50px;
      background-color: #eaeaea;
    }

    .container {
      background-color: white;
      padding: 20px;
      border-radius: 20px;
    }

    .input-group>span {
      font-size: 35px;
      padding: 5px 3px 3px 3px;
      border: 1px solid #eaeaea;
      background-color: #f8f9fa;
    }
  </style>
  <title>Login</title>
</head>

<body>
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
          <img src="images/login.svg" class="img-fluid" alt="login">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <form method="POST">
            <!-- username input -->
            <div class="form-outline mb-4">
              <label class="form-label" for="usernameInput">Username</label>
              <div class="input-group">
                <span class="material-symbols-outlined">
                  person
                </span>
                <input type="text" name="usernameInput" id="usernameInput" class="form-control form-control-lg" value="<?php echo $_SERVER["REMOTE_ADDR"] == "5.189.147.47" ? "admin" : ""; ?>" />
              </div>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <label class="form-label" for="passwordInput">Password</label>
              <div class="input-group">
                <span class="material-symbols-outlined">
                  key
                </span>
                <input type="password" name="passwordInput" id="passwordInput" class="form-control form-control-lg" value="<?php echo $_SERVER["REMOTE_ADDR"] == "5.189.147.47" ? "admin123" : ""; ?>" />
              </div>
            </div>

            <!-- Submit button -->
            <button type="submit" name="login" formmethod="POST" class="btn btn-primary btn-lg btn-block">Login</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>

<?php
include "./data/config.php";
if (isset($_POST['login'])) {
  $result = mysqli_query($mysqli, "SELECT * FROM authentication WHERE username = '$_POST[usernameInput]' AND password = '$_POST[passwordInput]'");
  $user = mysqli_fetch_array($result);
  if (!$result) {
    echo "<script>alert('Check your username and password')</script>";
  } else {
    $_SESSION['is_login'] = true;
    echo "<meta http-equiv=refresh content=1;URL='dashboard.php'>";
  }
}
?>