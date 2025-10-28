<?php
require_once 'GenericDAO.php';
require_once __DIR__ . '/../model/Equipo.php';

class EquipoDAO {

    private $conn;

    public function __construct() {
        $this->conn = PersistentManager::getInstance()->get_connection();
    }

    public function getAllEquipos() {
        $query = "SELECT * FROM equipos";
        $result = mysqli_query($this->conn, $query);
        $equipos = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $equipos[] = new Equipo($row['id_equipo'], $row['nombre'], $row['estadio']);
        }

        return $equipos;
    }

    public function getEquipoById($id) {
        $query = "SELECT * FROM equipos WHERE id_equipo = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row ? new Equipo($row['id_equipo'], $row['nombre'], $row['estadio']) : null;
    }

    public function insertEquipo($nombre, $estadio) {
        $query = "INSERT INTO equipos (nombre, estadio) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $nombre, $estadio);
        return mysqli_stmt_execute($stmt);
    }
}
?>
