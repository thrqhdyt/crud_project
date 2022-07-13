<?php
session_start();
if (!isset($_SESSION['is_login'])) {
  header("Location: index.php");
}
?>
<?php
include "./data/config.php";

if (isset($_GET['destination_id'])) {
  $destinationId = $_GET['destination_id'];
  $result = mysqli_query($mysqli, "SELECT * FROM destination WHERE destination_id = '$_GET[destination_id]'");
  $destination = mysqli_fetch_array($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="style.css" />

  <!----===== Iconscout CSS ===== -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />

  <!-- Bootstraps css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Dashboard Bus system kito21</title>
</head>

<body>

  <section class="mt-5">
    <h2 class="text-center">Update Destination</h2>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <form method="POST">
            <div class="form-group mb-3">
              <label for="destinationNameInput">Destination Name : </label>
              <input type="text" name="destinationName" class="form-control" value="<?php echo $destination['destination_name'] ?>" id="destinationName" placeholder="Destination..." required>
            </div>
            <div class="form-group mb-3">
              <label for="quantityInput">Quantity :</label>
              <input type="number" min="1" name="quantity" class="form-control" value="<?php echo $destination['quantity'] ?>" id="quantity" placeholder="Quantity..." required>
            </div>
            <div class="form-group mb-3">
              <label for="terminalNameInput">Terminal Name : </label>
              <input type="text" name="terminalName" class="form-control" value="<?php echo $destination['terminal_name'] ?>" id="terminal" placeholder="Terminal..." required>
            </div>
            <div class="form-group mb-3">
              <label for="cityInput">Terminal Address : </label>
              <input type="text" min="1" name="terminalAddress" class="form-control" value="<?php echo $destination['terminal_address'] ?>" id="terminalAddress" placeholder="Address..." required>
            </div>
            <button type="submit" formmethod="POST" name="submit" value="Update" type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>

      </div>
    </div>
  </section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>

</html>

<?php
if (isset($_POST['submit']) && $_POST['submit'] == "Update") {
  $quantity = (int)$_POST['quantity'];
  mysqli_query(
    $mysqli,
    "UPDATE destination SET 
            destination_name = '$_POST[destinationName]', 
            quantity = '$quantity', 
            terminal_name = '$_POST[terminalName]', 
            terminal_address = '$_POST[terminalAddress]' WHERE destination_id = '$destinationId'"
  );
  echo "<meta http-equiv=refresh content=1;URL='destination.php'>";
}
?>