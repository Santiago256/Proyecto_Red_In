<?php
// Iniciar sesión
session_start();

// Verificar si el usuario no está autenticado
if (!isset($_SESSION['username'])) {
    // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
    header("Location: index.php");
    exit();
}
// Si el usuario está autenticado, se le permite acceder a la página

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="menu.css?v=<?php echo filemtime('menu.css'); ?>">
</head>
<body>
    
    <nav class="menu">
      
            <div class="logo white-border"></div>
            <span class="neon-text">ANE 2023</span> 
        
        <ul class="menu_items">
            <li class="menu_item">
                <a href="#" class="menu_item-link">Inicio</a>
            </li>
            <li class="menu_item">
                <a href="#" class="menu_item-link">Blog</a>
            </li>
            <li class="menu_item">
                <a href="comentarios.php" class="menu_item-link">Comentarios </a>
            </li>
            <li class="menu_item">
            <form action="CerrarSesion.php" method="post">
                <a href="CerrarSesion.php" class="menu_item-link">Cerrar sesión </a>
             </form>
            </li>
      
        </ul>
    </nav>
</body>
<footer>
    <!-- Pie de página con créditos y enlaces -->
    <p>&copy; Universidad Distrital Francisco José de caldas - Asignatura: Redes Inalámbricas - Fecha: [29/03/2024]</p>
    <p>Docente: Marlon Patiño Bernal - Email: marlonpb@udistrital.edu.co</p>
    <p>Autores: Jhonathan Yesid Duarte Bello y Santiago Alejandro Gutiérrez Barrero</p>
</footer>
</html>
