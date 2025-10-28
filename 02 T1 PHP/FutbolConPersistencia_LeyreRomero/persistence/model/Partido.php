<?php
class Partido {
    public $id_partido;
    public $id_local;
    public $id_visitante;
    public $jornada;
    public $resultado;
    public $estadio;

    public function __construct($id_partido, $id_local, $id_visitante, $jornada, $resultado, $estadio) {
        $this->id_partido = $id_partido;
        $this->id_local = $id_local;
        $this->id_visitante = $id_visitante;
        $this->jornada = $jornada;
        $this->resultado = $resultado;
        $this->estadio = $estadio;
    }
}
?>
