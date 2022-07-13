<?php
session_start();
if (!isset($_SESSION['is_login'])) {
  header("Location: index.php");
}
?>
<?php
include "./data/config.php";

if (isset($_GET['bus_id'])) {
  $busId = $_GET['bus_id'];
  $result = mysqli_query($mysqli, "SELECT bus_id, bus_name, capacity, departure_location, bus_type FROM bus WHERE bus_id = '$busId'");
  $bus = mysqli_fetch_array($result);
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
    <h2 class="text-center">Update Bus</h2>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <form method="POST">
            <div class="form-group mb-3">
              <label for="busName">Bus Name : </label>
              <input type="text" name="busName" class="form-control" id="busName" value="<?php echo $bus['bus_name'] ?>" placeholder="Bus Name..." required>
            </div>
            <div class="form-group mb-3">
              <label for="capacity">Capacity :</label>
              <input type="number" min="1" name="capacity" class="form-control" value="<?php echo $bus['capacity'] ?>" id="capacity" placeholder="Capacity..." required>
            </div>
            <div class="form-group mb-3">
              <label for="departureLocation">Departure Location : </label>
              <input type="text" name="departureLocation" class="form-control" id="departureLocation" value="<?php echo $bus['departure_location'] ?>" placeholder="Departure Location..." required>
            </div>
            <div class="form-group mb-4">
              <label for="seatNumberInput">Bus Type : </label>
              <select class="form-control" name="busType" id="busType" required>
                <option><?php echo $bus['bus_type'] ?></option>
                <option>Economy</option>
                <option>Eksekutif</option>
              </select>
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
  mysqli_query(
    $mysqli,
    "UPDATE bus SET 
            bus_name = '$_POST[busName]', 
            capacity = '$_POST[capacity]', 
            departure_location = '$_POST[departureLocation]', 
            bus_type = '$_POST[busType]' WHERE bus_id = '$busId'"
  );

  echo "<meta http-equiv=refresh content=1;URL='bus.php'>";
}
?>