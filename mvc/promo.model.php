<?php

//  Requiero de los Controladores
require_once 'db/model.php';

//  Defino la Clase que maneja la Base de Datos de las Promociones
class PromoModel extends Model{
 
    //  Funciones de la Clase
    public function obtenerTodasPromociones($orderBy = false , $orderDirection = ' ASC ', $filtrado = null, $valor = null, $limite = null, $pagina = null){
        
        //  Preparo la consulta
        $sql = 'SELECT * FROM promociones';
        // filtro
        if($filtrado == 'precio' || $filtrado == 'destino_inicio' || $filtrado == 'destino_fin' || $filtrado == 'fecha_salida'){
            $sql .= ' WHERE ' . $filtrado . ' = ? ';
        }

        
        //ordenamineto 
        if ($orderBy) {
            $sql .= ' ORDER BY ';     
            switch ($orderBy) {
                case 'precio':
                    $sql .= ' precio ';
                    break;
                case 'fecha':
                    $sql .= ' fecha_salida ';
                    break;
                case 'destino-inicio':
                    $sql .= ' destino_inicio ';
                    break;
                case 'destino-fin':
                    $sql .= ' destino_fin ';
                    break;
                default:
                    // $sql .= ' id_boleto ';
                    return ('el campo no existe');
                    break;
            }
            // direcion del orden
            if ($orderDirection === 'DESC') {
                $sql .= ' DESC';  
            } else {
                $sql .= ' ASC';  
            }            
        }

        if($pagina !== null){
            $paginacion = ($pagina - 1) * $limite;

            $paginacion = (int) $paginacion;
            $sql .= ' LIMIT ' . $limite;
            $sql .= ' OFFSET ' . $paginacion;
        }
        
        // Preparar la consulta
        $query = $this->db->prepare($sql);
    
        if ($valor !== null ||  $filtrado !== null) {
            $query->execute([$valor]);
        }else{        
            $query->execute([]);
        }

        $boleto = $query->fetchAll(PDO::FETCH_OBJ);
        return $boleto;
    }

    public function obtenerUnaPromocion($id){
        $query = $this->db->prepare('SELECT * FROM promociones WHERE id_promocion = ?');
        $query->execute([$id]);   
        $promo = $query->fetch(PDO::FETCH_OBJ);
        return $promo;
    }
    
    public function agregarPromocion($fecha,$horario,$especialidad,$precio) { 
        $query = $this->db->prepare('INSERT INTO promociones (fecha,horario,especialidad,precio) VALUES (?, ?, ?, ?)');
        $query->execute([$fecha,$horario,$especialidad,$precio]);    
        $id = $this->db->lastInsertId();  
        return $id;
    }

    public function borrarPromocion($id) {
        $query = $this->db->prepare('DELETE FROM promociones WHERE id_promocion = ?');
        $query->execute([$id]);
        return;
    }

    public function modificarPromocion($id,$fecha,$horario,$especialidad,$precio){
        $query = $this->db->prepare('UPDATE promociones SET fecha = ?, horario = ?, especialidad = ?, precio = ? WHERE id_promocion = ?');
        $query->execute([$fecha,$horario,$especialidad,$precio,$id]);
        return;
    }

}

?>
