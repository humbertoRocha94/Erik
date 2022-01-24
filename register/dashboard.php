<?php
//Aqui vamos agregar la lista de los usuarios
include("auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Usuarios</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
        <?php
            require('db.php');
			if(isset($_GET['aksi']) == 'delete'){
				$nik = $_GET["nik"];
				$cek = mysqli_query($con, "SELECT * FROM users WHERE id='$nik'");
				
                if(mysqli_num_rows($cek) == 0){
                    echo'<script type="text/javascript">alert("No se encontraron datos.");window.location.href="dashboard.php";</script>';
				}else{
					$delete = mysqli_query($con, "DELETE FROM users WHERE id='$nik'");
					if($delete){
                        echo'<script type="text/javascript">alert("Datos eliminado correctamente.");window.location.href="dashboard.php";</script>';
					}else{
                        echo'<script type="text/javascript">alert("Error, no se pudo eliminar los datos.");window.location.href="dashboard.php";</script>';
					}
				}
			}
        ?>
    <div class="form">
        <h1 class="login-title">Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>
        <h1>Lista de los usuarios</h1>
        <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Accion</th>
            
        </tr>
        <tr>
        <?php 
            require('db.php');
           
            $sql = 'SELECT * FROM users ORDER BY id DESC';
            $result   = mysqli_query($con, $sql);
            $eliminar = '';
            foreach ($result as $row) {

                if($_SESSION['username']==$row['username']){

                    $eliminar= '';

                }else{
                    $eliminar= '<a href="dashboard.php?aksi=delete&nik='.$row['id'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['username'].'?\')">Eliminar</a>';

                }
            echo '<tr>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '
            <td>
 
			<a href="edit.php?nik='.$row['id'].'&se='. $_SESSION['username'].' title="Editar datos">Editar</a>
			'.$eliminar.'
			</td>
            ';
            echo '</tr>';
            }
            
        ?>
        </tr>
        </table>

        <p><a href="logout.php">Cerrar Sesión</a></p>
    </div>
</body>
</html>
