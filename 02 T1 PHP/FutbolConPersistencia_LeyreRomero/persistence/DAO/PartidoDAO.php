<?php
require_once 'GenericDAO.php';
require_once __DIR__ . '/../model/Partido.php';

class PartidoDAO
{
    private $id_partido;
    private $id_local;
    private $id_visitante;
    private $jornada;
    private $resultado;
    private $estadio;
    private $conn;

    public function __construct($id_partido, $id_local, $id_visitante, $jornada, $resultado, $estadio)
    {
        $this->conn = PersistentManager::getInstance()->get_connection();
        $this->id_partido = $id_partido;
        $this->id_local = $id_local;
        $this->id_visitante = $id_visitante;
        $this->jornada = $jornada;
        $this->resultado = $resultado;
        $this->estadio = $estadio;
    }

    public function getPartidosByJornada($jornada)
    {
        $query = "SELECT * FROM partidos WHERE jornada = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $jornada);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $partidos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $partidos[] = new PartidoDAO(
                $row['id_partido'],
                $row['id_local'],
                $row['id_visitante'],
                $row['jornada'],
                $row['resultado'],
                $row['estadio']
            );
        }
        return $partidos;
    }

    public function getPartidosByEquipo($idEquipo)
    {
        $query = "SELECT * FROM partidos 
              WHERE id_local = ? OR id_visitante = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $idEquipo, $idEquipo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $partidos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $partidos[] = new PartidoDAO(
                $row['id_partido'],
                $row['id_local'],
                $row['id_visitante'],
                $row['jornada'],
                $row['resultado'],
                $row['estadio']
            );
        }

        return $partidos;
    }


    public function insertPartido($local, $visitante, $jornada, $resultado, $estadio)
    {
        // Validar que no se repita partido
        $check = "SELECT * FROM partidos WHERE id_local = ? AND id_visitante = ?";
        $stmt = mysqli_prepare($this->conn, $check);
        mysqli_stmt_bind_param($stmt, "ii", $local, $visitante);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($res) > 0) {
            return false; // Ya existe
        }

        $query = "INSERT INTO partidos (id_local, id_visitante, jornada, resultado, estadio)
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "iiiss", $local, $visitante, $jornada, $resultado, $estadio);
        return mysqli_stmt_execute($stmt);
    }
}
