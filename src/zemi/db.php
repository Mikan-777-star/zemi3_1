<?php
$servername = "db";
$username = "root";
$password = "rootpassword";
$dbname = "zemi3";
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // PDOエラーモードを例外に設定
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);