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
          <input type="search" name="search" placeholder="Search here..." formaction="/destination.php" />
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
              <th scope="col">Destination Name</th>
              <th scope="col">Quantity</th>
              <th scope="col">Terminal Name</th>
              <th scope="col">Terminal Address</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php
            include "./data/config.php";

            if (isset($_POST['search'])) {
              $result = mysqli_query($mysqli, "SELECT * FROM destination WHERE destination_name LIKE '%$_POST[search]%' ORDER BY destination_name, quantity");
            } else {
              $result = mysqli_query($mysqli, "SELECT * FROM destination ORDER BY destination_name, quantity");
            }
            $no = 1;
            while ($travel = mysqli_fetch_array($result)) {
              echo "<tr>";
              echo "<td>" . $no . "</td>";
              echo "<td>" . ucwords($travel['destination_name']) . "</td>";
              echo "<td>" . $travel['quantity'] . "</td>";
              echo "<td>" . ucwords($travel['terminal_name']) . "</td>";
              echo "<td>" . ucwords($travel['terminal_address']) . "</td>";
              $destinationId = $travel['destination_id'];
              echo "<td><a formmethod='POST' name='update' value='Update' class='btn btn-primary btn-sm' href='update-destination.php?destination_id=$destinationId'role='button'>Update</a> | <a class='btn btn-danger btn-sm' href='?destination_id=$destinationId&action=delete' role='button'>Delete</a></td>";
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
            <h5 class="modal-title text-center" id="insertModalLabel">Destination</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST">
              <div class="form-group mb-3">
                <label for="destinationNameInput">Destination Name : </label>
                <input type="text" name="destinationName" class="form-control" id="destinationName" placeholder="Destination..." required>
              </div>
              <div class="form-group mb-3">
                <label for="quantityInput">Quantity :</label>
                <input type="number" min="1" name="quantity" class="form-control" id="quantity" placeholder="Quantity..." required>
              </div>
              <div class="form-group mb-3">
                <label for="terminalNameInput">Terminal Name : </label>
                <input type="text" name="terminalName" class="form-control" id="terminalName" placeholder="Terminal..." required>
              </div>
              <div class="form-group mb-3">
                <label for="cityInput">Terminal Address : </label>
                <input type="text" name="terminalAddress" class="form-control" id="terminalAddress" placeholder="Address..." required>
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
  $quantity = (int)$_POST['quantity'];

  $bytes = random_bytes(8);
  $fetchUuid = bin2hex($bytes);
  $id = $fetchUuid;

  mysqli_query(
    $mysqli,
    "INSERT INTO destination SET 
            destination_id = '$id', 
            destination_name = '$_POST[destinationName]', 
            quantity = '$quantity', 
            terminal_name = '$_POST[terminalName]', 
            terminal_address = '$_POST[terminalAddress]'"
  );

  echo "<meta http-equiv=refresh content=1;URL='destination.php'>";
}

if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['destination_id'])) {
  mysqli_query(
    $mysqli,
    "DELETE FROM destination WHERE destination_id = '$_GET[destination_id]'"
  );
  echo "<meta http-equiv=refresh content=1;URL='destination.php'>";
}

if (isset($_GET['action']) && $_GET['action'] == "logout") {
  session_unset();
  session_destroy();
  echo "<meta http-equiv=refresh content=1;URL='index.php'>";
}
?>