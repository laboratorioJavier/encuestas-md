<?php

session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ÍNDICE DE EVOLUCIÓN DIGITAL RED PBM</title>    

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="../assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- SweetAlert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <div class="main">
        <div class="container">
            <div class="signup-content">
                <div class="signup-desc">
                    <div class="signup-desc-content">
                    <img src="../assets/images/Logo_PbM_Blanco.png" class="logo_img">
                    </div>
                </div>
                <div class="signup-form-conent">
                    <div class="text-center panel-group" id="informacionContacto">
                        <h4 class="no-padding text-center">Para realizar la encuesta, por favor, ingrese su correo electrónico y la clave de acceso que le fue enviada:</h4>
                        <br>
                        <form action="../controllers/empresa.php" method="POST" id="formLogin" name="formLogin">
                            <div class="row">
                                <div class="col-xs-4 text-right">
                                    <label for="email">Correo electrónico</label>
                                </div>
                                <div class="col-xs-8 no-padding text-left">
                                    <input type="email" class="form-control input-en-linea" name="email" id="email" placeholder="ejemplo@correo.com" require/>
                                    <i class="fas fa-check-circle"></i>
                                    <i class="fas fa-exclamation-circle"></i>
                                    <small>Error message</small>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <label for="password">Clave de acceso</label>
                                </div>
                                <div class="col-xs-8 no-padding text-left">
                                    <input type="password" class="form-control input-en-linea" name="password" id="password" placeholder="********" required/>
                                    <i class="fas fa-check-circle"></i>
                                    <i class="fas fa-exclamation-circle"></i>
                                    <small>Error message</small>
                                </div>
                            </div>
                            <br />
                            <h5>¿Aún no posee una clave de acceso? <a href="index.php">Solicítela aquí</a></h5>
                            <br />
                            <button type="button" class="btn btn-primary" onclick="enviarDatos()">Iniciar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <?php

            $mysqli = new mysqli("107.180.46.153", "encuesta_md", 'k1$sqKp_364w', "encuesta_md");
            if ($mysqli->connect_error) {
                die("Conexión falló: " . $mysqli->connect_error);
            }
            $mysqli->set_charset("utf8");

            $sql = "select * from usuario";

            $res = $mysqli->query($sql);
            
            $rows = mysqli_fetch_object($res);
            if(!$rows) {
                echo "error";
            }
            else{
                foreach($rows as $row){
                    echo $row;
                }
            }


        ?>
    </div>

    <!-- JS -->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../assets/vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="../assets/vendor/jquery-steps/jquery.steps.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="./js/login.js"></script>

<?php
    if (isset($_SESSION['error'])) {
        switch ($_SESSION['error']) {
        case 'wrong_credentials': 
            echo "<script>Swal.fire(
                'ERROR!',
                'El correo o la clave de acceso son incorrectos',
                'error'
              );</script>";
            break;
        case 'bad_request':
            echo "<script>Swal.fire(
                'ERROR!',
                'Debe suministrar su correo electrónico y clave de acceso para realizar la encuesta',
                'error'
            );</script>";
            break;
        default: 
            echo "<script>Swal.fire(
                'ERROR!',
                'Ocurrió un error desconocido. Por favor, intente de nuevo',
                'error'
              );</script>";
        }
    } elseif (isset($_SESSION['registro'])) { ?>
            <script>Swal.fire(
                'CORRECTO!',
                'Se ha enviado al correo suministrado su clave de acceso',
                'success'
                );</script>
    <?php
    }
    session_destroy();
    ?>

</body>

</html>