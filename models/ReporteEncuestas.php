<?php

include_once 'Config.php';

$db = Db::getInstance();

class ReporteEncuestas {

    private $tableEmpresa, $tableRepresentante, $tableEncuesta,$tablePilar, $tableResultado;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->tableEmpresa = "empresa";
        $this->tablePilar = "pilar";
        $this->tableRepresentante = "representante";
        $this->tableEncuesta = "encuesta";
        $this->tableResultado = "resultado";
    }

    public function getEncuestas() {
        global $db;
        $sql = "SELECT 
        re.nombre as representante_nombre, 
        re.id as representante_id,
        empre.nombre as empresa_nombre, 
        empre.id as empresa_id,
        promedio as resultado_promedio,
        pilar.titulo as pilar_titulo, 
        pilar.id as pilar_id,
        enc.id as encuesta_id,
        DATE_FORMAT(enc.fecha, '%Y-%m-%d %H:%i') as encuesta_fecha,
        (select ROUND (sum(result2.promedio)/count(result2.promedio),2) from $this->tableResultado as result2
                                        where enc.id = result2.id_encuesta   
        ) as promedio_general 
        FROM $this->tableRepresentante as re JOIN
        $this->tableEncuesta as enc ON enc.id_representante = re.id JOIN 
        $this->tableEmpresa as  empre ON re.id_empresa = empre.id JOIN
        $this->tableResultado as result ON result.id_encuesta = enc.id  JOIN
        $this->tablePilar as pilar ON pilar.id =  result.id_pilar 
        GROUP BY enc.id 
        ";
        return $db->ejecutar($sql)->fetch_all(MYSQLI_ASSOC);
    }


    public function formatObjecto($result){
         $encuestas = [];
        foreach ($result as $representate) {
        
           $obj =  $this->enviarId($representate["encuesta_id"], $representate);
        
          array_push($encuestas,$obj);
        }
     
        return $encuestas;

    }

    
    
    




public function enviarId($id_encuesta, $objeto){

    global $db;
    $sql = "SELECT
    pilar.id as id_pilar,
    pilar.titulo as titulo_pilar, 
    result.promedio as encuesta_promedio 
    from $this->tableResultado as result,
    $this->tablePilar as  pilar
    where  result.id_encuesta = $id_encuesta and
    pilar.id = result.id_pilar";
    $resultados = $db->ejecutar($sql)->fetch_all(MYSQLI_ASSOC);
    foreach ($resultados as $result) {
    $objeto[$result['id_pilar']] = $result['encuesta_promedio'];  
    }
      
      
    return $objeto;
}

}