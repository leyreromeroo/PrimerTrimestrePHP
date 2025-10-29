<?php
require 'GenericDAO.php';
require '../models/Equipo.php';

class EquipoDAO extends GenericDAO {
    const TABLE = 'equipos';

    public function __construct() {
        parent::__construct();
    }

    // ✅ Obtener todos los equipos
    public function selectAll() {
        $query = "SELECT * FROM " . self::TABLE;
        $result = mysqli_query($this->conn, $query);
        $equipos = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $equipos[] = new Equipo(
                $row['id_equipo'],
                $row['nombre'],
                $row['estadio']
            );
        }
        return $equipos;
    }

    // ✅ Buscar equipo por ID
    public function selectById($id) {
        $query = "SELECT * FROM " . self::TABLE . " WHERE id_equipo = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row ? new Equipo($row['id_equipo'], $row['nombre'], $row['estadio']) : null;
    }

    // ✅ Insertar equipo nuevo
    public function insert($nombre, $estadio) {
        $query = "INSERT INTO " . self::TABLE . " (nombre, estadio) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $nombre, $estadio);
        return mysqli_stmt_execute($stmt);
    }

    // ✅ Actualizar equipo
    public function update($id, $nombre, $estadio) {
        $query = "UPDATE " . self::TABLE . " SET nombre = ?, estadio = ? WHERE id_equipo = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $estadio, $id);
        return mysqli_stmt_execute($stmt);
    }

    // ✅ Eliminar equipo
    public function delete($id) {
        $query = "DELETE FROM " . self::TABLE . " WHERE id_equipo = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }
}
