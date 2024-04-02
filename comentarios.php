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
    $result_usuario = mysqli_query($conn, $query_usuario);
    $row_usuario = mysqli_fetch_assoc($result_usuario);
    $usuario_id = $row_usuario['id'];
   } else {
       // Si el usuario no ha iniciado sesión, establecer un valor predeterminado o manejarlo según sea necesario
       $username = "Anónimo";
   }
   $horaActual = date('Y-m-d H:i:s');
  // Procesar el envío del formulario
if(isset($_POST['enviar'])) {
    $mensaje = trim($_POST['mensaje']); // Eliminar espacios en blanco al inicio y al final
    echo "Valor del comentario: '$mensaje'";
    if(!empty($mensaje)) {
        // Insertar el comentario en la base de datos
        $query = "INSERT INTO comentarios (usuario_id, mensaje) VALUES ('$usuario_id', '$mensaje')";
        mysqli_query($conn, $query);
    } else {
        // Si el comentario está vacío, puedes mostrar un mensaje de error o simplemente ignorarlo
        echo "El comentario está vacío. Por favor ingrese un comentario válido.";
    }
}
// Obtener los comentarios de la base de datos con el nombre de usuario
$query = "SELECT comentarios.id, usuario.username, comentarios.mensaje, comentarios.fecha 
          FROM comentarios 
          INNER JOIN usuario ON comentarios.usuario_id = usuario.id 
          ORDER BY comentarios.fecha DESC";
$result = mysqli_query($conn, $query);
$comentarios = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Redes Inalámbricas</title>
    <link rel="stylesheet" href="menu.css?v=<?php echo filemtime('menu.css'); ?>">
    <style>
     
        * {
    margin: 0;
    padding: 0;
    }



.container {
    background: #fff;
    padding: 20px;
    font-family: monospace;
    width: 90%; /* Anchura del contenedor al 90% del ancho de la página */
     max-width: 900px; /* Máximo ancho del contenedor */
    box-shadow: 0 0 5px #000;
    margin-top: 50px ;
    margin-left: auto; /* Mover el contenedor a la derecha */
     margin-right: auto; 

}

.head {
    text-transform: uppercase;
    margin-bottom: 20px;
}

.text {
    margin: 10px 0;
    font-family: sans-serif;
    font-size: 0.9em;
}

.commentbox {
    display: flex;
    justify-content: space-around;
    padding: 10px;
}

.commentbox > img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    /* float: left; */
    margin-right: 20px;
    object-fit: cover;
    object-position: center;
}

.content {
    width: 100%;
}

.user {
    border: none;
    outline: none;
    margin: 5px 0;
    color: #808080;
    margin-left: 20px;
    padding: 10px;
}

.commentinput > input {
    border: none;
    padding: 10px;
    padding-left: 0;
    outline: none;
    border-bottom: 2px solid blue;
    margin-bottom: 10px;
    width: 95%;
}

.buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #808080;
}

.buttons > button {
    padding: 5px 10px;
    background: lightgrey;
    color: #808080;
    text-transform: uppercase;
    border: none;
    outline: none;
    border-radius: 3px;
    cursor: pointer;
}

.buttons > button.abled {
    background: blue;
    color: #fff;
}

.policy {
    margin: 20px 0;
    font-size: 0.8em;
    font-family: Arial, sans-serif;
    color: #808080;
}

.policy a {
    text-decoration: none;
    color: blue;
}

.notify {
    margin-right: 10px;
    display: flex;
    align-items: center;
}

.notify > input {
    margin-right: 5px;
    border: 2px solid #808080;
}

.parents {
    font-family: Arial, sans-serif;
    display: flex;
    margin-bottom: 30px;
}

.parents h1 {
    font-size: 0.9em;
}

.parents p {
    margin: 10px 0;
    font-size: 0.9em;
}

.parents > img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 20px;
    object-fit: cover;
    object-position: center;
}

.engagements {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.engagements img {
    width: 20px;

}

.engagements img:nth-child(1) {
    margin-right: 10px;
    width: 25px;
}

.date {
    color: #808080;
    font-size: 0.8em;
}


    </style>
</head>
<body>
    <nav class="menu">
      
    <div class="logo white-border"></div>
        <span class="neon-text">ANE 2023</span> 
    
    <ul class="menu_items">
        <li class="menu_item">
            <a href="home.php" class="menu_item-link">Inicio</a>
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

<div class="container">
    <div class="head"><h1>Historial de comentarios</h1></div>
    <div><span id="comment">0</span> Comentarios</div>
    <div class="text"><p>Tus comentarios son importantes para nosotros</p></div>
    <div class="comments">
        <!-- Aquí se mostrarán los comentarios anteriores  -->
        <?php foreach ($comentarios as $comentario) : ?>
            <div class="comment">
                <h4><?php echo $comentario['username']; ?></h4>
                <p><?php echo $comentario['mensaje']; ?></p>
                <p><?php echo $comentario['fecha']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Formulario para enviar comentarios -->
    <form method="post" onsubmit="return validarComentario()">
        <div class="commentbox">
            <img src="user-solid.svg" alt="">
            <div class="content">
                <h2>Usuario: <label class="user"><?php echo $username; ?></label></h2>
                <div class="commentinput">
                <textarea placeholder="Ingrese un comentario" class="usercomment" name="mensaje"></textarea>
                    <div class="buttons">
                        <button type="submit" name="enviar"  disabled id="publish">Publicar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
function validarComentario() {
    var comentario = document.querySelector('.usercomment').value.trim();
    if (comentario === '') {
        var alerta = alert('Por favor, ingrese un comentario.');
        setTimeout(function() {
            alerta.close(); // Cierra la alerta después de 3 segundos (3000 milisegundos)
        }, 5000);
        return false; // Evita que se envíe el formulario si el comentario está vacío
    }
    return true; // Permite enviar el formulario si el comentario no está vacío
}

</script>
<script>

const horaACtual = "<?php echo $horaActual; ?>";

const USERID = {
name: null,
identity: null,
image: null,
message: null,
date: null
}

const userComment = document.querySelector(".usercomment");
const publishBtn = document.querySelector("#publish");
const comments = document.querySelector(".comments");
const userName = document.querySelector(".user");
const notify = document.querySelector(".notifyinput");

userComment.addEventListener("input", e => {
    if(!userComment.value) {
        publishBtn.setAttribute("disabled", "disabled");
        publishBtn.classList.remove("abled")
    }else {
        publishBtn.removeAttribute("disabled");
        publishBtn.classList.add("abled")
    }
})

function addPost() {
    if(!userComment.value) return;
    // Obtener el nombre de usuario del PHP directamente
        USERID.name = "<?php echo $username; ?>";
    if(USERID.name === "Anonimo") {
        USERID.identity = false;
        USERID.image = "anonimo.png"
    }else {
        USERID.identity = true;
        USERID.image = "user-solid.svg"
    }

    USERID.message = userComment.value;
    USERID.date = horaACtual; // Utilizar la hora del servidor PHP colombia
    let published = 
    `<div class="parents">
        <img src="${USERID.image}">
        <div>
            <h1>${USERID.name}</h1>
            <p>${USERID.message}</p>
            <div class="engagements"><img src="share.png" alt=""></div>
            <span class="date">${USERID.date}</span>
        </div>    
    </div>`

    comments.innerHTML += published;
    userComment.value = "";
    publishBtn.classList.remove("abled")

    let commentsNum = document.querySelectorAll(".parents").length;
    document.getElementById("comment").textContent = commentsNum;

}

publishBtn.addEventListener("click", addPost);

</script>

</body>

</html>
