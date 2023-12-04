<?php
//conecta la base de datos PDO                                                                                         
include("database.php");
// Datos del formulario de inicio de sesión
$correo_electronico = $_POST['email'];
$contrasena = $_POST['password'];
try {
    // Consulta para verificar el inicio de sesión
    $consulta_login = "SELECT * FROM usuario WHERE correo = :correo_electronico AND password = :contrasena";
    $stmt_login = $pdo->prepare($consulta_login);
    $stmt_login->bindParam(':correo_electronico', $correo_electronico, PDO::PARAM_STR);
    $stmt_login->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
    $stmt_login->execute();
    // Verificar si las credenciales son válidas
    if ($stmt_login->rowCount() > 0) {
        // Inicio de sesión exitoso
        echo "Inicio de sesión exitoso.";
        // Obtener el id del usuario
        $row = $stmt_login->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['id'];
        // Crear una variable de sesión con el id del usuario
        session_start();
        $_SESSION['user_id'] = $user_id;
        // Redirigir a la página de inicio después de un inicio de sesión exitoso
        header('Location: ../views/feed.php');
    } else {
        // Credenciales no válidas
        echo "Correo electrónico o contraseña incorrectos.";
    }
} catch (PDOException $e) {
    echo "Error en el inicio de sesión: " . $e->getMessage();
}
// Cerrar la conexión
$pdo = null;
?>

