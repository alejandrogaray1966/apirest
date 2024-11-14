<?php

    //  Requiero de los Controladores
    require_once './mvc/user.model.php';
    require_once './mvc/json.view.php';
    require_once './libs/jwt.php';

    class UsuarioController{

        private $modelo;
        private $vistas;

        public function __construct(){
            $this->modelo = new UsuarioModel();
            $this->vistas = new JSONVvista();
        }

        public function obtenerToken() {
            $autenticar = $_SERVER['HTTP_AUTHORIZATION'];
            $autenticar = explode(' ', $autenticar);
            // Chequeamos cantidad de datos
            if (count($autenticar) != 2) {
                return $this->vistas->response("Error en los datos ingresados", 400);
            }
            // Chequeamos em método AUTH
            if ($autenticar[0] != 'Basic') {
                return $this->vistas->response("Error en el método de Auth type", 400);
            }
            // Obtenemos Usuario y Contraseña
            $usuario_contra = base64_decode($autenticar[1]); // "usuario:password"
            $usuario_contra = explode(':', $usuario_contra); // ["usuario", "password"]
            // Buscamos el usuario en la Base de Datos Claves
            $usuario = $this->modelo->usuarioNombre($usuario_contra[0]);
            // Chequeamos el Usuario
            if ($usuario == null) {
                return $this->vistas->response("Usuario no encontrado", 400);
            }
            // Chequeamos la contraseña
            if (!password_verify($usuario_contra[1], $usuario->contrasena)) {
                return $this->vistas->response("Error en la Contraseña", 400);
            }
            // Generamos el token
            $token = createJWT(array(
                'sub' => $usuario->id_clave,
                'email' => $usuario->usuario,
                'role' => 'admin',
                'iat' => time(),
                'exp' => time() + 3600, // seg * min * hor  = 60 * 60 * 1 = 3600 
                'Saludo' => 'WEBII',
            ));
            // Devolvemos el token
            $this->vistas->response("Session iniciada con éxito", 200);
            return $this->vistas->response($token, 200);
        }

    }

?>
