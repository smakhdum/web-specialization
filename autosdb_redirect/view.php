<?php
require_once "pdo.php";
session_start();
// Demand a GET parameter
if (!isset($_SESSION['name']) || strlen($_SESSION['name']) < 1)
{
    die('Not logged in');
}


// showing data frm DB
$stmt = $pdo->query("SELECT make, year, mileage FROM autos ORDER BY year");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
<title>Sayed Makhdum Ullah- autosdb</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<?php
if (isset($_SESSION['name']))
{
    echo "<h1>Tracking Autos for: ";
    echo $_SESSION['name'];
    echo "</h1>\n";
}
if ( isset($_SESSION["success"]) )
{
    echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
    unset($_SESSION["success"]);
}
?>
<p>
 <a href="add.php">Add New </a>|
 <a href="Logout.php">Logout</a>
</p>
<h2>Automobiles</h2>
<ul>
<?php foreach($rows as $row) { ?>
  <li><?php echo ($row['year']." ".htmlentities($row['make'])." / ".$row['mileage']); ?></li>
<?php } ?>
</ul>

</div>
</body>
</html>
