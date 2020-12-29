<?php
require_once "pdo.php";
session_start();

?>

<!DOCTYPE html>
<html>
<head><title> Sayed Makhdum Ullah-  autosdb</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
if (!isset($_SESSION['name']) || strlen($_SESSION['name']) < 1||!isset($_SESSION['user_id']) || strlen($_SESSION['user_id']) < 1)
{ echo ("<h1>Welcome to the makhdum's profile management</h1>");
  echo ('<p><a href="login.php">Please log in</a></p>');
  echo ('<p>Attempt to go to <a href="add.php">add.php</a> and <a href="view.php">view.php</a> without logging in - it should fail with an error message.
  </p>');
  return;
}else {
  $_SESSION["success"] = "loged in ";
  header("Location: view.php");
}
?>
</div>
</body>
</html>
