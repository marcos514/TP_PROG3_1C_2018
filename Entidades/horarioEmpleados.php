<?php

class Horarios {

    public $id;
    public $fechaYHorario;
    public $idempleado;

    public function AltaDeHorario() {
        $this->fechaYHorario = date("Y-m-d H:i:s");
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into horarios (fecha,idempleado)values(:fecha,:idempleado)");
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $consulta->bindValue(':fecha', date("Y-m-d H:i:s"), PDO::PARAM_INT);
        $consulta->bindValue(':idempleado', $this->idempleado, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function BajaDeHorario() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE from horarios WHERE id=:id");	
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);		
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificacionDeHorario() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE horarios set fecha=:fecha, idempleado=:idempleado WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_INT);
        $consulta->bindValue(':idempleado', $this->idempleado, PDO::PARAM_STR);
        return $consulta->execute();
    }

    public static function TraerTodosLosHorarios() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from horarios");
	    $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Horarios");
    }
}

?>