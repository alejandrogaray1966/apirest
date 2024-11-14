<?php
require_once 'db/config.php';

    class Model {
        
        protected $db;

        function __construct() {
            $this->crearDb(MYSQL_HOST,MYSQL_DB);
            $this->db = new PDO('mysql:host='. MYSQL_HOST .';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);
            $this->deploy();
        }

        private function deploy() {
            // Chequear si hay tablas
            $query = $this->db->query('SHOW TABLES');
            // Nos devuelve todas las tablas de la db       
            $tables = $query->fetchAll();   
            // Si no hay tablas, hay que crearlas                
            if(count($tables)==0) {                         
                // Copio las tablas del archivo exportado
                $clave1 = '$2y$10$H9yCQ/hfWD4oQw.HXAEcyOk6MRz0VguxS9/rl85/9AhM/PXBALYG6';
                $sql =<<<END
                --
                -- Estructura de tabla para la tabla `alumnos`
                --

                CREATE TABLE `alumnos` (
                  `id_alumno` int(11) NOT NULL,
                  `nombreYapellido` varchar(30) NOT NULL,
                  `nacimiento` date NOT NULL,
                  `peso` double NOT NULL,
                  `altura` double NOT NULL,
                  `id_rutina` int(11) NOT NULL,
                  `foto` varchar(256) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `alumnos`
                --

                INSERT INTO `alumnos` (`id_alumno`, `nombreYapellido`, `nacimiento`, `peso`, `altura`, `id_rutina`, `foto`) VALUES
                (1, 'Julio Checa', '2002-12-20', 60.8, 1.66, 1, 'images/alumnonuevo.jpeg'),
                (2, 'Miriam Landa', '1996-05-05', 65.8, 1.68, 1, 'images/alumnonuevo.jpeg'),
                (3, 'Fernando Greco', '1990-10-22', 70.5, 1.59, 2, 'images/alumnos/67134e16ef3d6.jpeg'),
                (4, 'Valeria Motschakow', '1989-11-27', 62.3, 1.61, 2, 'images/alumnonuevo.jpeg'),
                (5, 'Guillermo Brown', '1981-05-17', 80.9, 1.75, 3, 'images/alumnonuevo.jpeg'),
                (6, 'Juan Manuel Porcel', '1978-06-25', 80.7, 1.65, 3, 'images/alumnonuevo.jpeg'),
                (7, 'Marcelo Robertson', '1975-12-30', 86.3, 1.72, 2, 'images/alumnonuevo.jpeg'),
                (8, 'Adriana Wooley', '1989-01-13', 55.9, 1.59, 3, 'images/alumnos/67134d082684e.jpeg'),
                (9, 'Diego Fissina', '2001-10-09', 80.5, 1.78, 25, 'images/alumnos/67134d74a1752.jpeg'),
                (10, 'Ismael Masias', '2002-11-13', 90.3, 1.76, 20, 'images/alumnonuevo.jpeg'),
                (11, 'Valeria Zunino', '2002-06-12', 56.9, 1.66, 3, 'images/alumnonuevo.jpeg'),
                (12, 'Silvana Toledo', '2003-08-12', 56.8, 1.65, 13, 'images/alumnonuevo.jpeg'),
                (15, 'Juan Segundo Castro', '1998-05-11', 98, 1.6, 5, 'images/alumnonuevo.jpeg'),
                (16, 'Nancy Lujan', '1999-02-02', 68, 1.64, 3, 'images/alumnos/6711d7f93a5de.jpg'),
                (17, 'Juan Marcelo Durdos', '2003-11-22', 65, 1.56, 25, 'images/alumnonuevo.jpeg'),
                (18, 'Cristina Nociti', '1999-03-09', 67, 1.73, 5, 'images/alumnos/67134dfab9d0c.jpeg'),
                (19, 'Juan Ignacio Torrissi', '0000-00-00', 0, 0, 3, 'images/alumnonuevo.jpeg'),
                (34, 'Mariano Cesario', '1980-04-26', 78.5, 1.75, 25, 'images/alumnonuevo.jpeg'),
                (45, 'Roxana Miranda', '1999-09-09', 68.9, 1.69, 3, 'images/alumnonuevo.jpeg');

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `claves`
                --

                CREATE TABLE `claves` (
                  `id_clave` int(11) NOT NULL,
                  `usuario` varchar(30) NOT NULL,
                  `contrasena` varchar(60) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `claves`
                --

                INSERT INTO `claves` (`id_clave`, `usuario`, `contrasena`) VALUES
                (1, 'webadmin', '$clave1');

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `promociones`
                --

                CREATE TABLE `promociones` (
                  `id_promocion` int(11) NOT NULL,
                  `fecha` date NOT NULL,
                  `horario` varchar(30) NOT NULL,
                  `especialidad` varchar(30) NOT NULL,
                  `precio` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `promociones`
                --

                INSERT INTO `promociones` (`id_promocion`, `fecha`, `horario`, `especialidad`, `precio`) VALUES
                (1, '2024-11-01', 'de 15:00 Hs. a 17:00 Hs.', 'pilates', 2000),
                (2, '2024-11-08', 'de 15:00 Hs. a 17:00 Hs.', 'pesas', 2500),
                (3, '2024-11-15', 'de 15:00 Hs. a 17:00 Hs.', 'spinning', 1800),
                (4, '2024-11-22', 'de 16:00 Hs. a 18:00 Hs.', 'pesas', 2000),
                (5, '2024-11-30', 'de 16:00 Hs. a 18:00 Hs.', 'pilates', 1750),
                (6, '2024-11-28', 'de 16:00 Hs. a 18:00 Hs.', 'spinning', 1900),
                (7, '2024-12-05', 'de 11:00 Hs. a 13:00 Hs.', 'pesas', 1500),
                (8, '2024-12-19', 'de 16:00 Hs. a 18:00 Hs.', 'pilates', 3000),
                (9, '2024-12-11', 'de 11:00 Hs. a 13:00 Hs.', 'yoga', 1500),
                (10, '2024-12-18', 'de 11:00 Hs. a 13:00 Hs.', 'yoga', 1750),
                (11, '2025-02-25', 'de 11:00 Hs. a 13:00 Hs.', 'yoga', 1750),
                (13, '2025-03-23', 'de 17:00 Hs. a 19:00 Hs.', 'yoga', 2200),
                (14, '2024-12-27', 'de 11:00 Hs. a 13:00 Hs.', 'pilates', 2500),
                (15, '2024-12-27', 'de 11:00 Hs. a 13:00 Hs.', 'pilates', 2300),
                (16, '2025-12-05', 'de 09:00 Hs. a 11:00 Hs.', 'pesas', 1750),
                (19, '2024-12-19', 'de 16:00 Hs. a 18:00 Hs.', 'pilates', 3000),
                (21, '2025-04-14', 'de 10:00 hs. a 14:30 hs.', 'yoga', 2250),
                (22, '2025-04-15', 'de 11:00 hs. a 14:30 hs.', 'yoga', 2250),
                (23, '2025-04-16', 'de 12:00 hs. a 14:30 hs.', 'yoga', 2250),
                (24, '2024-11-15', 'de 10:00 Hs. a 12:00 Hs.', 'spinning', 1900);

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `rutinas`
                --

                CREATE TABLE `rutinas` (
                  `id_rutina` int(11) NOT NULL,
                  `nombre` varchar(30) NOT NULL,
                  `entrada` varchar(50) NOT NULL,
                  `pecho` varchar(50) NOT NULL,
                  `espalda` varchar(50) NOT NULL,
                  `piernas` varchar(50) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `rutinas`
                --

                INSERT INTO `rutinas` (`id_rutina`, `nombre`, `entrada`, `pecho`, `espalda`, `piernas`) VALUES
                (1, 'Principiante', 'abdominales 3 x 5', 'press banca con mancuernas 3 x 6', 'remo con mancuernas 3 x 7', 'zancadas con mancuerna 3 x 8'),
                (2, 'Intermedio', 'lagartijas 3 x 6', 'press banca con barra 3 x 7', 'remo con barra 3 x 8', 'sentadilla con barra 3 x 9'),
                (3, 'Experto', 'peso muerto con barra 3 x 10', 'polea pecho 3 x 8', 'remo 3 x 9', 'prensa 3 x 10'),
                (5, 'Jovenes', '20 lagartijas', '10 banco con barra 10 Kg.', 'espinales', 'sentadillas'),
                (13, 'Adultos Mayor', '10 lagartijas', 'acostado mancuernas arriba', 'sentado mancuernas arriba', 'sentadillas con disco'),
                (20, 'Maratonistas', 'bicicleta 30 minutos', 'polea 3 series', 'polea 3 series', 'sentadilla con barra de 10 Kg.'),
                (25, 'Ciclistas', '2 series de 10 de abdominales', 'extensiones con mancuerna 5 Kg.', 'polea 2 series', 'press  inclinado 60 Kg.');

                --
                -- Índices para tablas volcadas
                --

                --
                -- Indices de la tabla `alumnos`
                --
                ALTER TABLE `alumnos`
                  ADD PRIMARY KEY (`id_alumno`),
                  ADD UNIQUE KEY `id_alumno` (`id_alumno`),
                  ADD KEY `id_rutina` (`id_rutina`);

                --
                -- Indices de la tabla `claves`
                --
                ALTER TABLE `claves`
                  ADD PRIMARY KEY (`id_clave`),
                  ADD UNIQUE KEY `id_clave` (`id_clave`);

                --
                -- Indices de la tabla `promociones`
                --
                ALTER TABLE `promociones`
                  ADD PRIMARY KEY (`id_promocion`),
                  ADD UNIQUE KEY `id_promocion` (`id_promocion`) USING BTREE;

                --
                -- Indices de la tabla `rutinas`
                --
                ALTER TABLE `rutinas`
                  ADD PRIMARY KEY (`id_rutina`),
                  ADD UNIQUE KEY `id_rutina` (`id_rutina`);

                --
                -- AUTO_INCREMENT de las tablas volcadas
                --

                --
                -- AUTO_INCREMENT de la tabla `alumnos`
                --
                ALTER TABLE `alumnos`
                  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

                --
                -- AUTO_INCREMENT de la tabla `claves`
                --
                ALTER TABLE `claves`
                  MODIFY `id_clave` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

                --
                -- AUTO_INCREMENT de la tabla `promociones`
                --
                ALTER TABLE `promociones`
                  MODIFY `id_promocion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

                --
                -- AUTO_INCREMENT de la tabla `rutinas`
                --
                ALTER TABLE `rutinas`
                  MODIFY `id_rutina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

                --
                -- Restricciones para tablas volcadas
                --

                --
                -- Filtros para la tabla `alumnos`
                --
                ALTER TABLE `alumnos`
                  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_rutina`) REFERENCES `rutinas` (`id_rutina`);
                COMMIT;

                END;
                $this->db->query($sql);
            }
            
        }
       
        private function crearDb(){
            $nombreDb = MYSQL_DB;
            $pdo = new PDO('mysql:host =' . MYSQL_HOST .';charset = utf8', MYSQL_USER, MYSQL_PASS);
            $query = "CREATE DATABASE IF NOT EXISTS $nombreDb";
            $pdo->exec($query);
        }
        
    }

?>