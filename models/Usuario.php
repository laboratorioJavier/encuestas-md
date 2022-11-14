<?php

include_once 'Config.php';

$db = Db::getInstance();

class Usuario {

    private $tableUsuario, $tableRol;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->tableUsuario = "usuario";
        $this->tableRol = "rol";
    }

    public function getUsuarioPorEmail($email) {
        global $db;
        $sql = "SELECT
                u.*,
                rol.id AS rol_id,
                rol.nombre AS rol_nombre
                FROM $this->tableUsuario u
                JOIN $this->tableRol rol ON rol.id = u.id_rol
                WHERE u.email = '$email'";
        return $db->ejecutar($sql)->fetch_assoc();
    }

    public function insertUsuario($email, $token, $idRol) {
        global $db;
        $data = array(
            'email' => $email,
            'token' => $token,
            'id_rol' => $idRol,
            'estatus' => 1
        );
        return $db->insertarRegistro($this->tableUsuario, $data);
    }

    public function updateUltimaConexionUsuario($idUsuario) {
        global $db;
        $data = array(
            'ultima_conexion' => Db::$CURRENT_TIMESTAMP
        );
        return $db->actualizarRegistro($this->tableUsuario, $idUsuario, $data);
    }

    public function deleteUsuario($idUsuario) {
        global $db;
        $where = array('id_usuario' => $idUsuario);
        return $db->delete($this->tableUsuario, $where);
    }

}
