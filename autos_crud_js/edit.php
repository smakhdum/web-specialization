<?php
require_once "pdo.php";
session_start();
if (!isset($_SESSION['name']) || strlen($_SESSION['name']) < 1||!isset($_SESSION['user_id']) || strlen($_SESSION['user_id']) < 1)
{
  die('ACCESS DENIED');
  return;
}
if (isset($_POST['first_name'])&& isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline'])&& isset($_POST['summary']))
{
    if (strlen($_POST['first_name'])< 1 || strlen($_POST['last_name'])< 1 || strlen($_POST['email'])< 1 || strlen($_POST['headline'])< 1 || strlen($_POST['summary'])< 1)
    {
        $_SESSION["error"] = "All fields are required";
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }

    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $_SESSION["error"] = "Email must have an at-sign (@)";
            header("Location: edit.php?profile_id=".$_POST['profile_id']);
            return;
        }
    {
    $sql = "UPDATE profile SET first_name = :first_name, last_name = :last_name,
            email = :email, headline = :headline, summary=:summary
            WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'],
        ':profile_id' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}
}
// Guardian: Make sure that profile_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}


$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$em = htmlentities($row['email']);
$he = htmlentities($row['headline']);
$su = htmlentities($row['summary']);
$pi = $row['profile_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Sayed Makhdum Ullah- autosdb</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Editing Automobile</h1>
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
 ?>
<form method="post">
<p>first_name:
<input type="text" name="first_name" value="<?= $fn ?>"></p>
<p>last_name:
<input type="text" name="last_name" value="<?= $ln ?>"></p>
<p>email:
<input type="text" name="email" value="<?= $em ?>"></p>
<p>headline:
<input type="text" name="headline" value="<?= $he ?>"></p>
<p>summary:
<input type="text" name="summary" value="<?= $su ?>"></p>
<input type="hidden" name="profile_id" value="<?= $pi ?>">
<p><input type="submit" value="Save"/>
<a href="view.php">Cancel</a></p>
</form>
</div>
</body>
</html>
