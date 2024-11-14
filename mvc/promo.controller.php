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

        //      GET     /api/promos
        public function obtenerTodas($req, $res) {
            // defino las variables de los parámetros
            $filtrado = null;
            $valor = null;
            $ordenado = null;
            $manera = null;
            $pagina = null;
            $cantidad = null;
            // verifico el filtro
            if ( isset($req->query->filtrado) && isset($req->query->valor) ) {
                $filtrado = $req->query->filtrado;
                $valor = $req->query->valor;
            }
            // verifico el orden
            if ( isset($req->query->ordenado) && isset($req->query->manera) ) {
                $ordenado = $req->query->ordenado;
                $manera = $req->query->manera;
            }
            // verifico la paginación
            if ( isset($req->query->pagina) && is_numeric($req->query->pagina) && isset($req->query->cantidad) && is_numeric($req->query->cantidad)) {
                $pagina= (int) $req->query->pagina;
                $cantidad = (int) $req->query->cantidad;           
            }
            // obtengo los datos
            $promociones = $this->modelo->obtenerTodasPromociones($filtrado,$valor,$ordenado,$manera,$pagina,$cantidad);
            if($promociones == null){
                return $this->vista->response('No hay Promociones que cumplan los parámetros', 404);
            }
            return $this->vista->response($promociones);
        }

        //      GET     /api/promos/:ID
        public function obtenerUna($req,$res) {
            // verificar el ID
            $id = $req->params->id;
            $promo = $this->modelo->obtenerUnaPromocion($id);
            if ( !$promo ) {
                return $this->vista->response("La Promoción con el id $id no existe", 404);
            }
            return $this->vista->response($promo);
        }

        //      POST    /api/promos
        public function agregar($req,$res) {
            // verificar si se hizo LOGIN
            if(!$res->user) {
                return $this->vista->response("Debe hacer LOGIN y usar el TOKEN para poder agregar datos", 401);
            }
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
                $precio = (int) $req->body->precio;
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
        public function borrar($req,$res) {
            // verificar si se hizo LOGIN
            if(!$res->user) {
                return $this->vista->response("Debe hacer LOGIN y usar el TOKEN para poder borrar datos", 401);
            }
            // verificar el ID
            $id = $req->params->id;
            $promo = $this->modelo->obtenerUnaPromocion($id);
            if ( !$promo ) {
                return $this->vista->response("La Promoción con el id $id no existe", 404);
            }
            $this->modelo->borrarPromocion($id);
            return $this->vista->response("Se ha borrado con éxito la Promoción con id $id", 200);
        }

        //      PUT     /api/promos/:ID
        public function modificar($req,$res) {
            // verificar si se hizo LOGIN
            if(!$res->user) {
                return $this->vista->response("Debe hacer LOGIN y usar el TOKEN para poder modificar datos", 401);
            }
            // verificar el ID
            $id = $req->params->id;
            $promo = $this->modelo->obtenerUnaPromocion($id);
            if ( !$promo ) {
                return $this->vista->response("La Promoción con el id $id no existe", 404);
            }
            // verificar los datos
            if ( !isset($req->body->fecha) && !isset($req->body->horario) && !isset($req->body->especialidad) && !isset($req->body->precio) ) {
                return $this->vista->response('Falta completar los Datos', 400);
            }
            // verificar la fecha
            if ( !isset($req->body->fecha)) {
                $fecha = $promo->fecha;
            } else {
                $fecha_obje = DateTime :: createFromFormat('Y-m-d', $req->body->fecha);
                if ( $fecha_obje && $fecha_obje->format('Y-m-d') === $req->body->fecha ) {
                    $fecha = $req->body->fecha;
                    if ( empty($fecha) ) {
                        return $this->vista->response('Debe completar la Fecha', 400);
                    }
                } else {
                    return $this->vista->response('La Fecha debe tener el formato Y-m-d', 400);
                }
            }
            // verificar el horario
            if ( !isset($req->body->horario)) {
                $horario = $promo->horario;
            } else {
                $horario = $req->body->horario;
                if ( empty($horario) ) {
                    return $this->vista->response('Debe completar el Horario', 400);
                }
            }
            // verificar la especialidad
            if ( !isset($req->body->especialidad)) {
                $especialidad = $promo->especialidad;
            } else {
                $especialidad = $req->body->especialidad;
                if ( empty($especialidad) ) {
                    return $this->vista->response('Debe completar la Especialidad', 400);
                }
            }
            // verificar el precio
            if ( !isset($req->body->precio)) {
                $precio = $promo->precio;
            } else {
                if ( is_numeric($req->body->precio) ) {
                    $precio = (int) $req->body->precio;
                }else{
                    return $this->vista->response('Debe completar el precio', 400);
                }
            }
            // modifico los datos
            $this->modelo->modificarPromocion($id,$fecha,$horario,$especialidad,$precio);
            return $this->vista->response("La Promoción se ha modificado con exito, con el id $id",201);
        }

    }

?>
