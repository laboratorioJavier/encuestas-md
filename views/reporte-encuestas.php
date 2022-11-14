<?php

session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
    $_SESSION['error'] = 'bad_request';
    header('Location: login.php');
    return;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RED PBM - Reporte Encuestas</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="../assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <!-- Main css -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- dataTable -->
    <link src="../assets/js/jquery-datable/skin/boostrap/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <script src="../assets/js/chartjs/Chart.min.js"></script>
    <script src="../assets/js/chartjs/chartjs-plugin-datalabels.js"></script>

    <!-- SweetAlert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="main">

        <div class="container">
            <div class="signup-content">
                <div class="signup-desc">
                    <div class="signup-desc-content">
                        <img src="../assets/images/Logo_PbM_Blanco.png" class="logo_img" />
                        <p id="title"></p>
                    </div>
                </div>
                <div class="signup-form-conent" style="background-image: none;">

                    <div class="text-center panel-group" id="informacionContacto">
                        <div class="row">
                            <div class="col-xs-4" style="text-align: left;">
                                <form method="POST" action="reporte-empresa.php">
                                    <button class="btn btn-primary">Ver Representantes</button>
                                </form>
                            </div>
                            <div class="col-xs-6" style="text-align:right">
                                <h4 class="no-margin-top"><?= $_SESSION['usuario']['email'] ?></h4>
                                <h5 class="no-margin-top">Su última conexión: <?= $_SESSION['usuario']['ultima_conexion'] ?></h5>
                            </div>
                            <div class="col-xs-2">
                                <form action="login.php" method="POST">
                                    <button type="submit" class="btn btn-primary">Cerrar sesión</button>
                                </form>
                            </div>
                        </div>
                        <br>
                        
                        <div class="panel panel-default"><br>

                            <!-- Default panel contents -->
                            <div class="panel-heading">
                                <h4>Información de Encuestas</h4>
                            </div><br>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tabla_encuestas">

                                        <thead>

                                            <th class="text-center">Representante</th>
                                            <th class="text-center">Empresa</th>
                                            <th class="text-center fecha">Fecha</th>
                                            <th class="text-center">Promedio General</th>
                                            <?php  
                                             include_once '../models/Encuesta.php';
                                             $objEncuesta = new Encuesta();
                                             $resultados = $objEncuesta->getAll();
                                             $resultados = $objEncuesta->formatQueryResultToObject($resultados);
                                             foreach ($resultados as $pilar) {?>
                                                <th><?=$pilar['titulo'] ?></th>
                                            <?php } ?>
                                        <tbody>

                                            <?php 
                                         include_once '../models/ReporteEncuestas.php';
                                         $objEncuesta = new ReporteEncuestas();
                                         $encuestas = $objEncuesta->getEncuestas();
                                         $encuestas = $objEncuesta->formatObjecto($encuestas);
                                         
                                          foreach ($encuestas as $empresa) {?>
                                            <tr>
                                                <td class="text-center"><?php echo $empresa['representante_nombre'];?></td>
                                                <td class="text-center"><?php echo $empresa['empresa_nombre'];?></td>
                                                <td class="text-center"><?php echo $empresa['encuesta_fecha'];?></td>
                                                <td class="text-center">
                                                    <p style="font-weight:bold; color:black;">
                                                        <?php echo $empresa['promedio_general'];?></p>
                                                </td>
                                                <?php foreach ($resultados as $pilar) {?>
                                                <td><?= $empresa[$pilar['id']] ?></td>
                                                <?php } ?>

                                                <?php } ?>
                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>


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

    <script src=" ../assets/js/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../assets/js/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../assets/js/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="../assets/js/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="../assets/js/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="../assets/js/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="../assets/js/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="../assets/js/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="../assets/js/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    <script src="./js/reporte-encuestas.js"></script>



</body>


</html>