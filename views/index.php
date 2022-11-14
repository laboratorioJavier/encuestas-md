<?php

session_start();

include_once '../models/Empresa.php';
$objEmpresa = new Empresa();
$rubros = $objEmpresa->getRubros();

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
                    <img src="../assets/images/Logo_PbM_Blanco.png" alt="" class="logo_img">
                    </div>
                </div>
                <div class="signup-form-conent">
                    <div class="text-center panel-group" id="informacionContacto">
                        <h4 class="no-padding text-center">Para realizar la encuesta, por favor, ingrese su información de contacto:</h4>
                        <br />
                        <form action="../controllers/empresa.php" method="POST" id="formContacto" name="formContacto">
                            <div class="row">
                                <div class="col-xs-4 text-right">
                                    <label for="nombre_representante">Nombre</label>
                                </div>
                                <div class="col-xs-8 no-padding text-left">
                                    <input type="text" class="form-control input-en-linea" name="nombre_representante" id="nombre_representante" placeholder="Su Nombre" required/>
                                    <i class="fas fa-check-circle"></i>
                                    <i class="fas fa-exclamation-circle"></i>
                                    <small>Error message</small>
                                </div>
                         
                                <div class="col-xs-4 text-right">
                                    <label for="email">Correo electrónico</label>
                                </div>
                                <div class="col-xs-8 no-padding text-left">
                                    <input type="email" class="form-control input-en-linea" name="email" id="email" placeholder="ejemplo@correo.com" required/>
                                    <i class="fas fa-check-circle"></i>
                                    <i class="fas fa-exclamation-circle"></i>
                                    <small>Error message</small>
                                </div>

                                <div class="col-xs-4 text-right">
                                    <label for="telefono">Teléfono</label>
                                </div>
                                <div class="col-xs-8 no-padding text-left">
                                    <input type="tel" class="form-control input-en-linea" name="telefono" id="telefono" placeholder="+(58) 001112222" required/>
                                    <i class="fas fa-check-circle"></i>
                                    <i class="fas fa-exclamation-circle"></i>
                                    <small>Error message</small>
                                </div>

                                <div class="col-xs-4 text-right">
                                    <label for="cargo">Cargo</label>
                                </div>
                                <div class="col-xs-8 no-padding text-left">
                                    <input type="text" class="form-control input-en-linea" name="cargo" id="cargo" placeholder="Ingrese Cargo" required/>
                                    <i class="fas fa-check-circle"></i>
                                    <i class="fas fa-exclamation-circle"></i>
                                    <small>Error message</small>
                                </div>

                                <div class="col-xs-4 text-right">
                                    <label for="rif_empresa">RIF Empresa</label>
                                </div>
                                <div class="col-xs-8 no-padding text-left">
                                    <input type="text" class="form-control input-en-linea" name="rif_empresa" id="rif_empresa" placeholder="J-123456789" required/>                               
                                    <button type="button" class="btn btn-primary" id="buscarRIF" onclick="buscarRif()">Buscar</button>
                                    <i class="fas fa-check-circle"></i>
                                    <i class="fas fa-exclamation-circle"></i>
                                    <small>Error message</small> 
                                </div>

                                <div class="col-xs-4 text-right">
                                    <label for="nombre_empresa">Empresa</label>
                                </div>
                                <div class="col-xs-8 no-padding text-left">
                                    <input type="text" class="form-control input-en-linea" name="nombre_empresa" id="nombre_empresa" disabled />
                                </div>
                                <div class="col-xs-4 text-right">
                                    <label for="rubro">Rubro</label>
                                </div>
                                <div class="col-xs-8 no-padding text-left">
                                    <select class="form-control input-en-linea" name="rubro" id="rubro" disabled>
                                        <option value="">-- Seleccione un rubro --</option>
                                    <?php
                                    foreach ($rubros as $rubro) { ?>
                                        <option value="<?= $rubro["id"] ?>"><?= $rubro["descripcion"] ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <br />
                            <h5>Red PbM se compromete a proteger y respetar la confidencialidad de los datos entregados</h5>
                            <h5>¿Ya tiene su clave de acceso? <a href="login.php">Ingrésela aquí</a></h5>
                            <br />
                            <button type="button" class="btn btn-primary" onclick="enviarDatos()">Solicitar clave de acceso</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
    </div>

    <!-- JS -->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../assets/vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="../assets/vendor/jquery-steps/jquery.steps.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="./js/index.js"></script>

<?php 
    if (isset($_SESSION['error'])) {
        switch ($_SESSION['error']) {
        case 'usuario_existe': 
            echo "<script>Swal.fire(
                'ERROR!',
                'El correo electrónico " . $_SESSION['email'] . " ya está registrado en nuestro sistema. Inicie sesión o verifique sus datos y contáctenos si cree que se trata de un error',
                'error'
              );</script>";
            break;
        case 'bad_request':
            echo "<script>Swal.fire(
                'ERROR!',
                'El enlace provisto fue inválido, por lo tanto se le redirigió a la página de registro',
                'error'
              );</script>";
            break;
        case 'fallo_registro_empresa':
            echo "<script>Swal.fire(
                'ERROR!',
                'Ocurrió un error al registrar la empresa. Por favor, intente de nuevo',
                'error'
              );</script>";
            break;
        case 'fallo_registro_usuario':
            echo "<script>Swal.fire(
                'ERROR!',
                'Ocurrió un error al registrar el usuario. Por favor, intente de nuevo',
                'error'
              );</script>";
            break;
        case 'fallo_registro_representante':
            echo "<script>Swal.fire(
                'ERROR!',
                'Ocurrió un error al registrar el representante. Por favor, intente de nuevo',
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
    }
    unset($_SESSION['error']);
    ?>

</body>

</html>