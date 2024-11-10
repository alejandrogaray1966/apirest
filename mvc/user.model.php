<?php 
class UsuarioModelo {
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=coletivo;charset=utf8', 'root', '');        
    }
    public function usuarioNombre ($nombre){
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE usuario = ?");  
        $query->execute([$nombre]);
        $usuario = $query->fetch(PDO::FETCH_OBJ);
        return $usuario;
    }
    public function nombreDeUsiario ($nombre){
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $query->execute([$nombre]);
        $usuario = $query->fetch(PDO::FETCH_OBJ);
        return $usuario;
    }

}