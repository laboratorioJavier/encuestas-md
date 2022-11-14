<?php
session_start(); //Iniciamos o Continuamos la sesion



//require "PHPMailerAutoload.php";

include '../models/Empresa.php';
include '../models/Representante.php';
include '../models/Usuario.php';
include 'envioEmail.php';

$mode = $_REQUEST['mode'];
$objEmpresa = new Empresa();
$objEnvioEmail = new EnvioEmail();
$objRepresentante = new Representante();
$objUsuario = new Usuario();
unset($_SESSION['error']);
unset($_SESSION['registro']);
unset($_SESSION['email']);
unset($_SESSION["empresa"]);

if ($mode == 'registrarRepresentante') {
    $nombre_representante = $_POST["nombre_representante"];
    $nombre_empresa = $_POST["nombre_empresa"];
    $rif_empresa = $_POST["rif_empresa"];
    $cargo = $_POST["cargo"];
    $id_rubro = $_POST["rubro"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];

    $usuario = $objUsuario->getUsuarioPorEmail($email);

    // VALIDANDO FORMULARIO DE REGISTRO
    if(isset($_POST['submit'])) {
        $nombre_representante = $_POST["nombre_representante"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];
        $cargo = $_POST["cargo"];
        $rif_empresa = $_POST["rif_empresa"];
        $nombre_empresa = $_POST["nombre_empresa"];
        $id_rubro = $_POST["rubro"];
    }

    if (!isset($usuario)) {
        $representante = $objRepresentante->getRepresentantePorEmail($email);
        if (isset($representante)) {
            // Representante ya registrado, redirigir a página principal
            $_SESSION['error'] = 'usuario_existe';
            $_SESSION['email'] = $email;
            header('Location: ../views/index.php');
            return;

        }
    } else {
        // Usuario ya registrado, redirigir a página principal
        $_SESSION['error'] = 'usuario_existe';
        $_SESSION['email'] = $email;
        header('Location: ../views/index.php');
        return;
    }
    
    $empresa = $objEmpresa->getEmpresaPorRIF($rif_empresa);
    $idEmpresa = null;

    if (!isset($empresa)) {
        $idEmpresa = $objEmpresa->insertEmpresa($nombre_empresa, $rif_empresa, $id_rubro);
        if (!$idEmpresa) {
            $_SESSION['error'] = 'fallo_registro_empresa';
            header('Location: ../views/index.php');
            return;
        }
    } else {
        $idEmpresa = $empresa['id'];
    }

    $token = openssl_random_pseudo_bytes(5);
    $token = bin2hex($token);

    $idUsuario = $objUsuario->insertUsuario($email, $token, 2);

    if (!$idUsuario) {
        $_SESSION['error'] = 'fallo_registro_usuario';
        header('Location: ../views/index.php');
        return;
    }

    $idRepresentante = $objRepresentante->insertRepresentante($nombre_representante, $cargo, $telefono, $idUsuario, $idEmpresa);

    if ($idRepresentante !== false) {
        $objEnvioEmail->enviarEmailRegistro($email, $nombre_representante, $token);
        $_SESSION['registro'] = true;
        header('Location: ../views/login.php');
    } else {
        $_SESSION['error'] = 'fallo_registro_representante';
        // Borrar físicamente el usuario si el registro del representante falla
        $objUsuario->deleteUsuario($idUsuario);
        header('Location: ../views/index.php');
    }
} elseif ($mode == 'iniciarSesion') {
    $email = $_POST["email"];
    $token = $_POST["password"];

    $usuario = $objUsuario->getUsuarioPorEmail($email);
    
    if (!isset($usuario) || $token != $usuario["token"]) {
        // Empresa ya registrada, redirigir a página principal
        $_SESSION['error'] = 'wrong_credentials';
        header('Location: ../views/login.php');
        return;
    }

    unset($usuario['token']);

    $_SESSION['usuario'] = $usuario;

    $objUsuario->updateUltimaConexionUsuario($usuario['id']);
    
    if ($usuario['rol_id'] == 2) {
        $representante = $objRepresentante->getRepresentantePorEmail($email);
        $_SESSION['usuario']['representante'] = $representante;
        header('Location: ../views/encuesta.php');
    } else {
        $_SESSION['usuario'] = $usuario;
        header('Location: ../views/reporte-encuestas.php');
    }


} elseif ($mode == 'buscarEmpresa') {
    $rif = $_GET['rif'];

    $empresa = $objEmpresa->getEmpresaPorRIF($rif);

    $response = ['encontro' => false];

    if (isset($empresa)) {
        // Empresa ya registrada
        $response = ['encontro' => true, 'data' => $empresa];
    }
    echo json_encode($response);
}