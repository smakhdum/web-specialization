<?php // Do not put any HTML above this line
  session_start();
if (isset($_POST['cancel']))
{
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is
 // If we have no POST data
// Check to see if we have some POST data, if we do process it
if (isset($_POST['email']) && isset($_POST['pass']))
{
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1)
    {
        $_SESSION["error"] = "User name and password are required";
        header("Location: login.php");
        return;
    }
    else
    {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $_SESSION["error"] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        }
        else
        {
            $check = hash('md5', $salt . $_POST['pass']);
            if ($check == $stored_hash)
            {
                // Redirect the browser to game.php
                error_log("Login success " . $_POST['email']);
                // Redirect the browser to view.php
                $_SESSION['name'] = $_POST['email'];
                $_SESSION["success"] = "Logged in.";
                header("Location: index.php");
                return;
            }
            else
            {
                  $_SESSION["error"] = "Incorrect password.";
                error_log("Login fail " . $_POST['email'] . " $check");
                header("Location: login.php");
                return;
            }
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Sayed Makhdum Ullah- Login Page</title>
<!-- bootstrap.php - this is HTML -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<!--  Note triple not equals and think how badly double
not equals would work here...-->
<?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
?>

<form method="POST" action="login.php">
<label for="nam">Email</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" onclick="return doValidate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is  php123. -->
</p>

</div>
</body>
</html>
