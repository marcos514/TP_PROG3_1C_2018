<?php

class Items {

    public $id;
    public $cantidad;
    public $descripcion;
    public $precio;
    public $idFactura;

    public function AltaDeItem() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into items (cantidad,descripcion,precio,idfactura)values(:cantidad,:descripcion,:precio,:idfactura)");
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':idfactura', $this->idFactura, PDO::PARAM_STR);
        $consulta->execute();		
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function BajaDeItem() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE from items WHERE id=:id");	
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);		
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificacionDeItem() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE items set cantidad=:cantidad, descripcion=:descripcion, precio=:precio, idfactura=:idfactura WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':idfactura', $this->idFactura, PDO::PARAM_STR);
        return $consulta->execute();
    }
}

?>