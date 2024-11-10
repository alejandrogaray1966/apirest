<?php
class Autenticar{
    public function run($req, $res){

        $autenticar = $_SERVER['HTTP_AUTHORIZATION'];
        $autenticar = explode(' ', $autenticar);
        
        if (count($autenticar) != 2){
            return;
        }
        if ($autenticar[0] != 'Bearer'){
            return;
        }
        $res->user = validateJWT($autenticar[1]);
    }
}
