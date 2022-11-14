<?php
session_start(); //Iniciamos o Continuamos la sesion

include_once '../models/Empresa.php';
include_once '../models/Encuesta.php';
include_once '../models/Resultado.php';
include_once 'envioEmail.php';

$mode = $_REQUEST['mode'];

$objEmpresa = new Empresa();
$objEncuesta = new Encuesta();
$objResultado = new Resultado();
$objEnvioEmail = new EnvioEmail();
unset($_SESSION['error']);
unset($_SESSION['registro']);
unset($_SESSION['email']);

if ($mode == 'loadAll') {

    $encuesta = $objEncuesta->getAll();

    $response = $objEncuesta->formatQueryResultToObject($encuesta);

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
} elseif ($mode == "guardarRespuestas") {
    $representante = $_SESSION['usuario']['representante'];
    $idEmpresa = $representante['empresa_id'];
    $nombre_representante = $representante["nombre"];
    $nombre_empresa = $representante["empresa_nombre"];
    $email = $_SESSION['usuario']["email"];
    $telefono = $representante["telefono"];
    $opciones = json_decode($_POST["opciones"]);

    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);

    $idEncuesta = $objEncuesta->insertEncuesta($representante['id'], $token);
    if ($idEncuesta) {
        if ($objEncuesta->insertRespuestas($idEncuesta, $opciones)) {
            $result = $objEncuesta->getEstructuraRespuestasPorTokenEncuesta($token);
            $encuesta = $objEncuesta->formatQueryResultEstructuraToObject($result);
            $resultados = $encuesta['resultados'];
            $encuesta = $encuesta['encuesta'];
            $empresa = $encuesta['representante']['empresa'];

            $rif_empresa = $empresa["rif"];
            $cargo = $representante["cargo"];
            $rubro = $empresa["rubro"]["descripcion"];

            $promedios = $objEncuesta->calcularPromedios($resultados);
            $acum = 0;
            $cont = 0;

            foreach ($promedios as $pilar) {
                $acum += $pilar['promedio_pilar'];
                $objResultado->insertResultado($idEncuesta, $pilar['id'], $pilar['promedio_pilar']);
                $cont++;
            }
            $promedio_general = round($acum / $cont, 1);

            $objEnvioEmail->enviarEmailEncuesta($email, $nombre_representante, $nombre_empresa, $rif_empresa, $rubro, $cargo, $telefono, $token, $promedio_general);
            header("Location: ../views/resultados.php?token=$token");
            return;
        }
    }
    // Si llega hasta aquí, es que no pudo insertar la encuesta o las respuestas
    $_SESSION['error'] = 'fallo_registro_encuesta';
    header('Location: ../views/encuesta.php');

}