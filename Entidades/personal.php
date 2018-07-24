<?php

class TipoDePersonal extends SplEnum {
    const Socio = 0;
    const Mozo = 1;
    const Cocinero = 2;
    const Cervecero = 3;
    const Bartender = 4;
}

class EstadoPersonal extends SplEnum {
    const Activo = 0;
    const Inactivo = 1;
    const Suspendido = 2;
}

class Personal {
    
    public $id;
    public $tipo;
    public $estado; //Posibilidad de dar de alta a nuevos, suspenderlos o borrarlos
    public $cantidadDeOperaciones;

    public function AltaDePersonal() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into personal (tipo,estado,operaciones)values(:tipo,:estado,:operaciones)");
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->bindValue(':operaciones', $this->cantidadDeOperaciones, PDO::PARAM_STR);
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
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE personal set tipo=:tipo, estado=:estado, operaciones=:operaciones WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':operaciones', $this->cantidadDeOperaciones, PDO::PARAM_STR);
        return $consulta->execute();
    }
}

?>