<?php
//getdate();  http://php.net/manual/es/function.getdate.php
class Horarios {

    public $id;
    public $fechaYHorario;
    public $idEmpleado;

    public function AltaDeHorario() {
        $this->fechaYHorario = date("Y-m-d H:i:s");
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into horarios (fecha,idempleado)values(:fecha,:idempleado)");
        $consulta->bindValue(':fecha', $this->fechaYHorario, PDO::PARAM_INT);
        $consulta->bindValue(':idempleado', $this->idEmpleado, PDO::PARAM_STR);
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
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE horarios set fecha=:fecha, idempleado=:idempleado, idmesa=:idmesa, idpedido=:idpedido, importe=:importe WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_INT);
        $consulta->bindValue(':idempleado', $this->idEmpleado, PDO::PARAM_STR);
        return $consulta->execute();
    }
}

?>