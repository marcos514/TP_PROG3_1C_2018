<?php

class Factura {

    public $id;
    public $fecha;
    public $idresponsable;
    public $idpedido;
    public $idmesa;
    public $importe;

    public function AltaDeFactura() {
        $this->fecha = date("Ymd");
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into facturas (fecha,idresponsable,idpedido,idmesa,importe)values(:fecha,:idresponsable,:idpedido,:idmesa,:importe)");
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_INT);
        $consulta->bindValue(':idresponsable', $this->idresponsable, PDO::PARAM_STR);
        $consulta->bindValue(':idpedido', $this->idPedido, PDO::PARAM_STR);
        $consulta->bindValue(':idmesa', $this->idmesa, PDO::PARAM_STR);
        $consulta->bindValue(':importe', $this->importe, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function BajaDeFactura() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE from facturas WHERE id=:id");	
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);		
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificacionDeFactura() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE facturas set fecha=:fecha, idresponsable=:idresponsable, idmesa=:idmesa, idpedido=:idpedido, importe=:importe WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_INT);
        $consulta->bindValue(':idresponsable', $this->idresponsable, PDO::PARAM_STR);
        $consulta->bindValue(':idmesa', $this->idmesa, PDO::PARAM_STR);
        $consulta->bindValue(':idpedido', $this->idpedido, PDO::PARAM_STR);
        $consulta->bindValue(':importe', $this->importe, PDO::PARAM_STR);
        return $consulta->execute();
    }
}

?>