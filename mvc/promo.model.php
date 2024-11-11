<?php

//  Requiero de los Controladores
require_once 'db/model.php';

//  Defino la Clase que maneja la Base de Datos de las Promociones
class PromoModel extends Model{
 
    //  Funciones de la Clase

    public function obtenerTodasPromociones( $filtrado = null , $valor = null , $ordenado = null , $manera = null , $pagina = null , $cantidad = null ) {
        //  Preparo la consulta
        $sql = 'SELECT * FROM promociones';
        //  Preparo el filtro
        if ( $filtrado == 'fecha' || $filtrado == 'horario' || $filtrado == 'especialidad' || $filtrado == 'precio' ) {
            $sql .= ' WHERE ' . $filtrado . ' = ? ';
        }
        //  Preparo el orden
        if ( $ordenado ) {
            $sql .= ' ORDER BY ';     
            switch ( $ordenado ) {
                case 'fecha':
                    $sql .= ' fecha ';
                    break;
                case 'horario':
                    $sql .= ' horario ';
                    break;
                case 'especialidad':
                    $sql .= ' especialidad ';
                    break;
                case 'precio':
                    $sql .= ' precio ';
                    break;
                default:
                    $sql .= ' id_promocion ';
                    break;
            }
            // Direción del orden
            if ( $manera === 'DESC' ) {
                $sql .= ' DESC ';  
            } else {
                $sql .= ' ASC ';  
            }            
        }
        //  Preparo la paginación
        if ( $pagina !== null ) {
            if ( $pagina > 1 ) {
                $aPartirDel = ( $pagina - 1 ) * $cantidad;
                $aPartirDel = (int) $aPartirDel;
            } else {
                $aPartirDel = 0;
            }
            $sql .= ' LIMIT ' . $cantidad;
            $sql .= ' OFFSET ' . $aPartirDel;
        }
        //  Preparo la consulta
        $query = $this->db->prepare($sql);
        //  Ejecuto la consulta
        if ( $filtrado == 'fecha' || $filtrado == 'horario' || $filtrado == 'especialidad' || $filtrado == 'precio' ) {
            $query->execute([$valor]);
        } else {        
            $query->execute([]);
        }
        //  Obtengo los datos
        $promociones = $query->fetchAll(PDO::FETCH_OBJ);
        //  Devuelvo los datos
        return $promociones;
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
