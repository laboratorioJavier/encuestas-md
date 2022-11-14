<?php

include_once 'Config.php';

$db = Db::getInstance();

class Resultado {

    private $tableUsuario, $tableResultado, $tableEncuesta, $tablePilar;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->tableUsuario = "usuario";
        $this->tableResultado = "resultado";
        $this->tableEncuesta = "encuesta";
        $this->tablePilar = "pilar";
    }

    public function insertResultado($idEncuesta, $idPilar, $promedio) {
        global $db;
        $data = array(
            'id_encuesta' => $idEncuesta,
            'id_pilar' => $idPilar,
            'promedio' => $promedio
        );
        return $db->insertarRegistro($this->tableResultado, $data);
    }

    public function getResultadosPorTokenEncuesta($token) {
        global $db;
        $sql = "SELECT
                e.id AS encuesta_id,
                r.promedio AS promedio_pilar,
                p.id AS id,
                p.titulo AS titulo
                FROM $this->tableResultado r
                JOIN $this->tableEncuesta e ON e.id = r.id_encuesta
                JOIN $this->tablePilar p ON p.id = r.id_pilar
                WHERE e.token = '$token'
                ORDER BY p.id";
        return $db->ejecutar($sql)->fetch_all(MYSQLI_ASSOC);
    }

}
