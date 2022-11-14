<?php

include_once 'Config.php';

$db = Db::getInstance();

class Representante {

    private $tableEmpresa, $tableRepresentante;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->tableRepresentante = "representante";
        $this->tableEmpresa = "empresa";
    }

    public function getRepresentantePorEmail($email) {
        global $db;
        $sql = "SELECT
                rep.*,
                e.id AS empresa_id,
                e.nombre AS empresa_nombre,
                e.rif AS empresa_rif,
                r.id AS rubro_id,
                r.descripcion as rubro_descripcion
                FROM representante rep
                JOIN usuario u ON u.id = rep.id_usuario
                JOIN empresa e ON rep.id_empresa = e.id
                JOIN rubro r ON e.id_rubro = r.id
                WHERE u.email = '$email'";
        return $db->ejecutar($sql)->fetch_assoc();
    }

    public function insertRepresentante($nombre, $cargo, $telefono, $idUsuario, $idEmpresa) {
        global $db;
        $data = array(
            'nombre' => $nombre,
            'cargo' => $cargo,
            'telefono' => $telefono,
            'id_usuario' => $idUsuario,
            'id_empresa' => $idEmpresa,
        );
        return $db->insertarRegistro($this->tableRepresentante, $data);
    }

}
