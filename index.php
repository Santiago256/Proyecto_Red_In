

<script>
    // Función para ocultar el mensaje después de cierto tiempo
    setTimeout(function(){
        var errorMessage = document.getElementById('error-message');
        if(errorMessage) {
            errorMessage.style.display = 'none';
        }
    }, 5000); // Oculta el mensaje después de 5 segundos (5000 milisegundos)
</script>

<?php 
    include 'conexionBD.php';
    // Iniciar sesión
    session_start();
    if (isset($_POST['submit'])) {
        $username = $_POST['user'];
        $password = $_POST['pass'];
        
        // Consulta SQL para buscar el usuario por su nombre de usuario
        $sql = "SELECT * FROM usuario WHERE username = '$username'";  
        $result = mysqli_query($conn, $sql);  
    
        if (mysqli_num_rows($result) == 1) {  
            $row = mysqli_fetch_assoc($result);
            // Verificar la contraseña utilizando password_verify
            if (password_verify($password, $row['password'])) {
                // Contraseña correcta
                // Iniciar sesión y establecer la variable $_SESSION['username']
                $_SESSION['username'] = $username;
                header("Location: home.php", true, 301);
                exit(); // Detener la ejecución del script después de la redirección
            } else {
                // Contraseña incorrecta
                echo '<div id="error-message" style="color: #ff0000; font-size: 18px; text-align: center; margin-top: 500px;">Usuario o contraseña incorrecta!!</div>';
            }
        } else {
            // Usuario no encontrado
            echo '<div id="error-message" style="color: #ff0000; font-size: 18px; text-align: center; margin-top: 500px;">Usuario o contraseña incorrecta!!</div>';
        }
    }
?>


<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"  href="style.css?v=3">
</head>
<body>
    
    <div class="login-box">
        <h2>Login</h2>
        <form name="form" action="index.php" onsubmit="return isvalid()" method="POST">
            <div class="user-box">
                <input type="text" name="user" id="user" required="">
                <label>Nombre de Usuario</label>   
            </div>
            <div class="user-box">
                <input type="password" name="pass" id="pass" required="">
                <label>Contraseña</label>
            </div>     
            <a href="#" onclick="document.getElementById('submit').click(); return false;">Ingresar</a>    
            <span></span>
            <span></span>
            <span></span>
            <span></span>
             </a> 
             <button id="registro-link" onclick="window.location.href='Registrarse.php'">Registrate</button>
        </div>
           
        </div>
        <!-- Botón oculto de tipo submit -->
         <input id="submit" name="submit"type="submit" style="display: none;" value="Ingresar" />
    </form>
    <script>
        function isvalid(){
            var user = document.form.user.value;
            var pass = document.form.pass.value;
            if(user.length=="" && pass.length==""){
                alert(" Usuario y contraseña esta vacío !!!");
                return false;
            }
            else if(user.length==""){
                alert(" Usuario está vacío!!!");
                return false;
            }
            else if(pass.length==""){
                alert("El campo contraseña está vacío!!!");
                return false;
            }
        }
        
    </script>
</body>
</html>
