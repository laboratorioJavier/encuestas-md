<?php
    session_start();

    include_once '../models/Encuesta.php';
    include_once '../models/Resultado.php';
    $objEncuesta = new Encuesta();
    $objResultado = new Resultado();
    
    $objeto = [];
    $resultado = [];
    $promedio_general = 0;

    $venezuela = [1.9, 1.9, 1.4, 1.6, 1.5];
    $acum = 0;
    $cont = 0;
    foreach ($venezuela as $v) {
        $acum += $v;
        $cont++;
    }
    $promedioVenezuela = round($acum / $cont, 1);

    $mundo = [2.9, 2.1, 2.7, 2.2, 2.4];
    $acum = 0;
    $cont = 0;
    foreach ($mundo as $m) {
        $acum += $m;
        $cont++;
    }
    $promedioMundo = round($acum / $cont, 1);

    if (isset($_GET['token'])) {
        $result = $objEncuesta->getEstructuraRespuestasPorTokenEncuesta($_GET['token']);
        if (count($result) == 0) {
            $_SESSION['error'] = 'bad_request';
            header('Location: index.php');
            return;
        }
        $objeto = $objEncuesta->formatQueryResultEstructuraToObject($result);
        $resultado = $objResultado->getResultadosPorTokenEncuesta($_GET['token']);
        $acum = 0;
        $cont = 0;
        foreach ($resultado as $pilar) {
            $acum += floatval($pilar['promedio_pilar']);
            $cont++;
        }
        $promedio_general = round($acum / $cont, 1);
    } else {
        $_SESSION['error'] = 'bad_request';
        header('Location: index.php');
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
    <title>OBTÉN AHORA TU ÍNDICE DE EVOLUCIÓN DIGITAL RED PBM</title>

    <!-- Load Chart.js from a CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

    <!-- Font Icon -->
    <link rel="stylesheet" href="../assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>


    <!-- Main css -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <script src="../assets/js/chartjs/Chart.min.js"></script>
    <script src="../assets/js/chartjs/chartjs-plugin-datalabels.js"></script>

</head>

<body>

    <div class="main">

        <div class="container">
            <div class="signup-content" style="background-image: none;">
                <div class="signup-desc">
                    <div class="signup-desc-content">
                    
                        <img src="../assets/images/Logo_PbM_Blanco.png" class="logo_img">
                    
                        <p id="title" style="color:white;"></p>
                         
                    </div>
                </div>
                <div class="signup-form-conent" style="background-image: none;">
                    <div class="row">
                        <div class="col-xs-11" style="text-align:right">
                            <h4><?= $objeto['encuesta']['representante']['nombre'] ?></h4>
                            <h5>Su última conexión: <?= $objeto['encuesta']['representante']['usuario']['ultima_conexion'] ?></h5>
                        </div>
                        <div class="col-xs-2">
                                <form action="login.php" method="POST">
                                    <button type="submit" class="btn btn-primary" style="margin-left:20px;">Cerrar sesión</button>
                                </form>
                            </div>
                        <div class="col-xs-1"></div>
                    </div>
                    <form method="POST" id="signup-form" class="signup-form" enctype="multipart/form-data">
                      <br>


                        <div id="conte" style="position: relative; width: 100%;height: 80vh">
                        <canvas id="grafico" ></canvas>
                        </div>

                            <h5 class="padding-bottom-titulo text-left">
                               <p><strong>P1:</strong> Visión y Liderazgo.</p>
                            </h5>
                            <h5 class="padding-bottom-titulo text-left">
                               <p><strong>P2:</strong> Gente y Cultura.</p>
                            </h5>
                            <h5 class="padding-bottom-titulo text-left">
                               <p><strong>P3:</strong> Capacidades Organizacionales y Efectividad.</i>
                            </h5>
                            <h5 class="padding-bottom-titulo text-left">
                               <p><strong>P4:</strong> Innovación.</p>
                            </h5>
                            <h5 class="padding-bottom-titulo text-left">
                               <p><strong>P5:</strong> Tecnología.</p>
                            </h5>
                    

                        <div class="row">
                            <h6 class="padding-bottom-titulo text-left">
                               <i>Fuente: datos promedios Bhaskar Chakravorti and Ravi Shankar Chaturvedi. The Fletcher School, Tufts University July 2017.</i>
                            </h6>
                            <div class="text-center">
                            <div class="col-xs-6 text-right">
                                <label for="promedioGeneral"><?php echo strtoupper($objeto['encuesta']['representante']['empresa']["nombre"]);?> su Índice de Evolución Digital es:</label>
                            </div>
                            <div class="col-xs-6 no-padding text-left">
                                <input class="form-control input-en-linea" type="text" name="promedioGeneral"
                                    id="promedioGeneral" required />
                            </div><br>

                            
                         
                        </div>
                    </form>
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
    <script src="./js/resultados.js"></script>

    <?php
        echo "<script>inicializarObjetoRespuestas(JSON.parse('" . json_encode($objeto) . "'));
        verGrafica(JSON.parse('" . json_encode($resultado) . "'), $promedio_general , " . json_encode($venezuela) . ", $promedioVenezuela, " . json_encode($mundo) . ", $promedioMundo);
        </script>";
        unset($_SESSION['usuario']);
    ?>

</body>


</html>