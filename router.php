<?php
    
    require_once './libs/response.php';
    require_once './libs/request.php'; 
    require_once './libs/router.php'; 
    require_once './libs/jwt.php';
    
    require_once './mvc/promo.controller.php';
    //require_once './mvc/user.controller.php';
    //require_once './mvc/jwt.autenticar.php';

    $router = new Router();
    //$router->addMiddleware(new Autenticar());

    //                 endpoint     |    verbo   |     controller     |    método
    //$router->addRoute('promos'      ,   'GET'    , 'PromoController'  , 'obtenerTodas');
    $router->addRoute('promos/:id'  ,   'GET'    , 'PromoController'  , 'obtenerUna');
    $router->addRoute('promos'      ,   'POST'   , 'PromoController'  , 'agregar');
    $router->addRoute('promos/:id'  ,   'DELETE' , 'PromoController'  , 'borrar');
    $router->addRoute('promos/:id'  ,   'PUT'    , 'PromoController'  , 'modificar');
    
    //$router->addRoute('usuarios/token', 'GET'    , 'UsuarioController'  ,  'obtenerToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

?>
