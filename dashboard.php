<?php
include "./data/config.php";

session_start();
if (!isset($_SESSION['is_login'])) {
  header("Location: index.php");
}
$result = mysqli_query($mysqli, "SELECT * FROM user_profile WHERE username = 'admin'");
$userProfle = mysqli_fetch_array($result);
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
  <nav>
    <div class="brand-name mt-2 text-center">
      <h4>Admin</h4>
      <h6><?php echo $userProfle['fullname']; ?></h6>
      <h6><?php echo $userProfle['email']; ?></h6>
    </div>
    <div class="menu-items">
      <ul class="nav-links">
        <li>
          <a href="dashboard.php">
            <i class="uil uil-estate"></i>
            <span class="link-name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="bus.php">
            <i class="uil uil-bus"></i>
            <span class="link-name">Bus</span>
          </a>
        </li>
        <li>
          <a href="destination.php">
            <i class="uil uil-files-landscapes"></i>
            <span class="link-name">Destination</span>
          </a>
        </li>
      </ul>

      <ul class="logout-mode">
        <li>
          <a href="?action=logout">
            <i class="uil uil-signout"></i>
            <span class="link-name">Logout</span>
          </a>
        </li>

        <li class="mode">
          <a href="#">
            <i class="uil uil-moon"></i>
            <span class="link-name">Dark Mode</span>
          </a>

          <div class="mode-toggle">
            <span class="switch"></span>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <section class="dashboard">
    <div class="top">
      <i class="uil uil-bars sidebar-toggle"></i>

      <div class="search-box">
        <i class="uil uil-search"></i>
        <form method="POST">
          <input type="search" name="search" placeholder="Search here..." formaction="/dashboard.php" />
        </form>
      </div>

      <img src="images/avatar.svg" alt="avatar" />
    </div>

    <div class="dash-content">
      <div class="overview">
        <table class="table table-primary caption-top">
          <thead class="table table-danger">
            <tr class="text-center">
              <th scope="col">No</th>
              <th scope="col">Destination</th>
              <th scope="col">Price</th>
              <th scope="col">Bus Name</th>
              <th scope="col">Departure Time</th>
              <th scope="col">Arrival Time</th>
              <th scope="col">Seat Number</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php
            include "./data/config.php";
            if (isset($_POST['search'])) {
              $result = mysqli_query($mysqli, "SELECT ticket_id, destination_name, price, bus_name, departure_time, departure_location, arrival_time, seat_number FROM ticket JOIN destination ON (ticket.destination_id = destination.destination_id) JOIN bus ON (ticket.bus_id = bus.bus_id) WHERE LOWER(destination_name) LIKE '%$_POST[search]%' OR LOWER(departure_location) LIKE '%$_POST[search]%' ORDER BY price");
            } else {
              $result = mysqli_query($mysqli, "SELECT ticket_id, destination_name, price, bus_name, departure_time, departure_location, arrival_time, seat_number FROM ticket JOIN destination ON (ticket.destination_id = destination.destination_id) JOIN bus ON (ticket.bus_id = bus.bus_id) ORDER BY price");
            }

            $no = 1;
            while ($travel = mysqli_fetch_array($result)) {
              echo "<tr>";
              echo "<td>" . $no . "</td>";
              echo "<td>" . ucwords($travel['departure_location']) . "-" . ucwords($travel['destination_name']) . "</td>";
              echo "<td>" . $travel['price'] . "</td>";
              echo "<td>" . ucwords($travel['bus_name']) . "</td>";
              echo "<td>" . $travel['departure_time'] . "</td>";
              echo "<td>" . $travel['arrival_time'] . "</td>";
              echo "<td>" . $travel['seat_number'] . "</td>";
              $ticketId = $travel['ticket_id'];
              echo "<td><a class='btn btn-primary btn-sm btn-update' href='update-ticket.php?ticket_id=$ticketId' role='button'>Update</a> | <a class='btn btn-danger btn-sm' href='?ticket_id=$ticketId&action=delete' role='button'>Delete</a></td>";
              echo "</tr>";
              $no++;
            }
            ?>

          </tbody>
        </table>
      </div>
    </div>

    <button formmethod="POST" type="submit" name="insert" value="insert" class="btn btn-primary rounded-pill float-button" data-bs-toggle="modal" data-bs-target="#insertModal"><span>+</span> Create Item</button>

    <!-- modal Insert -->
    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="insertModalLabel">Ticket</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST">
              <div class="form-group mb-3">
                <label for="selectBus">Bus :</label>
                <select class="form-control" name="bus" id="bus" required>
                  <option disabled selected value="not selected">Choose Bus...</option>
                  <?php
                  include "./data/config.php";

                  $result = mysqli_query($mysqli, "SELECT bus_id, bus_name, departure_location from bus");

                  while ($travel = mysqli_fetch_array($result)) {
                    echo "<option value=" . $travel['bus_id'] . ">" .  ucwords($travel['bus_name']) . " - " . ucwords($travel['departure_location']) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="selectDestination">Destination : </label>

                <select class="form-control" name="destination" id="destination" required>
                  <option disabled selected value="not selected">Choose Destination...</option>
                  <?php
                  include "./data/config.php";

                  $result = mysqli_query($mysqli, "SELECT destination_id, destination_name from destination");

                  while ($travel = mysqli_fetch_array($result)) {
                    echo "<option value=" . $travel['destination_id'] . ">" . $travel['destination_name'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="priceInput">Price : </label>
                <input type="number" min="1" name="price" class="form-control" id="price" placeholder="Price..." required>
              </div>
              <div class="form-group mb-3">
                <label for="seatNumberInput">Seat Number : </label>
                <input type="number" min="1" name="seatNumber" class="form-control" id="seatNumber" placeholder="Seat Number.." required>
              </div>
              <div class="form-group mb-3">
                <label for="departureTime">Departure time :</label><br>
                <input type="datetime-local" id="departureTime" name="departureTime">
              </div>
              <div class="form-group mb-3">
                <label for="arrivalTime">Arrival time :</label><br>
                <input type="datetime-local" id="arrivalTime" name="arrivalTime">
              </div>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" formmethod="POST" name="submit" value="Insert" type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Modal -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>

</html>

<?php
include "./data/config.php";

if (isset($_POST['submit']) && $_POST['submit'] == "Insert") {
  $price = (int)$_POST['price'];
  $seatNumber = (int)$_POST['seatNumber'];
  $depFormat = explode("T", $_POST['departureTime']);
  $arrFormat = explode("T", $_POST['arrivalTime']);

  $departureTime = "$depFormat[0]" . " " . "$depFormat[1]";
  $arrivalTime = "$arrFormat[0]" . " " . "$arrFormat[1]";

  $bytes = random_bytes(8);
  $fetchUuid = bin2hex($bytes);
  $id = $fetchUuid;

  if ($_POST['destination'] == "not selected" || $_POST['bus'] == "not selected" || $departureTime == $arrivalTime || empty(strlen($departureTime)) || empty(strlen($arrivalTime)) || !($departureTime < $arrivalTime)) {
    echo "<script> alert('Please check your input') </script>";
  } else {
    mysqli_query(
      $mysqli,
      "INSERT INTO ticket SET 
            ticket_id = '$id', 
            destination_id = '$_POST[destination]', 
            price = '$price', 
            bus_id = '$_POST[bus]', 
            seat_number = '$seatNumber', 
            departure_time = '$departureTime', 
            arrival_time = '$arrivalTime'"
    );
  }
  echo "<meta http-equiv=refresh content=1;URL='dashboard.php'>";
}

if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['ticket_id'])) {
  mysqli_query(
    $mysqli,
    "DELETE FROM ticket WHERE ticket_id = '$_GET[ticket_id]'"
  );
  echo "<meta http-equiv=refresh content=1;URL='dashboard.php'>";
}

if (isset($_GET['action']) && $_GET['action'] == "logout") {
  session_unset();
  session_destroy();
  echo "<meta http-equiv=refresh content=1;URL='index.php'>";
}
?>