<?php

    require_once './mvc/promo.model.php';
    require_once './mvc/json.view.php';

    class PromoController{
       
        private $modelo;
        private $vista;

        public function __construct(){
            $this->modelo = new PromoModel(); 
            $this->vista = new JSONVvista();       
        }

        // api/promos
        public function obtenerTodas ($req, $res){
            
            $orderBy = null;
            $orderDirection = null;
            $filtrado = null;
            $valor = null;
            $pagina = null; // si no tine nada traigo todos, verifico si es numero
            $limite = null; // si vine pagina le doy un valor por defecto, verifico si es nuemro 
            
            if(isset($req->query->filtro)){
                $filtrado = $req->query->filtro;
            }
            if(isset($req->query->valor)){
                $valor = $req->query->valor;
            }
            
            if(isset($req->query->orderBy)){
                $orderBy = $req->query->orderBy;
            }
            if(isset($req->query->orderDirection)){
                $orderDirection =$req->query->orderDirection;
            }
            if(isset($req->query->pagina) && is_numeric($req->query->pagina) ){
                $pagina= $req->query->pagina;            
            }
            if(isset($req->query->limite) && is_numeric($req->query->limite)){
                $limite = $req->query->limite;
            }
            if($limite == null && $pagina !== null){
                $limite = 5;
            } else {
                $limite = (int) $limite;
            }
            
            $boleto = $this->modelo->obtenerTodasPromociones($orderBy, $orderDirection, $filtrado, $valor, $limite, $pagina);
            if($boleto == null){
                return $this->vista->response('no hay boletos con esas especificaciones', 404);
            }

            return $this->vista->response($boleto);
        }

        //      GET     /api/promos/:ID
        public function obtenerUna($req, $res) {
            $id = $req->params->id;
            $promo = $this->modelo->obtenerUnaPromocion($id);
            if ( !$promo ) {
                return $this->vista->response("La Promoción con el id $id no existe", 404);
            }
            return $this->vista->response($promo);
        }

        //      POST    /api/promos
        public function agregar($req,$res){
            // verificar si se hizo LOGIN
            //if(!$res->user) {
                //return $this->vista->response("No autorizado", 401);
            //}
            // verificar la fecha
            if ( !isset($req->body->fecha)) {
                return $this->vista->response('No se encuentra la Fecha', 400);
            }
            $fecha_obje = DateTime :: createFromFormat('Y-m-d', $req->body->fecha);
            if ( $fecha_obje && $fecha_obje->format('Y-m-d') === $req->body->fecha ) {
                $fecha = $req->body->fecha;
                if ( empty($fecha) ) {
                    return $this->vista->response('Debe completar la Fecha', 400);
                }
            } else {
                return $this->vista->response('La Fecha debe tener el formato Y-m-d', 400);
            }
            // verificar el horario
            if ( !isset($req->body->horario)) {
                return $this->vista->response('No se encuentra el Horario', 400);
            }
            $horario = $req->body->horario;
            if ( empty($horario) ) {
                return $this->vista->response('Debe completar el Horario', 400);
            }
            // verificar la especialidad
            if ( !isset($req->body->especialidad)) {
                return $this->vista->response('No se encuentra la Especialidad', 400);
            }
            $especialidad = $req->body->especialidad;
            if ( empty($especialidad) ) {
                return $this->vista->response('Debe completar la Especialidad', 400);
            }
            // verificar el precio
            if ( !isset($req->body->precio)) {
                return $this->vista->response('No se encuentra el Precio', 400);
            }
            if ( is_numeric($req->body->precio) ) {
                $precio = $req->body->precio;
            }else{
                return $this->vista->response('Debe completar el precio', 400);
            }
            // agrego los datos
            $id =$this->modelo->agregarPromocion($fecha,$horario,$especialidad,$precio);       
            if ( $id ) {    
                return $this->vista->response("La Promoción se ha creado con exito, con el id $id",201);
            } else {
                return $this->vista->response('Ha ocurrido un ERROR al crear los datos', 500);
            }  
        }

        //    DELETE    /api/promos/:ID
        public function borrar ($req, $res){
            // verificar si se hizo LOGIN
            //if(!$res->user) {
            //    return $this->vista->response("No autorizado", 401);
            //}
            $id = $req->params->id;
            $promo = $this->modelo->obtenerUnaPromocion($id);
            if ( !$promo ) {
                return $this->vista->response("La Promoción con el id $id no existe", 404);
            }
            $this->modelo->borrarPromocion($id);
            return $this->vista->response("Se ha borrado con éxito la Promoción con id $id", 200);
        }

    // api/boleto/:id
    public function editarBoleto ($req, $res){
        
        if(!$res->user) {
            return $this->vista->response("No autorizado", 401);
        }

        $id = $req->params->id;
        // verifico que exista
        $boleto = $this->modelo->obtenerUnaPromocion($id);
        if (!$boleto) {
            return $this->vista->response("El boleto con el id=$id no existe", 404);
        }
            // valido los datos
        if (!isset($req->body->destino_inicio) || empty($req->body->destino_inicio) ||
            !isset($req->body->destino_fin) || empty($req->body->destino_fin) ||
            !isset($req->body->fecha_salida) || empty($req->body->fecha_salida) ||
            !isset($req->body->precio) || empty($req->body->precio)){
            return $this->vista->response('Faltan completar datos', 400);
        }
        
        $feccha_obje = DateTime :: createFromFormat('Y-m-d', $req->body->fecha_salida);

        if($feccha_obje && $feccha_obje->format('Y-m-d') === $req->body->fecha_salida ){
            $fecha_salida = $req->body->fecha_salida;
        }else{
            return $this->vista->response('La fecha no es correcta', 400);
        }
        if(is_numeric($req->body->precio)){
            $precio = $req->body->precio;
        }else{
            return $this->vista->response('No es un precio correcto', 400);
        }

        $destino_inicio = $req->body->destino_inicio;       
        $destino_fin = $req->body->destino_fin;   

        $this->modelo->editarBoleto($id, $destino_inicio, $destino_fin, $fecha_salida , $precio);

        $boleto = $this->modelo->obtenerUnaPromocion($id);
        $this->vista->response($boleto, 200);
        
    }

}