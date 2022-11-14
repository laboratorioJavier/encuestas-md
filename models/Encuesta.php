<?php

include_once 'Config.php';

$db = Db::getInstance();

class Encuesta {

    private $tableOpcion, $tableNivel, $tablePilar, $tableEmpresa, $tableRespuesta, $tableEncuesta, $tableRepresentante, $tableUsuario, $tableRubro;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->tableOpcion = "opcion";
        $this->tableNivel = "nivel";
        $this->tablePilar = "pilar";
        $this->tableEmpresa = "empresa";
        $this->tableRespuesta = "respuesta";
        $this->tableEncuesta = "encuesta";
        $this->tableRepresentante = "representante";
        $this->tableUsuario = "usuario";
        $this->tableRubro = "rubro";
    }

    public function getAll() {
        global $db;

        return $db->ejecutar("SELECT
        o.id as opcion_id,
        o.descripcion as opcion_descripcion,
        o.estatus as opcion_estatus,
        n.id as nivel_id,
        n.titulo as nivel_titulo,
        n.descripcion as nivel_descripcion,
        n.estatus as nivel_estatus,
        p.id as pilar_id,
        p.titulo as pilar_titulo,
        p.descripcion as pilar_descripcion,
        p.estatus as pilar_estatus
        FROM opcion o
        JOIN nivel n ON o.id_nivel = n.id
        JOIN pilar p ON o.id_pilar = p.id
        WHERE o.estatus = 1
        AND n.estatus = 1
        AND p.estatus = 1
        ORDER BY p.id, n.id, o.id
        ")->fetch_all(MYSQLI_ASSOC);
    }

    public function formatQueryResultToObject($result) {
        $idTemporalp = -1;
        $idTemporaln = -1;
        $lengthP = 0;
        $lengthN = 0;
        $datos = [];

        foreach ($result as $encuesta) {
            $objeto = [
                "pilar" => [
                    "id" => $encuesta["pilar_id"],
                    "titulo" => $encuesta["pilar_titulo"],
                    "descripcion" => $encuesta["pilar_descripcion"],
                    "estatus" => $encuesta["pilar_estatus"],
                    "niveles" => []
                ],
                "nivel" => [
                    "id" => $encuesta["nivel_id"],
                    "titulo" => $encuesta["nivel_titulo"],
                    "descripcion" => $encuesta["nivel_descripcion"],
                    "estatus" => $encuesta["nivel_estatus"],
                    "opciones" => []
                ],
                "opcion" => [
                    "id" => $encuesta["opcion_id"],
                    "descripcion" => $encuesta["opcion_descripcion"],
                    "id_nivel" => $encuesta["nivel_id"],
                    "id_pilar" => $encuesta["pilar_id"],
                    "estatus" => $encuesta["opcion_estatus"]
                ]
            ];
            if ($idTemporalp != $encuesta["pilar_id"]) {
                array_push($objeto["nivel"]["opciones"], $objeto["opcion"]);
                array_push($objeto["pilar"]["niveles"], $objeto["nivel"]);
                array_push($datos, $objeto["pilar"]);
                $lengthP++;
                $lengthN = 1;
            } elseif ($idTemporaln != $encuesta["nivel_id"]) {
                array_push($objeto["nivel"]["opciones"], $objeto["opcion"]);
                array_push($datos[$lengthP - 1]["niveles"], $objeto["nivel"]);
                $lengthN++;
            } else {
                array_push($datos[$lengthP - 1]["niveles"][$lengthN - 1]["opciones"], $objeto["opcion"]);
            }
            $idTemporalp = $encuesta["pilar_id"];
            $idTemporaln = $encuesta["nivel_id"];
        }

        return $datos;
    }

    public function insertEncuesta($idRepresentante, $token) {
        global $db;
        $data = array(
            'id_representante' => $idRepresentante,
            'token' => $token
        );
        return $db->insertarRegistro($this->tableEncuesta, $data);
    }

    public function insertRespuestas($idEncuesta, $arrayOpciones) {
        global $db;
        $data = [];
        foreach ($arrayOpciones as $opcion) {
            array_push($data, array('id_encuesta' => $idEncuesta, 'id_opcion' => $opcion));
        }
        return $db->insertarMultiple($this->tableRespuesta, $data);
    }

    public function getEstructuraRespuestasPorEncuesta($idEncuesta) {
        global $db;
        $sql = "SELECT
        p.id AS pilar_id,
        p.titulo AS pilar_titulo,
        (
            SELECT MAX(cantidad_opciones)
            FROM (
                SELECT
                p.id AS pilar_id,
                n.id AS nivel_id,
                (
                    SELECT COUNT(*) FROM $this->tableOpcion o1
                    WHERE o1.id_nivel = n.id
                    AND o1.id_pilar = p.id
                ) AS cantidad_opciones
                FROM $this->tablePilar p
                JOIN $this->tableOpcion o ON p.id = o.id_pilar
                JOIN $this->tableNivel n ON n.id = o.id_nivel
                JOIN $this->tableRespuesta r ON r.id_opcion = o.id
                WHERE r.id_encuesta = $idEncuesta
                GROUP BY p.id, n.id
            ) AS subconsulta
            GROUP BY pilar_id
            HAVING pilar_id = p.id
        ) AS max_opciones,
        n.id AS nivel_id,
        n.titulo AS nivel_titulo,
        COUNT(o.id) AS opciones_respondidas,
        (
            SELECT COUNT(*) FROM $this->tableOpcion o1
            WHERE o1.id_nivel = n.id
            AND o1.id_pilar = p.id
        ) AS cantidad_opciones
        FROM $this->tablePilar p
        JOIN $this->tableOpcion o ON p.id = o.id_pilar
        JOIN $this->tableNivel n ON n.id = o.id_nivel
        JOIN $this->tableRespuesta r ON r.id_opcion = o.id
        WHERE r.id_encuesta = $idEncuesta
        GROUP BY p.id, n.id
        ORDER BY p.id, n.id";
        return $db->ejecutar($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getEstructuraRespuestasPorTokenEncuesta($token) {
        global $db;
        $sql = "SELECT
        p.id AS pilar_id,
        p.titulo AS pilar_titulo,
        (
            SELECT MAX(cantidad_opciones)
            FROM (
                SELECT
                p.id AS pilar_id,
                n.id AS nivel_id,
                (
                    SELECT COUNT(*) FROM $this->tableOpcion o1
                    WHERE o1.id_nivel = n.id
                    AND o1.id_pilar = p.id
                ) AS cantidad_opciones
                FROM $this->tablePilar p
                JOIN $this->tableOpcion o ON p.id = o.id_pilar
                JOIN $this->tableNivel n ON n.id = o.id_nivel
                JOIN $this->tableRespuesta r ON r.id_opcion = o.id
                JOIN $this->tableEncuesta e ON r.id_encuesta = e.id
                WHERE e.token = '$token'
                GROUP BY p.id, n.id
            ) AS subconsulta
            GROUP BY pilar_id
            HAVING pilar_id = p.id
        ) AS max_opciones,
        n.id AS nivel_id,
        n.titulo AS nivel_titulo,
        COUNT(o.id) AS opciones_respondidas,
        (
            SELECT COUNT(*) FROM $this->tableOpcion o1
            WHERE o1.id_nivel = n.id
            AND o1.id_pilar = p.id
        ) AS cantidad_opciones,
        e.id AS encuesta_id,
        rep.nombre AS representante_nombre,
        rep.telefono AS representante_telefono,
        rep.cargo AS representante_cargo,
        emp.nombre AS empresa_nombre,
        emp.rif AS empresa_rif,
        rub.descripcion AS rubro_descripcion,
        u.email AS usuario_email,
        u.ultima_conexion AS usuario_ultima_conexion
        FROM $this->tablePilar p
        JOIN $this->tableOpcion o ON p.id = o.id_pilar
        JOIN $this->tableNivel n ON n.id = o.id_nivel
        JOIN $this->tableRespuesta r ON r.id_opcion = o.id
        JOIN $this->tableEncuesta e ON r.id_encuesta = e.id
        JOIN $this->tableRepresentante rep ON e.id_representante = rep.id
        JOIN $this->tableEmpresa emp ON rep.id_empresa = emp.id
        JOIN $this->tableRubro rub ON emp.id_rubro = rub.id
        JOIN $this->tableUsuario u ON rep.id_usuario = u.id
        WHERE e.token = '$token'
        GROUP BY p.id, n.id
        ORDER BY p.id, n.id";
        return $db->ejecutar($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function formatQueryResultEstructuraToObject($result) {
        $idTemporalp = -1;
        $lengthP = 0;
        $datos = [];

        $datos['resultados'] = [];

        $datos['encuesta'] = [
            "id" => $result[0]["encuesta_id"],
            "representante" => [
                "nombre" => $result[0]["representante_nombre"],
                "telefono" => $result[0]["representante_telefono"],
                "cargo" => $result[0]["representante_cargo"],
                "empresa" => [
                    "nombre" => $result[0]["empresa_nombre"],
                    "rif" => $result[0]["empresa_rif"],
                    "rubro" => [
                        "descripcion" => $result[0]['rubro_descripcion']
                    ]
                ],
                "usuario" => [
                    "email" => $result[0]["usuario_email"],
                    "ultima_conexion" => $result[0]["usuario_ultima_conexion"]
                ]
            ]
        ];

        foreach ($result as $encuesta) {
            $objeto = [
                "pilar" => [
                    "id" => $encuesta["pilar_id"],
                    "titulo" => $encuesta["pilar_titulo"],
                    "max_opciones" => $encuesta["max_opciones"],
                    "niveles" => []
                ],
                "nivel" => [
                    "id" => $encuesta["nivel_id"],
                    "titulo" => $encuesta["nivel_titulo"],
                    "opciones_respondidas" => $encuesta["opciones_respondidas"],
                    "cantidad_opciones" => $encuesta["cantidad_opciones"]
                ]
            ];
            if ($idTemporalp != $encuesta["pilar_id"]) {
                array_push($objeto["pilar"]["niveles"], $objeto["nivel"]);
                array_push($datos['resultados'], $objeto["pilar"]);
                $lengthP++;
            } else {
                array_push($datos['resultados'][$lengthP - 1]["niveles"], $objeto["nivel"]);
            }
            $idTemporalp = $encuesta["pilar_id"];
        }

        return $datos;
    }

    public function calcularPromedios($resultados) {
        $items = $resultados;

        //calculo del promedio general
        $j = 0;
        foreach ($items as $pilar) { //FOR PARA PILARES

            $niv = $pilar['niveles'];
            $promedio_pilar = 0;
            $puntaje_por_nivel = 0;
            $cantidad_opciones_total = 0;
            foreach ($niv as $nivel) {

                $opciones_r = 0;
                $opciones_r = $nivel['opciones_respondidas'];
                if ($opciones_r > 0) {
                    $cantidad_opciones_total++;
                }

                $puntaje_por_nivel += $this->validarOpciones($opciones_r, $nivel['id']);
            }
            $promedio_pilar = ($puntaje_por_nivel / $cantidad_opciones_total);
            $items[$j]['promedio_pilar'] = floatval(round($promedio_pilar, 1));
            $j++;
        }
        return $items;
    }

    private function validarOpciones($opciones, $nivel) {
        switch ($nivel) {
        case '1':
            if ($opciones == 1) {
                return 0.8;
            } else if ($opciones > 1) {
                return 0.6;
            }
            return 0;
        case '2':
            if ($opciones == 1) {
                return 1.1;
            } else if ($opciones > 1) {
                return 1.3;
            }
            return 0;
        case '3':
            if ($opciones == 1) {
                return 1.5;
            } else if ($opciones > 1) {
                return 1.7;
            }
            return 0;
        case '4':
            if ($opciones == 1) {
                return 2.5;
            } else if ($opciones > 1) {
                return 3.2;
            }
            return 0;
        case '5':
            if ($opciones == 1) {
                return 3.8;
            } else if ($opciones > 1) {
                return 5;
            }
            return 0;
        }
    }

}
