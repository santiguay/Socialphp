<?php
// Configuración de la base de datos (ajusta según tus datos)
$dns = "localhost";

$dbname= "redsocial";
$username = "root";
$password = "";

// Intentar la conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$dns;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}

?>




