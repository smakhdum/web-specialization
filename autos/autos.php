<?php
require_once "pdo.php";
// Demand a GET parameter
if (!isset($_GET['name']) || strlen($_GET['name']) < 1)
{
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if (isset($_POST['logout']))
{
    header('Location: index.php');
    return;
}
$failure = false;
$success = false;
// insert data
if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']))
{
    if ((!is_numeric($_POST['mileage'])) || (!is_numeric($_POST['year'])))
    {
        $failure = "Mileage and year must be numeric";
    }
    else
    {
        if (strlen($_POST['make']) < 1)
        {
            $failure = "Make is required";
        }
        else
        {
            $sql = "INSERT INTO autos (make, year, mileage)
              VALUES (:make, :year, :mileage)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array( // execute er kaj hocce sql ta run kora er er jnno se 3 ta arry index key te valu gula pass kortese
                ':make' => $_POST['make'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage']
            ));
            $success = "Record inserted";
        }
    }
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
if (isset($_REQUEST['name']))
{
    echo "<h1>Tracking Autos for: ";
    echo htmlentities($_REQUEST['name']);
    echo "</h1>\n";
}
if ($failure !== false)
{
    // Look closely at the use of single and double quotes
    echo ('<p style="color: red;">' . htmlentities($failure) . "</p>\n");
}
if ($success !== false)
{
    // Look closely at the use of single and double quotes
    echo ('<p style="color: green;">' . htmlentities($success) . "</p>\n");
}
?>

<form method="post">
<p>Make:
<input type="text" name="make" size="40"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="logout">
</form>


<h2>Automobiles</h2>
<ul>
<?php foreach($rows as $row) { ?>
  <li><?php echo ($row['year']." ".htmlentities($row['make'])." / ".$row['mileage']); ?></li>
<?php } ?>
</ul>

</div>
</body>
</html>
