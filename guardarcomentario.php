<?php 
include("conexionBD.php");
session_start();
date_default_timezone_set('America/Bogota'); // Establecer la zona horaria a Bogotá

// Verificar si el usuario ha iniciado sesión
if(isset($_SESSION['username'])) {
    // Si el usuario ha iniciado sesión, establecer el nombre de usuario en una variable
    $username = $_SESSION['username'];
    // Obtener el id del usuario desde la sesión o desde la base de datos
    $query_usuario = "SELECT id FROM usuario WHERE username = '$username'";
    $result_usuario = mysqli_query($conexion, $query_usuario); // Utiliza $conexion en lugar de $conn
    $row_usuario = mysqli_fetch_assoc($result_usuario);
    $usuario_id = $row_usuario['id'];
} else {
    // Si el usuario no ha iniciado sesión, establecer un valor predeterminado o manejarlo según sea necesario
    $username = "Anónimo";
}

// Procesar el envío del formulario
if(isset($_POST['enviar'])) {
    $mensaje = trim($_POST['mensaje']); // Eliminar espacios en blanco al inicio y al final
    if(!empty($mensaje)) {
        // Insertar el comentario en la base de datos
        $query = "INSERT INTO comentarios (usuario_id, mensaje, fecha) VALUES ('$usuario_id', '$mensaje', NOW())"; // Agrega la fecha actual
        if(mysqli_query($conexion, $query)) {
            echo "<p class='success'>Comentario guardado correctamente.</p>"; // Mensaje de éxito
        } else {
            echo "<p class='error'>Error al guardar el comentario: " . mysqli_error($conexion) . "</p>"; // Mensaje de error
        }
    } else {
        // Si el comentario está vacío, puedes mostrar un mensaje de error o simplemente ignorarlo
        echo "<p class='error'>El comentario está vacío. Por favor ingrese un comentario válido.</p>";
    }
}
?>
