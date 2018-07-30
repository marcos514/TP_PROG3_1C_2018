<?php

abstract class SectoresMesa {
    const BarraDeTragos = 0;
    const BarraDeCervezas = 1;
    const Cocina = 2;
    const CandyBar = 3;
}

abstract class EstadosMesa {
    const Comiendo = 0;
    const Esperando = 1;
    const Pagando = 2;
    const Cerrada = 3;
}

class Mesa {

    public $id;
    public $sector; //class Sectores
    public $estado; //class Estados
    
    public function AltaDeMesa() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("INSERT into mesas (sector,estado)values(:sector,:estado)");
		$consulta->bindValue(':sector', $this->sector, PDO::PARAM_INT);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function BajaDeMesa() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE from mesas WHERE id=:id");	
		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
    }

    public function ModificacionDeMesa() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("UPDATE mesas set sector=:sector, estado=:estado WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':sector',$this->sector, PDO::PARAM_INT);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
		return $consulta->execute();
    }

    public static function TraerTodasLasMesas() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from mesas");
	    $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");
    }

    public static function TraerMesaConId($id) {
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * from mesas where id = $id");
		$consulta->execute();
		$mesa = $consulta->fetchObject('Mesa');
		return $mesa;
    }

    public function mostrarDatosDeLaMesa() {
	  	return "Mesa Numero: ".$this->id." - Estado: ".$this->estado." - Sector:  ".$this->sector;
    }
}

?>