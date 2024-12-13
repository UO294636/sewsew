
<?php
class Record {
    private $server;
    private $user;
    private $pass;
    private $dbname;
    private $connection;

    public function __construct() {
        $this->server = "localhost";
        $this->user = "DBUSER2024";
        $this->pass = "DBPSWD2024";
        $this->dbname = "records";

        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->server, $this->user, $this->pass, $this->dbname);
        
        if ($this->connection->connect_error) {
            die("Error al conectar a la base de datos: " . $this->connection->connect_error);
        }
            
    }

    public function saveRecord($name, $lastname, $level, $time) {
        $stmt = $this->connection->prepare("INSERT INTO registro (nombre, apellidos, nivel, tiempo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $lastname, $level, $time);

        if (!$stmt->execute()) {
            echo "Error al guardar el récord: " . $stmt->error;
        }
        $stmt->close();
    }

    public function getTopRecords($level) {
        $stmt = $this->connection->prepare("SELECT nombre, apellidos, tiempo FROM registro WHERE nivel = ? ORDER BY tiempo ASC LIMIT 10");
        $stmt->bind_param("d", $level);
        $stmt->execute();
        $result = $stmt->get_result();

        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }

        $stmt->close();
        return $records;
    }
}
?>


<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <title>F1 DESKTOP Juegos</title>
    <link rel ="icon" href="multimedia/imagenes/favicon.ico" />
    <meta name = "author" content = "Sergio García Santamarina" />
    <meta name = "description" content = "Documento para utilizar en otros módulos de la asignatura" />
    <meta charset="UTF-8" />
    <meta name = "keywords" content = "semaforo,reaccion,juego,f1" /> <!--CAMBIAR-->
    <meta name = "viewport" content = "width= device-width, initial-scale=1.0" />
     <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="estilo/estilo.css" />
    <link rel="stylesheet" type="text/css" href="estilo/layout.css" />
    <link rel = "stylesheet" type="text/css" href= "estilo/semaforo_grid.css" />
</head>
<body>
    <!-- Datos con el contenidos que aparece en el navegador -->
    <header>
    <h1>F1 Desktop</h1>
    <nav>
        <a href="index.html">Inicio</a> 
        <a href="piloto.html">Piloto</a> 
        <a href="noticias.html">Noticias</a> 
        <a href="calendario.html">Calendario</a> 
        <a href="meteorología.html">Meteorología</a> 
        <a href="circuito.html">Circuito</a> 
        <a href="viajes.html">Viajes</a> 
        <a href="juegos.html">Juegos</a> 
       </nav>
    </header>
    <p>Estás en: <strong><a href="index.html">Inicio</a> > > Juegos > > Semáforo</strong></p>
    <h2>Menu de Juegos Disponibles</h2>
    <nav>
        <a title="Memoria" href="memoria.html">Memoria</a>
        <a title="Tiempo de Reacción" href="semaforo.php">Tiempo de Reacción</a>
    </nav>

    <main>
    </main>
    <script src="js/semaforo.js"></script>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $_POST['nombre'];
                $lastname = $_POST['apellidos'];
                $level = $_POST['nivel'];
                $time = $_POST['tiempo'];
            
                $record = new Record();
                $record->saveRecord($name, $lastname, $level, $time);
                $record->getTopRecords($level);
            }
        ?>
</body>
</html>