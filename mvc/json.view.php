<?php

    class JSONVvista {

        public function response($data, $status = 200) {
            header("Content-Type: application/json");
            $statusText = $this->_requestStatus($status);
            header("HTTP/1.1 $status $statusText");
            echo json_encode($data);
            //echo json_encode($body,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        private function _requestStatus($code) {
            $status = array(
                200 => "Ok - Correcto...",
                201 => "Created - Se ha creado un nuevo Dato...",
                202 => "Acepted",
                204 => "No Content - La petición se ha completado con éxito...",
                301 => "Moved Permanently",
                302 => "Found",
                400 => "Bad Request - El Servidor no pudo interpretar la solicitud...",
                401 => "Unauthorized - No autorizado...",
                403 => "Forbidden",
                404 => "Not Found - Dato no encontrado...",
                410 => "Gone",
                500 => "Internal Server Error - Error interno del Servidor...",
                503 => "Service Unavailable - El Servidor está caído por mantenimiento..."
            );
            if(!isset($status[$code])) {
                $code = 500;
            }
            return $status[$code];
            //return (isset($status[$code])) ? $status[$code] : $status[500];
        }

    }

?>
