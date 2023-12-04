<?php
//conecta la base de datos PDO                                                                                         
include("database.php");
// Verificar si hay una variable de sesión con el id del usuario
session_start();
if (isset($_SESSION['user_id'])) {
    // Obtener el id del usuario de la variable de sesión
    $user_id = $_SESSION['user_id'];
    // Datos del formulario de nuevo post
    $titulo = $_POST['titulo'];
    $mensaje = $_POST['mensaje'];
    // Obtener el timestamp actual
    $timestamp = date('Y-m-d H:i:s');
    try {
        // Consulta para insertar el post en la tabla posts
        $consulta_post = "INSERT INTO posts (post, user_id, timestamp) VALUES ( :mensaje, :user_id, :timestamp)";
        $stmt_post = $pdo->prepare($consulta_post);
        
        $stmt_post->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);
        $stmt_post->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_post->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);
        $stmt_post->execute();
        // Post creado exitosamente
        echo "Post creado exitosamente.";
        // Puedes redirigir a la página de contenido después de crear el post
        // Ejemplo: header('Location: pagina_contenido.php');
        header('Location: ../views/feed.php');
    } catch (PDOException $e) {
        echo "Error al crear el post: " . $e->getMessage();
    }
    // Cerrar la conexión
    $pdo = null;
} else {
    // No hay una variable de sesión con el id del usuario
    echo "Debes iniciar sesión para crear un post.";
}
?>
