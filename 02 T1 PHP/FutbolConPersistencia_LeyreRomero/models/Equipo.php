<?php
class Equipo {
    private $id_equipo;
    private $nombre;
    private $estadio;

    public function __construct($id_equipo = null, $nombre = "", $estadio = "") {
        $this->id_equipo = $id_equipo;
        $this->nombre = $nombre;
        $this->estadio = $estadio;
    }

    // Getters
    public function getIdEquipo() { return $this->id_equipo; }
    public function getNombre() { return $this->nombre; }
    public function getEstadio() { return $this->estadio; }

    // Setters
    public function setIdEquipo($id_equipo) { $this->id_equipo = $id_equipo; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setEstadio($estadio) { $this->estadio = $estadio; }
}
?>
