<?php

include_once 'Config.php';

$db = Db::getInstance();

class Empresa {

    private $tableEmpresa, $tableRubro, $tableRepresentante, $tableUsuario;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->tableEmpresa = "empresa";
        $this->tableRubro = "rubro";
        $this->tableRepresentante = "representante";
        $this->tableUsuario = "usuario";
    }

    public function getEmpresaPorRIF($rif) {
        global $db;
        $sql = "SELECT e.*, r.id as rubro_descripcion, r.descripcion as rubro_descripcion
                FROM empresa e
                JOIN rubro r ON e.id_rubro = r.id
                WHERE e.rif = '$rif'";
        return $db->ejecutar($sql)->fetch_assoc();
    }

    public function getEmpresaPorEmail($email) {
        global $db;
        $sql = "SELECT e.*, r.descripcion as rubro_descripcion
                FROM empresa e
                JOIN rubro r ON e.id_rubro = r.id
                JOIN representante rep ON rep.id_empresa = e.id
                JOIN usuario u ON u.id = rep.id_usuario
                WHERE u.email = '$email'";
        return $db->ejecutar($sql)->fetch_assoc();
    }

    public function insertEmpresa($nombre, $rif, $id_rubro) {
        global $db;
        $data = array(
            'nombre' => $nombre,
            'rif' => $rif,
            'id_rubro' => $id_rubro,
        );
        return $db->insertarRegistro($this->tableEmpresa, $data);
    }

    public function getRubros() {
        global $db;
        $sql = "SELECT * FROM $this->tableRubro WHERE estatus = 1 ORDER BY id";
        return $db->ejecutar($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getEmpresas() {
        global $db;

        $sql = "SELECT e.nombre as nombre_empresa, e.rif, r.descripcion, u.email, rep.nombre, rep.telefono, rep.cargo
        FROM empresa e
        JOIN $this->tableRubro as r ON e.id_rubro = r.id
        JOIN $this->tableRepresentante as rep ON rep.id_empresa = e.id
        JOIN $this->tableUsuario as u ON u.id = rep.id_usuario
        WHERE e.estatus = 1
        and  rep.estatus = 1
        and  u.estatus = 1
        and  r.estatus = 1 ";
        return $db->ejecutar($sql)->fetch_all(MYSQLI_ASSOC);
    }

}
