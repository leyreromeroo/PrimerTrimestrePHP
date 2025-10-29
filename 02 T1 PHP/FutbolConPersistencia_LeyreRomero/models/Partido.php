<?php
class Partido {
    private $id_partido;
    private $id_local;
    private $id_visitante;
    private $jornada;
    private $resultado;
    private $estadio;

    public function __construct($id_partido = null, $id_local = null, $id_visitante = null, $jornada = "", $resultado = "", $estadio = "") {
        $this->id_partido = $id_partido;
        $this->id_local = $id_local;
        $this->id_visitante = $id_visitante;
        $this->jornada = $jornada;
        $this->resultado = $resultado;
        $this->estadio = $estadio;
    }

    // Getters
    public function getIdPartido() { return $this->id_partido; }
    public function getIdLocal() { return $this->id_local; }
    public function getIdVisitante() { return $this->id_visitante; }
    public function getJornada() { return $this->jornada; }
    public function getResultado() { return $this->resultado; }
    public function getEstadio() { return $this->estadio; }

    // Setters
    public function setIdPartido($id_partido) { $this->id_partido = $id_partido; }
    public function setIdLocal($id_local) { $this->id_local = $id_local; }
    public function setIdVisitante($id_visitante) { $this->id_visitante = $id_visitante; }
    public function setJornada($jornada) { $this->jornada = $jornada; }
    public function setResultado($resultado) { $this->resultado = $resultado; }
    public function setEstadio($estadio) { $this->estadio = $estadio; }
}
?>
