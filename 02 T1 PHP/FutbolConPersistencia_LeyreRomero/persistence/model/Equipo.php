<?php
class Equipo {
    public $id_equipo;
    public $nombre;
    public $estadio;

    public function __construct($id_equipo, $nombre, $estadio) {
        $this->id_equipo = $id_equipo;
        $this->nombre = $nombre;
        $this->estadio = $estadio;
    }
}
?>
