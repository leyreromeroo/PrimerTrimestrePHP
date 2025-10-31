<?php

class Partido {
    private $id_partido;
    private $id_local;
    private $id_visitante;
    private $jornada;
    private $resultado;
    private $estadio;
    private $nombre_local;
    private $nombre_visitante;


    public function __construct($id_partido = null, $id_local = null, $id_visitante = null, $jornada = "", $resultado = "", $estadio = "",$nombre_local = "", $nombre_visitante = "") {
        $this->id_partido = $id_partido;
        $this->id_local = $id_local;
        $this->id_visitante = $id_visitante;
        $this->jornada = $jornada;
        $this->resultado = $resultado;
        $this->estadio = $estadio;
        $this->nombre_local = $nombre_local; 
        $this->nombre_visitante = $nombre_visitante; 
    }

    // Getters 
    public function getIdPartido() { return $this->id_partido; }
    public function getIdLocal() { return $this->id_local; }
    public function getIdVisitante() { return $this->id_visitante; }
    public function getJornada() { return $this->jornada; }
    public function getResultado() { return $this->resultado; }
    public function getEstadio() { return $this->estadio; }
    public function getNombreEquipoLocal() {return $this->nombre_local;}
    public function getNombreEquipoVisitante() {return $this->nombre_visitante;}

    // Setters 
    public function setIdPartido($id_partido) { $this->id_partido = $id_partido; }
    public function setIdLocal($id_local) { $this->id_local = $id_local; }
    public function setIdVisitante($id_visitante) { $this->id_visitante = $id_visitante; }
    public function setJornada($jornada) { $this->jornada = $jornada; }
    public function setResultado($resultado) { $this->resultado = $resultado; }
    public function setEstadio($estadio) { $this->estadio = $estadio; }
    public function setNombreLocal($nombre_local) { $this->nombre_local = $nombre_local; }
    public function setNombreVisitante($nombre_visitante) { $this->nombre_visitante = $nombre_visitante; }
    
   
}
?>
