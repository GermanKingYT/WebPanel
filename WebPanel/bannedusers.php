<!DOCTYPE html>
<html lang="en">
<?php
require_once 'inc/inc.php';
require_once 'inc/checksession.php';

$users = Manager::getUsers();
$_SESSION['previous-location'] = $_SERVER['REQUEST_URI'];
$status = '';
if (isset($_GET['status'])) {
  $status = $_GET['status'];
}

?>

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.min.css">
    <title>Banned users</title>
  </head>

  <body>
    <div class="container-fluid">
      <!-- NAVIGATION -->
      <div class="row">
        <div class="col-md-2 bg-light" id="navbar">
          <nav class="nav flex-column">
            <a class="nav-link navitem" href="adduser.php">Add User</a>
            <a class="nav-link navitem selected" href="#">Banned Users</a>
            <a class="nav-link navitem" href="userlist.php">User List</a>
            <a class="nav-link navitem" href="#" data-toggle="modal" data-target="#logoutmodal">Logout</a>
            <p class="version-disclaimer">
              <small>WebPanel v<?php echo Config::get('webpanel_version'); ?> by 1234filip</small></p>
          </nav>
        </div>
        <div class="col-md-10" id="content">
          <input type="text" class="form-control mt-3 mb-3" id="search-input" aria-label="Search" placeholder="Search">
          <?php
              if ($status == 'pardonuser-success') {
                echo '<div class="alert alert-success mt-2" role="alert">Successfully pardoned the user!</div>';
              } 
              if ($status == 'pardonuser-error') {
                echo '<div class="alert alert-danger mt-2" role="alert">Unknown error!</div>';
              }
              if ($status == 'removeuser-success') {
                echo '<div class="alert alert-success mt-2" role="alert">Successfully removed the user!</div>';
              } 
              if ($status == 'removeuser-error') {
                echo '<div class="alert alert-danger mt-2" role="alert">Unknown error!</div>';
              }
            ?>
            <!-- USER LIST -->
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Username</th>
                  <th scope="col">HWID</th>
                  <th scope="col">Type</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($users as $user) {
                    if ($user['ban'] == 1) {
                      echo '<tr>
                              <th scope="row">' . $user['id'] . '</th>
                              <td class="username-field">' . $user['username'] . '</td>
                              <td>' . $user['hwid'] . '</td>
                              <td>' . $user['type'] . '</td>
                              <td>
                              <button type="button" class="btn btn-info pardonbtn" data-toggle="modal" data-target="#banmodal" data-id="' . $user['id'] .'">Pardon</button>
                              <button type="button" class="btn btn-danger removebtn" data-toggle="modal" data-target="#removemodal" data-id="' . $user['id'] .'">Remove</button>
                              </td>
                            </tr>';
                    }
                  }
                ?>
              </tbody>
            </table>
            <!-- PARDON MODAL -->
            <div class="modal fade" id="banmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ban User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Do you really want to pardon this user?
                  </div>
                  <div class="modal-footer">
                    <form action="pardonuserdata.php" method="post">
                      <input class="id-input" type="hidden" value="" name="id">
                      <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                      <input class="btn btn-info" type="submit" value="Pardon">
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- REMOVE MODAL -->
            <div class="modal fade" id="removemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ban User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Do you really want to remove this user?
                  </div>
                  <div class="modal-footer">
                    <form action="removeuserdata.php" method="post">
                      <input class="id-input" type="hidden" value="" name="id">
                      <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                      <input class="btn btn-danger" type="submit" value="Remove">
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- LOGOUT MODAL -->
            <div class="modal fade" id="logoutmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ban User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Do you really want to logout?
                  </div>
                  <div class="modal-footer">
                    <form action="logout.php" method="post">
                      <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                      <input class="btn btn-danger" type="submit" value="Logout">
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    <script src="js/plugins-dist.js"></script>
    <script src="js/original/bannedusers.js"></script>
  </body>

</html>