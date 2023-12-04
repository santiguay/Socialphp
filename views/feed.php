
<?php
// feed.php

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Incluir archivo de conexión a la base de datos
include("../model/database.php");

// Consulta para obtener los posts
$consulta_posts = "SELECT posts.*, usuario.correo AS usuario FROM posts 
                   INNER JOIN usuario ON posts.user_id = usuario.id
                   ORDER BY timestamp DESC"; // Ajusta según tu estructura
$stmt_posts = $pdo->query($consulta_posts);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
  <title>feed</title>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 20px;
      background-color: #f4f4f4;
    }
    #nuevoPost {
      background-color: #3498db;
      border: 1px solid #2980b9;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      color: black;
    }
    #contenido {
      background-color: #fff;
      border: 1px solid #ddd;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    label {
      display: block;
      margin-bottom: 8px;
      color: #333;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      background-color: #2ecc71;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #27ae60;
    }

  .post {
          border: 1px solid #ddd;
          padding: 10px;
          margin-bottom: 15px;
          border-radius: 8px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .post h3 {
          color: #3498db;
          margin-bottom: 5px;
      }

      .post p {
          color: #555;
          margin-bottom: 10px;
      }

      .post .usuario-tiempo {
          font-size: 12px;
          color: #777;
      }
      nav {
            background-color: #333; /* Fondo negro */
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: #fff; /* Texto blanco */
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #3498db; /* Color al pasar el ratón por encima */
        }
  </style>
  <title>Foro</title>
</head>
<body>
<nav>
        <a href="login.php">Inicio</a>
        <a href="">Posts</a>
        <a href="register.php">Registrar</a>
    </nav>

<br>
  <div id="nuevoPost">
    <h2>Nuevo Post</h2>
    <form action="../model/feed.php" method="post">
      
      <label for="mensaje">Mensaje:</label>
      <textarea id="mensaje" name="mensaje" rows="4" required></textarea>
      <br>
      <input type="submit" value="Publicar">
    </form>
  </div>
  <?php
        // Mostrar los posts
        while ($row = $stmt_posts->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="post">';
            
            echo '<p>' . htmlspecialchars($row['post']) . '</p>';
            
            // Muestra el usuario y el tiempo transcurrido desde la publicación
            $fecha_creacion = new DateTime($row['timestamp']);
            $tiempo_transcurrido = $fecha_creacion->diff(new DateTime());

            echo '<p class="usuario-tiempo">';
            echo 'Publicado por ' . htmlspecialchars($row['usuario']);
            echo ' hace ' . tiempo_transcurrido($tiempo_transcurrido);
            echo '</p>';

            echo '</div>';
        }

        function tiempo_transcurrido($intervalo) {
            // Devuelve un formato personalizado del intervalo de tiempo
            // Puedes personalizar esto según tus necesidades
            if ($intervalo->y > 0) {
                return $intervalo->y . ' año(s)';
            } elseif ($intervalo->m > 0) {
                return $intervalo->m . ' mes(es)';
            } elseif ($intervalo->d > 0) {
                return $intervalo->d . ' día(s)';
            } elseif ($intervalo->h > 0) {
                return $intervalo->h . ' hora(s)';
            } elseif ($intervalo->i > 0) {
                return $intervalo->i . ' minuto(s)';
            } else {
                return 'unos segundos';
            }
        }
        ?>
      
</body>
</html>