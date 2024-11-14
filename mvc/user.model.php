<?php 

    //  Requiero de los Controladores
    require_once 'db/model.php';

    //  Defino la Clase que maneja la Base de Datos de las Claves
    class UsuarioModel extends Model {

        //  Funciones de la Clase
        public function usuarioNombre($nombre) {
            $query = $this->db->prepare("SELECT * FROM claves WHERE usuario = ?");  
            $query->execute([$nombre]);
            $usuario = $query->fetch(PDO::FETCH_OBJ);
            return $usuario;
        }

    }

?>