<?php
require_once 'GenericDAO.php';
require_once '/../models/Partido.php';

class PartidoDAO extends GenericDAO {
    const TABLE = 'partidos';

    public function __construct() {
        parent::__construct();
    }

    // ✅ Obtener todos los partidos
    public function selectAll() {
        $query = "SELECT * FROM " . self::TABLE;
        $result = mysqli_query($this->conn, $query);
        $partidos = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $partidos[] = new Partido(
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

    // ✅ Buscar partido por ID
    public function selectById($id) {
        $query = "SELECT * FROM " . self::TABLE . " WHERE id_partido = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row ? new Partido(
            $row['id_partido'],
            $row['id_local'],
            $row['id_visitante'],
            $row['jornada'],
            $row['resultado'],
            $row['estadio']
        ) : null;
    }

    // ✅ Obtener partidos por jornada
    public function selectByJornada($jornada) {
        $query = "SELECT * FROM " . self::TABLE . " WHERE jornada = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $jornada);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $partidos = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $partidos[] = new Partido(
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

    // ✅ Obtener partidos por equipo
    public function selectByEquipo($idEquipo) {
        $query = "SELECT * FROM " . self::TABLE . " 
                  WHERE id_local = ? OR id_visitante = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $idEquipo, $idEquipo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $partidos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $partidos[] = new Partido(
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

    // ✅ Insertar nuevo partido
    public function insert($id_local, $id_visitante, $jornada, $resultado, $estadio) {
        // Evitar duplicados
        $check = "SELECT COUNT(*) AS total FROM " . self::TABLE . " WHERE id_local = ? AND id_visitante = ?";
        $stmt = mysqli_prepare($this->conn, $check);
        mysqli_stmt_bind_param($stmt, "ii", $id_local, $id_visitante);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($res);
        if ($row['total'] > 0) return false;

        $query = "INSERT INTO " . self::TABLE . " (id_local, id_visitante, jornada, resultado, estadio)
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "iiiss", $id_local, $id_visitante, $jornada, $resultado, $estadio);
        return mysqli_stmt_execute($stmt);
    }

    // ✅ Actualizar partido
    public function update($id, $id_local, $id_visitante, $jornada, $resultado, $estadio) {
        $query = "UPDATE " . self::TABLE . "
                  SET id_local = ?, id_visitante = ?, jornada = ?, resultado = ?, estadio = ?
                  WHERE id_partido = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "iiissi", $id_local, $id_visitante, $jornada, $resultado, $estadio, $id);
        return mysqli_stmt_execute($stmt);
    }

    // ✅ Eliminar partido
    public function delete($id) {
        $query = "DELETE FROM " . self::TABLE . " WHERE id_partido = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }
}
