<?php

abstract class Estados {
    const EnPreparacion = 1;
    const ListoParaServir = 2;
    const Cancelado = 3;
    const Entregado = 4;
}

class Pedido {
    
    public $id;
    public $estado; //class Estados
    public $tiempoestimado;
    public $tiempoentrega;
    public $codigo;
    public $idmesa;
    public $foto;

    public function AltaDePedido() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into pedido (estado,tiempoestimado,tiempoentrega,codigo,idmesa,foto)values(:estado,:tiempoestimado,:tiempoentrega,:codigo,:idmesa,:foto)");
        $consulta->bindValue(':estado', Estados::EnPreparacion, PDO::PARAM_INT);
        $consulta->bindValue(':tiempoestimado', $this->tiempoestimado, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoentrega', "00:00:00", PDO::PARAM_STR);
        $consulta->bindValue(':codigo', NULL, PDO::PARAM_STR);
        $consulta->bindValue(':idmesa', $this->idmesa, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->execute();

        $ultimoIdInsertado = $objetoAccesoDato->RetornarUltimoIdInsertado();
        return Pedido::InsertarElCodigo($ultimoIdInsertado);
    }

    private static function InsertarElCodigo($id) {
        $hora = date("H");
        if($id >= 100) {
            $codigo = $hora . $id;
        } else if($id >= 10) {
            $codigo = $hora. "0" .$id;
        } else {
            $codigo = $hora. "00" .$id;
        }
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE pedido set codigo=:codigo WHERE id=:id");
        $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $codigo;
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
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE pedido set estado=:estado, tiempoestimado=:tiempoestimado, tiempoentrega=:tiempoentrega, codigo=:codigo, idmesa=:idmesa, foto=:foto WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->bindValue(':tiempoestimado', $this->tiempoestimado, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoentrega', $this->tiempoentrega, PDO::PARAM_STR);
        $consulta->bindValue(':codigo', $this->codigo, PDO::PARAM_STR);
        $consulta->bindValue(':idmesa', $this->idmesa, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        return $consulta->execute();
    }
    
    public static function TraerTodosLosPedidos() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from pedido");
	    $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");
    }

    public static function TraerPedidoConCodigo($codigo) {
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from pedido where codigo = $codigo");
		$consulta->execute();
		$pedido = $consulta->fetchObject('Pedido');
		return $pedido;
    }

    public function mostrarDatosDelPedido() {
        return "Pedido Numero: ".$this->codigo." - Estado: ".$this->estado." - Mesa numero:  ".$this->idmesa." - id: ".$this->id." - tiempo1: ".$this->tiempoestimado." - tiempo2: ".$this->tiempoentrega." - foto: ".$this->foto;
    }
}

?>