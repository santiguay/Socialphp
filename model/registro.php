<?php
include("database.php");

// Datos del formulario
$correo_electronico = $_POST['email'];
$contrasena = $_POST['password'];

try {
    // Consulta para verificar si el correo electrónico ya existe
    $consulta_existencia = "SELECT * FROM usuario WHERE correo = :correo_electronico";
    $stmt_existencia = $pdo->prepare($consulta_existencia);
    $stmt_existencia->bindParam(':correo_electronico', $correo_electronico, PDO::PARAM_STR);
    $stmt_existencia->execute();

    // Verificar si el correo electrónico ya está registrado
    if ($stmt_existencia->rowCount() > 0) {
        echo "El correo electrónico ya está registrado.";
    } else {
        // Consulta preparada para la inserción
        $sql = "INSERT INTO usuario (correo, password) VALUES (:correo_electronico, :contrasena)";
        $stmt = $pdo->prepare($sql);

        // Vincular parámetros
        $stmt->bindParam(':correo_electronico', $correo_electronico, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);

        // Ejecutar la consulta de inserción
        $stmt->execute();
        echo "Registro insertado correctamente.";
        echo "<script>alert('Registro insertado correctamente.'); window.location.href='../views/login.php';</script>";
    }
} catch (PDOException $e) {
    echo "Error al insertar el registro: " . $e->getMessage();
}



// Cerrar la conexión
$pdo = null;
?>
