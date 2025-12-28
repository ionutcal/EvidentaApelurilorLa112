<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "baza_de_date";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}
?>
