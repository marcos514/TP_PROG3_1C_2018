<?php

abstract class Estados {
    const EnPreparacion = 0;
    const ListoParaServir = 1;
    const Cancelado = 2;
}

class Pedido {
    
    public $id;
    public $estado; //class Estados
    public $tiempoEstimado;
    public $tiempoEntrega;
    public $codigo;
    public $idMesa;
    public $foto;

    public function AltaDePedido() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into pedido (estado,tiempoestimado,tiempoentrega,codigo,idmesa)values(:estado,:tiempoestimado,:tiempoentrega,:codigo,:idmesa)");
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->bindValue(':tiempoestimado', $this->tiempoEstimado, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoentrega', date("H:i:s"), PDO::PARAM_STR);
        $consulta->bindValue(':codigo', Self::ObtenerCodigo(), PDO::PARAM_STR);
        $consulta->bindValue(':idmesa', $this->idMesa, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function BajaDePedido() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE from pedido WHERE id=:id");	
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);		
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificacionDePedido() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE pedido set estado=:estado, tiempoestimado=:tiempoestimado, tiempoentrega=:tiempoentrega, codigo=:codigo, idmesa=:idmesa WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->bindValue(':tiempoestimado', $this->tiempoEstimado, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoentrega', $this->tiempoEntrega, PDO::PARAM_STR);
        $consulta->bindValue(':codigo', $this->codigo, PDO::PARAM_STR);
        $consulta->bindValue(':idmesa', $this->idMesa, PDO::PARAM_STR);
        return $consulta->execute();
    }

    public static function ObtenerCodigo() {
        return 11111;
    }
}

?>