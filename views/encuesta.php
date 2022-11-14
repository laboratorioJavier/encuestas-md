<?php

session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] == 1) {
    $_SESSION['error'] = 'bad_request';
    header('Location: login.php');
    return;
}

include_once '../models/Encuesta.php';
$objEncuesta = new Encuesta();
$result = $objEncuesta->getAll();
$pilares = $objEncuesta->formatQueryResultToObject($result);

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


</head>

<body>

    <div class="main">

        <div class="container">
            <div class="signup-content">
                <div class="signup-desc">
                    <div class="signup-desc-content">
                        <img src="../assets/images/Logo_PbM_Blanco.png" class="logo_img">
                        <p class="title" style="padding-top: 100px;" id="tituloPilar"><?= $pilares[0]["titulo"] ?></p>
                        <p class="desc" id="descripcionPilar">
                            <?= $pilares[0]["descripcion"] ?>
                        </p>
                        <!-- <img src="assets/images/signup-img.jpg" alt="" class="signup-img"> -->
                    </div>
                </div>
  
                <div class="signup-form-conent" style="background-image: none;">
                       <div class="row" style="text-align:right;">
                            <div class="col-xs-6" style="text-align:left; margin-left:10%;">
                                <h4><?= $_SESSION['usuario']['representante']['nombre'] ?></h4>
                                <h5>Su última conexión: <?= $_SESSION['usuario']['ultima_conexion'] ?></h5>
                            </div>
                            <div class="col-xs-4" style="text-align: right; margin-left: 0%;">
                                <form action="login.php" method="POST">
                                    <button type="submit" class="btn btn-primary">Cerrar sesión</button>
                                </form>
                            </div>
                        </div> 


                    <div class="col-xs-1"></div>
                    
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <h4 class="text-justify padding-bottom-titulo">
                         Lea las características para cada uno de los 5 niveles de Evolución Digital (de 'Básico' a
                            'Evolucionado') y marque las opciones que considere aplicables según su percepción
                            de su organización. Puede marcar todas las alternativas que considere adecuadas,
                            pero si no aplica, se pueden dejar niveles sin marcar, aunque es obligatorio <u>marcar al
                            menos una alternativa por pilar.</u>
                        </h4>
                        <?php
                    $desplegado = true;
                    foreach ($pilares as $pilar) {
                    ?>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading<?= $pilar["id"] ?>"
                                onclick="javascript:void(0)">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse<?= $pilar["id"] ?>"
                                        aria-expanded="<?= $desplegado ? 'true' : 'false' ?>"
                                        aria-controls="collapse<?= $pilar["id"] ?>">
                                        <i
                                            class="more-less glyphicon glyphicon-<?= $desplegado ? 'minus' : 'plus' ?>"></i>
                                        <?= $pilar["id"] . '. ' . $pilar["titulo"] ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse<?= $pilar["id"] ?>"
                                class="panel-collapse collapse <?= $desplegado ? 'in' : '' ?>" role="tabpanel"
                                aria-labelledby="heading<?= $pilar["id"] ?>">
                                <div class="panel-body">
                                    <form method="POST" class="signup-form" enctype="multipart/form-data"
                                        data-id="<?= $pilar["id"] ?>">
                                        <?php
                                    $cantNiveles = count($pilar["niveles"]);
                                    
                                    foreach ($pilar["niveles"] as $nivel) {
                                       
                                    ?>
                                        <h3></h3>
                                        <fieldset>
                                            <span class="step-current">Nivel
                                                <?= $nivel["id"] . ' (' . $nivel["titulo"] . ')' ?></span>
                                            <?php
                                        foreach ($nivel["opciones"] as $opcion) {
                                        ?>
                                            <div class="form-group row">
                                                <div class="col-xs-1 text-right">
                                                    <input type="checkbox"
                                                        name="nivel<?= $nivel["id"] ?>pilar<?= $pilar["id"] ?>[]"
                                                        id="opcion<?= $opcion["id"] ?>" value="<?= $opcion["id"] ?>"
                                                        data-nivel-id="<?= $nivel["id"] ?>" required />
                                                </div>
                                                <div class="col-xs-11 no-padding">
                                                    <label
                                                        for="opcion<?= $opcion["id"] ?>"><?= $opcion["descripcion"] ?></label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        </fieldset>
                                        <?php
                                    }
                                    ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                        $desplegado = false;
                    }
                    ?>
                    </div><!-- panel-group -->
                    <div class="text-center display-none" id="informacionContacto">
                        <h2 class="no-padding text-center">¡Gracias por completar la encuesta!</h2>
                        <h4 class="text-center">Para ver sus resultados, por favor, presione el siguiente botón:</h4>
                        <form action="../controllers/encuesta.php" method="POST" id="formEncuesta">
                            <button type="button" class="btn btn-primary" onclick="enviarDatos()">Ver
                                resultados</button>
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
    <script src="./js/encuesta.js"></script>
    <script src="../sweetalert/dist/sweetalert.min.js"></script>
    <script>
        inicializarPilares(JSON.parse('<?= json_encode($pilares) ?>'));
        guardarDatosEmpresa("<?= $_SESSION['usuario']['representante']['nombre'] ?> ");

    </script>
    <?php
        if (isset($_SESSION['error'])) {
            switch ($_SESSION['error']) {
            case 'bad_request': 
                echo "<script>Swal.fire(
                    'ERROR!',
                    'Debe completar la encuesta para poder ver sus resultados',
                    'error'
                  );</script>";
                break;
            case 'fallo_registro_encuesta':
                echo "<script>Swal.fire(
                    'ERROR!',
                    'Ocurrió un error al registrar las respuestas de la encuesta. Por favor, intente de nuevo',
                    'error'
                  );</script>";
                break;
            default:
                echo "<script>Swal.fire(
                    'ERROR!',
                    'Ocurrió un error inesperado. Por favor, intente de nuevo',
                    'error'
                  );</script>";
            }
        }
    ?>
</body>


</html>