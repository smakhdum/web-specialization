<?php
require_once "pdo.php";
session_start();
// Demand a GET parameter
if (!isset($_SESSION['name']) || strlen($_SESSION['name']) < 1||!isset($_SESSION['user_id']) || strlen($_SESSION['user_id']) < 1)
{
  die('ACCESS DENIED');
  return;
}
if (isset($_POST['cancel']))
{
    // Redirect the browser to view.php
    header("Location: index.php");
    return;
}
// insert data
if (isset($_POST['first_name'])&& isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline'])&& isset($_POST['summary']))
{
    if (strlen($_POST['first_name'])< 1 || strlen($_POST['last_name'])< 1 || strlen($_POST['email'])< 1 || strlen($_POST['headline'])< 1|| strlen($_POST['summary'])< 1)
    {
        $_SESSION["error"] = "All fields are required";
        header("Location: add.php");
        return;
    }

    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $_SESSION["error"] = "Email must have an at-sign (@)";
        header("Location: add.php");
        return;
    }

      $stmt = $pdo->prepare('INSERT INTO Profile
          (user_id, first_name, last_name, email, headline, summary)
          VALUES ( :uid, :fn, :ln, :em, :he, :su)');
      $stmt->execute(array(
          ':uid' => $_SESSION['user_id'],
          ':fn' => $_POST['first_name'],
          ':ln' => $_POST['last_name'],
          ':em' => $_POST['email'],
          ':he' => $_POST['headline'],
          ':su' => $_POST['summary'])
      );
        $_SESSION["success"] = "Profile added.";
        header("Location: view.php");
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
    echo "<h3>Welcome: ";
    echo $_SESSION['name'];
    echo "</h3>\n";
}
if (isset($_SESSION["error"]))
{
    echo ('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
    unset($_SESSION["error"]);
}
?>

<h1>Adding Profile for UMSI</h1>
<form method="post">
<p>First Name:
<input type="text" name="first_name" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"/></p>
<p>Email:
<input type="text" name="email" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80"></textarea>
<p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>

</div>
</body>
</html>
