<?php
    
    require_once './libs/response.php';
    require_once './libs/request.php'; 
    require_once './libs/router.php'; 
    require_once './libs/jwt.php';
    require_once './libs/jwt.autenticar.php';

    require_once './mvc/promo.controller.php';
    require_once './mvc/home.controller.php';
    require_once './mvc/user.controller.php';

    $router = new Router();
    $router->addMiddleware(new Autenticar());
    $router->setDefaultRoute( 'HomeController' , 'showPage404' );

    //                 endpoint     |    verbo   |     controller     |    método
    $router->addRoute('promos'      ,   'GET'    , 'PromoController'  , 'obtenerTodas');
    $router->addRoute('promos/:id'  ,   'GET'    , 'PromoController'  , 'obtenerUna');
    $router->addRoute('promos'      ,   'POST'   , 'PromoController'  , 'agregar');
    $router->addRoute('promos/:id'  ,   'DELETE' , 'PromoController'  , 'borrar');
    $router->addRoute('promos/:id'  ,   'PUT'    , 'PromoController'  , 'modificar');
    $router->addRoute('home'        ,   'GET'    , 'HomeController'   , 'showHome');
    $router->addRoute('usuarios/login', 'GET'    , 'UsuarioController', 'obtenerToken');
    
    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

?>
