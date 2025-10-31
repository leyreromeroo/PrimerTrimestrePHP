<?php
require_once 'GenericDAO.php';
require_once '../models/Partido.php';

class PartidoDAO extends GenericDAO {
    const TABLE = 'partidos';
    const EQUIPO_TABLE = 'equipos'; // Asumo que la tabla de equipos se llama 'equipos'

    public function __construct() {
        parent::__construct();
    }

    // --- Función de Carga de Objetos con Nombres ---
    // Esta función reutilizable simplifica la creación del objeto Partido
    // y asigna los nombres de los equipos usando los nuevos setters del modelo.
    private function createPartidoFromRow($row) {
        $partido = new Partido(
            $row['id_partido'],
            $row['id_local'],
            $row['id_visitante'],
            $row['jornada'],
            $row['resultado'],
            $row['estadio']
        );
        
        // Asignar los nombres obtenidos por el JOIN a las nuevas propiedades del modelo
        // Asumo que los alias en la consulta son 'nombre_local' y 'nombre_visitante'
        if (isset($row['nombre_local'])) {
            $partido->setNombreLocal($row['nombre_local']);
        }
        if (isset($row['nombre_visitante'])) {
            $partido->setNombreVisitante($row['nombre_visitante']);
        }
        
        return $partido;
    }

    // --- Construcción del Query con JOIN ---
    private function getBaseQuery() {
        return "SELECT 
                    p.*, 
                    el.nombre AS nombre_local, 
                    ev.nombre AS nombre_visitante
                FROM " . self::TABLE . " p
                LEFT JOIN " . self::EQUIPO_TABLE . " el ON p.id_local = el.id_equipo
                LEFT JOIN " . self::EQUIPO_TABLE . " ev ON p.id_visitante = ev.id_equipo";
    }


    // ✅ Obtener todos los partidos
    public function selectAll() {
        $query = $this->getBaseQuery();
        $result = mysqli_query($this->conn, $query);
        $partidos = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $partidos[] = $this->createPartidoFromRow($row);
        }
        return $partidos;
    }

    // ✅ Buscar partido por ID
    public function selectById($id) {
        $query = $this->getBaseQuery() . " WHERE p.id_partido = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row ? $this->createPartidoFromRow($row) : null;
    }

    // ✅ Obtener partidos por jornada
    public function selectByJornada($jornada) {
        $query = $this->getBaseQuery() . " WHERE p.jornada = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $jornada);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $partidos = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $partidos[] = $this->createPartidoFromRow($row);
        }
        return $partidos;
    }

    // ✅ Obtener partidos por equipo (MODIFICADO para usar el JOIN)
    public function selectByEquipo($idEquipo) {
        $query = $this->getBaseQuery() . " 
                  WHERE p.id_local = ? OR p.id_visitante = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $idEquipo, $idEquipo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $partidos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $partidos[] = $this->createPartidoFromRow($row);
        }
        return $partidos;
    }

    // Métodos insert, update y delete (sin cambios, ya que solo afectan a la tabla 'partidos')

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
?>