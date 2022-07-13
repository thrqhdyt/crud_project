<?php
session_start();
if (!isset($_SESSION['is_login'])) {
  header("Location: index.php");
}
?>
<?php
include "./data/config.php";

if (isset($_GET['ticket_id'])) {
  $ticketId = $_GET['ticket_id'];
  $result = mysqli_query($mysqli, "SELECT *, ticket.destination_id AS destination_id, bus.bus_id AS bus_id FROM ticket JOIN destination ON (ticket.destination_id = destination.destination_id) JOIN bus ON (ticket.bus_id = bus.bus_id) WHERE ticket_id = '$_GET[ticket_id]'");
  $ticket = mysqli_fetch_array($result);
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
    <h2 class="text-center">Update Ticket</h2>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <form method="POST">
            <div class="form-group mb-3">
              <label for="selectBus">Bus :</label>
              <select class="form-control" name="bus" id="bus" required>
                <option value="<?php echo $ticket['bus_id'] ?>"><?php echo ucwords($ticket['bus_name']) . " - " . ucwords($ticket['departure_location']); ?></option>
                <?php
                include "./data/config.php";

                $result = mysqli_query($mysqli, "SELECT * FROM bus WHERE bus_id != '$ticket[bus_id]'");

                while ($travel = mysqli_fetch_array($result)) {
                  echo "<option value=" . $travel['bus_id'] . ">" .  ucwords($travel['bus_name']) . " - " . ucwords($travel['departure_location']) . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group mb-3">
              <label for="selectDestination">Destination : </label>
              <select class="form-control" name="destination" id="destination" required>
                <option value="<?php echo $ticket['destination_id'] ?>"><?php echo ucwords($ticket['destination_name']); ?></option>
                <?php
                include "./data/config.php";

                $result = mysqli_query($mysqli, "SELECT * FROM destination WHERE destination_id != '$ticket[destination_id]'");

                while ($travel = mysqli_fetch_array($result)) {
                  echo "<option value=" . $travel['destination_id'] . ">" . $travel['destination_name'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group mb-3">
              <label for="priceInput">Price : </label>
              <input type="number" min="1" name="price" class="form-control" id="price" value="<?php echo $ticket['price']; ?>" placeholder=" Price..." required>
            </div>
            <div class="form-group mb-3">
              <label for="seatNumberInput">Seat Number : </label>
              <input type="number" min="1" name="seatNumber" class="form-control" id="seatNumber" value="<?php echo $ticket['seat_number']; ?>" placeholder=" Seat Number.." required>
            </div>
            <div class="form-group mb-3">
              <label for="departureTime">Departure time :</label><br>
              <input type="datetime-local" id="departureTime" value="<?php echo $ticket['departure_time']; ?>" name="departureTime">
            </div>
            <div class="form-group mb-3">
              <label for="arrivalTime">Arrival time :</label><br>
              <input type="datetime-local" id="arrivalTime" value="<?php echo $ticket['arrival_time']; ?>" name="arrivalTime">
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
  $price = (int)$_POST['price'];
  $seatNumber = (int)$_POST['seatNumber'];
  $depFormat = explode("T", $_POST['departureTime']);
  $arrFormat = explode("T", $_POST['arrivalTime']);

  $departureTime = "$depFormat[0]" . " " . "$depFormat[1]";
  $arrivalTime = "$arrFormat[0]" . " " . "$arrFormat[1]";

  $bytes = random_bytes(8);
  $fetchUuid = bin2hex($bytes);
  $id = $fetchUuid;
  if ($departureTime == $arrivalTime || empty(strlen($departureTime)) || empty(strlen($arrivalTime)) || !($departureTime < $arrivalTime)) {
    echo "<script> alert('Please check your input') </script>";
  } else {
    mysqli_query(
      $mysqli,
      "UPDATE ticket SET 
            destination_id = '$_POST[destination]', 
            price = '$price', 
            bus_id = '$_POST[bus]', 
            seat_number = '$seatNumber', 
            departure_time = '$departureTime', 
            arrival_time = '$arrivalTime' WHERE ticket_id = '$ticketId'"
    );
  }
  echo "<meta http-equiv=refresh content=1;URL='dashboard.php'>";
}
?>