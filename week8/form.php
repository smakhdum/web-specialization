<?php $oldguess=isset($_POST['guess'])? $_POST['guess']:''; ?>
<!DOCTYPE html>
<head><title>Sayed Makhdum Ullah MD5 Cracker</title></head>
<body>
  <form method="post">
    <input type="text" name="guess" id="guess" value="<?= htmlentities($oldguess) ?>" />
    <input type="submit"/>
  </form>
  <pre>
    $_POST:
    <?php print_r($_POST); ?>
  </pre>
</body>
