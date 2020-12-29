<?php
echo "<pre>\n";
$servername = "localhost";
$username = "fred";
$password = "zap";


echo "<pre>\n";
$pdo=new PDO('mysql:host=localhost;port=3306;dbname=misc',
     $username, $password);
$stmt = $pdo->query("SELECT * FROM users");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

print($rows[0]['name']);


echo "</pre>\n";?>
