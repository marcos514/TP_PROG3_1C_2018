<?php

abstract class TipoDePersonal {
    const Socio = 1;
    const Mozo = 2;
    const Cocinero = 3;
    const Cervecero = 4;
    const Bartender = 5;
}

abstract class EstadoPersonal {
    const Activo = 0;
    const Inactivo = 1;
    const Suspendido = 2;
}

class Personal {
    
    public $id;
    public $tipo;
    public $estado; //Posibilidad de dar de alta a nuevos, suspenderlos o borrarlos

    public function AltaDePersonal() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into personal (tipo,estado)values(:tipo,:estado)");
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function BajaDePersonal() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE from personal WHERE id=:id");	
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);		
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificacionDePersonal() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE personal set tipo=:tipo, estado=:estado WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        return $consulta->execute();
    }
}

?>