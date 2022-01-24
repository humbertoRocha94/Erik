<?php
//Aqui vamos agregar la lista de los usuarios
include("auth_session.php");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registro</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php

if(isset($_REQUEST['se'])){

    require('db.php');
		
   
    $nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
    $sql = mysqli_query($con, "SELECT * FROM users WHERE id='$nik'");
    if(mysqli_num_rows($sql) == 0){
        header("Location: dashboard.php");
    }else{
        $row = mysqli_fetch_assoc($sql);
    }
    if(isset($_POST['save'])){
        $nombre		     = $_POST["username"];//Escapando caracteres 
        $correo		     = $_POST["email"];//Escapando caracteres 
        $query    = "UPDATE users SET username='$nombre', email='$correo' WHERE id='$nik'";
        $result   = mysqli_query($con, $query);
       
        if($result){
            $_SESSION['username'] = $nombre;
            header("Location: edit.php?nik=".$nik."&ok=ok&se=ok");
        }else{
            echo'<script type="text/javascript">alert("Error, no se pudo guardar los datos.");window.location.href="dashboard.php";</script>';
        }
    }
    
    if(isset($_GET['ok']) == 'ok'){
        
       echo'<script type="text/javascript">alert("Los datos han sido guardados con éxito.");window.location.href="dashboard.php";</script>';
    }
?>
<form class="form" action="" method="post">
            <h1 class="login-title">Editar registro  <? echo $_SESSION['username'];?></h1>
            <input type="text" class="login-input" name="username"  value="<?php echo $row ['username']; ?>" required />
            <input type="text" class="login-input" name="email" value="<?php echo $row ['email']; ?>">
            <input type="submit" name="save" value="Guardar" class="login-button">
            
    </form>
<?php

}else{
    echo "<div class='form'>
    <h3>Inicia Sesion</h3><br/>
    <p class='link'>Click aqui para <a href='registration.php'>registrarte</a> again.</p>
    </div>";

}
   
   
    ?>

    
 
</body>
</html>
