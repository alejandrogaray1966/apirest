<?php

    //  Requiero de los Controladores
    require_once './mvc/json.view.php';

    //  Defino la Clase que maneja al HOME
    class HomeController {
    
        private $vista;

        public function __construct(){
            $this->vista = new JSONVvista();       
        }

        //  Funciones de la Clase

        function showHome() {
            $mensaje = array (  "Título" => "Bienvenido",
                                "Subtítulo" => "API REST FUL GYM TANDIL" );
            return $this->vista->response( $mensaje , 200 );
        }

        function showAbout() {
            $mensaje = array (  "Título" => "WEB II:",
                                "Subtítulo" => "Datos de Contacto" );
            return $this->vista->response( $mensaje , 200 );
        }

        function showNotDone() {
            $mensaje = array (  "Título" => "Falta:",
                                "Subtítulo" => "Página en desarrollo" );
            return $this->vista->response( $mensaje , 200 );
        }

        function showPage404() {
            $mensaje = array (  "Título" => "API REST FUL GYM TANDIL",
                                "Subtítulo" => "Ejemplos de ENDPOINTS",
                                "Todas" => "    * GET *     /api/promos",
                                "Una" => "      * GET *     /api/promos/:ID",
                                "Agregar" => "  * POST *    /api/promos", 
                                "Borrar" => "   * DELETE *  /api/promos/:ID",
                                "Modificar" => "* PUT *     /api/promos/:ID",
                                "Orden" => "    * GET *     /api/promos?ordenado=precio&manera=DESC",
                                "Filto" => "    * GET *     /api/promos?filtrado=precio&valor=1750",
                                "Paginado" => " * GET *     /api/promos?pagina=3&cantidad=5",
                                "Login" => "    * GET *     /usuarios/login"
                            );
            return $this->vista->response( $mensaje , 404 );;
        }

}

?>
