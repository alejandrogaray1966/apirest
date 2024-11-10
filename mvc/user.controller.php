<?php
require_once './app/models/Usuario.Modelo.php';
require_once './app/views/json.view.php';
require_once './libs/jwt.php';

class UsuarioController{
    private $modelo;
    private $vistas;

    public function __construct(){
        $this->modelo = new UsuarioModelo();
        $this->vistas = new JSONVvista();
    }


    public function obtenerToken() {
        $autenticar = $_SERVER['HTTP_AUTHORIZATION'];
        $autenticar = explode(' ', $autenticar);

        if (count($autenticar) != 2) {
            return $this->vistas->response("Error en los datos ingresados", 400);
        }
        if ($autenticar[0] != 'Basic') {
            return $this->vistas->response("Error en los datos ingresados", 400);
        }

        $usuario_contra = base64_decode($autenticar[1]); // "usuario:password"
        $usuario_contra = explode(':', $usuario_contra); // ["usuario", "password"]

        // Buscamos el usuario en la base
        $usuario = $this->modelo->usuarioNombre($usuario_contra[0]); // Corrige el nombre del método

        // Chequeamos la contraseña
        if ($usuario == null) {
            return $this->vistas->response("Usuario no encontrado", 400);
        }
    
        // Chequeamos la contraseña
        if (!password_verify($usuario_contra[1], $usuario->contrasenea)) {
            return $this->vistas->response("Error en los datos ingresados", 400);
        }

        // Generamos el token
        $token = createJWT(array(
            'sub' => $usuario->id_usuario,
            'email' => $usuario->usuario,
            'role' => 'admin',
            'iat' => time(),
            'exp' => time() + 3600,
            'Saludo' => 'laweb',
        ));
        $this->vistas->response("seccion iniciada con exito", 200);
        return $this->vistas->response($token, 200);
    
    }


}
