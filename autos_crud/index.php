<?php
require_once "pdo.php";
session_start();
$stmt = $pdo->query("SELECT * FROM autos ORDER BY year");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head><title>Sayed Makhdum Ullah-  autosdb</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Welcome to the Automobiles Database</h1>
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
if (!isset($_SESSION['name']) || strlen($_SESSION['name']) < 1)
{
  echo ('<p><a href="login.php">Please log in</a></p>');
  echo ('<p>Attempt to go to <a href="add.php">add.php</a> without logging in - it should fail with an error message.
  </p>');
  return;
}
if ($rows==false){
  echo "No rows found";
} else
{
echo('<table border="1">'."\n");
echo "<tr>";
  echo "<th>Make</th>";
  echo "<th>Model</th>";
  echo "<th>Year</th>";
  echo "<th>Mileage</th>";
  echo "<th>Action</th>";
echo "</tr>";
foreach($rows as $row) {
    echo "<tr><td>";
    echo(htmlentities($row['make']));
    echo("</td><td>");
    echo(htmlentities($row['model']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td><td>");
    echo('<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> / ');
    echo('<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
    echo("</td></tr>\n");
}
}
echo('</table>');
?>
<p>
<p><a href="add.php">Add New Entry</a></p>
<p><a href="Logout.php">Logout</a></p>
</p>
  </div>
</body>
</html>
