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
          <input type="search" name="search" placeholder="Search here..." formaction="/bus.php" />
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
              <th scope="col">Bus Name</th>
              <th scope="col">Capacity</th>
              <th scope="col">Departure Location</th>
              <th scope="col">Bus Type</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php
            include "./data/config.php";

            if (isset($_POST['search'])) {
              $result = mysqli_query($mysqli, "SELECT bus_id, bus_name, capacity, departure_location, bus_type FROM bus WHERE bus_name LIKE '%$_POST[search]%' OR departure_location LIKE '%$_POST[search]%' OR bus_type LIKE '%$_POST[search]%' ORDER BY capacity");
            } else {
              $result = mysqli_query($mysqli, "SELECT bus_id, bus_name, capacity, departure_location, bus_type FROM bus ORDER BY capacity");
            }
            $no = 1;
            while ($travel = mysqli_fetch_array($result)) {
              echo "<tr>";
              echo "<td>" . $no . "</td>";
              echo "<td>" . ucwords($travel['bus_name']) . "</td>";
              echo "<td>" . $travel['capacity'] . "</td>";
              echo "<td>" . $travel['departure_location'] . "</td>";
              echo "<td>" . $travel['bus_type'] . "</td>";
              $busId = $travel['bus_id'];
              echo "<td><a name='update' value='Update' class='btn btn-primary btn-sm' href='update-bus.php?bus_id=$busId' role='button'>Update</a> | <a class='btn btn-danger btn-sm' href='?bus_id=$busId&action=delete' role='button'>Delete</a></td>";
              echo "</tr>";
              $no++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <button formmethod="POST" type="submit" name="insert" value="insert" class="btn btn-primary rounded-pill float-button" data-bs-toggle="modal" data-bs-target="#insertModal"><span>+</span> Create Item</button>

    <!-- INSERT MODAL -->
    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="insertModalLabel">Bus</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST">
              <div class="form-group mb-3">
                <label for="busName">Bus Name : </label>
                <input type="text" name="busName" class="form-control" id="busName" placeholder="Bus Name..." required>
              </div>
              <div class="form-group mb-3">
                <label for="capacity">Capacity :</label>
                <input type="number" min="1" name="capacity" class="form-control" id="capacity" placeholder="Capacity..." required>
              </div>
              <div class="form-group mb-3">
                <label for="departureLocation">Departure Location : </label>
                <input type="text" name="departureLocation" class="form-control" id="departureLocation" placeholder="Departure Location..." required>
              </div>
              <div class="form-group mb-4">
                <label for="seatNumberInput">Bus Type : </label>
                <select class="form-control" name="busType" id="busType" required>
                  <option>Economy</option>
                  <option>Eksekutif</option>
                </select>
              </div>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" formmethod="POST" name="submit" value="Insert" type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>

</html>

<?php
include "./data/config.php";

if (isset($_POST['submit']) && $_POST['submit'] == "Insert") {
  $capacity = (int)$_POST['capacity'];

  $bytes = random_bytes(8);
  $fetchUuid = bin2hex($bytes);
  $id = $fetchUuid;

  mysqli_query(
    $mysqli,
    "INSERT INTO bus SET 
            bus_id = '$id',
            bus_name ='$_POST[busName]', 
            capacity = '$capacity', 
            departure_location = '$_POST[departureLocation]', 
            bus_type = '$_POST[busType]'"
  );
  echo "<script>console.log('Hello World');</script>";
  echo "<meta http-equiv=refresh content=1;URL='bus.php'>";
}

if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['bus_id'])) {
  mysqli_query(
    $mysqli,
    "DELETE FROM bus WHERE bus_id = '$_GET[bus_id]'"
  );
  echo "<meta http-equiv=refresh content=1;URL='bus.php'>";
}

if (isset($_GET['action']) && $_GET['action'] == "logout") {
  session_unset();
  session_destroy();
  echo "<meta http-equiv=refresh content=1;URL='index.php'>";
}
?>