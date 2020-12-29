<?php
require_once "pdo.php";
session_start();
// Demand a GET parameter
if (!isset($_SESSION['name']) || strlen($_SESSION['name']) < 1)
{
    die('ACCESS DENIED');
}
if (isset($_POST['cancel']))
{
    // Redirect the browser to view.php
    header("Location: index.php");
    return;
}
// insert data
if (isset($_POST['make'])&& isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']))
{
    if (strlen($_POST['make'])< 1 || strlen($_POST['model'])< 1 || strlen($_POST['year'])< 1 || strlen($_POST['mileage'])< 1)
    {
        $_SESSION["error"] = "All fields are required";
        header("Location: add.php");
        return;
    }

    else if (strlen($_POST['make']) < 1)
    {
        $_SESSION["error"] = "Make is required";
        header("Location: add.php");
        return;
    }
    else if ((!is_numeric($_POST['mileage'])) || (!is_numeric($_POST['year'])))
    {
        $_SESSION["error"] = "Mileage and year must be numeric";
        header("Location: add.php");
        return;
    }
    else
    {

        $sql = "INSERT INTO autos (make,model, year, mileage)
              VALUES (:make,:model, :year, :mileage)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array( // execute er kaj hocce sql ta run kora er er jnno se 3 ta arry index key te valu gula pass kortese
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']
        ));
        $_SESSION["success"] = "Record added.";
        header("Location: index.php");
    }
}
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
if (isset($_SESSION["error"]))
{
    echo ('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
    unset($_SESSION["error"]);
}
?>

<form method="post">
<p>Make:
<input type="text" name="make" size="40"></p>
<p>Model:
<input type="text" name="model"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>

</div>
</body>
</html>
