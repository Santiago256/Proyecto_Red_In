<?php
    include('conexionBD.php');
    if (isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($conn, $_POST['user']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpass']);

        
        
        $sql = "Select * from usuario where username='$username'";
        $result = mysqli_query($conn, $sql);        
        $count_user = mysqli_num_rows($result);  

        $sql = "Select * from usuario where email='$email'";
        $result = mysqli_query($conn, $sql);        
        $count_email = mysqli_num_rows($result);  
        
        if($count_user == 0 && $count_email==0){  
            
            if($password == $cpassword) {
    
                $hash = password_hash($password, 
                                    PASSWORD_DEFAULT);
                    
                // Password Hashing is used here. 
                $sql = "INSERT INTO usuario(username, email, password) VALUES('$username', '$email','$hash')";
        
                $result = mysqli_query($conn, $sql);
        
                if ($result) {
                    header("Location: home.php");
                }
            } 
            else { 
                echo  '<script>
                        alert("Contraseñas no coinciden")
                        window.location.href = "Registarse.php";
                    </script>';
            }      
        }  
        else{  
            if($count_user>0){
                echo  '<script>
                        window.location.href = "index.php";
                        alert("Usuario ya existe!!")
                    </script>';
            }
            if($count_email>0){
                echo  '<script>
                        window.location.href = "index.php";
                        alert("Email ya existe !!")
                    </script>';
            }
        }     
    }
    ?>