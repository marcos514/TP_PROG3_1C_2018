<?php
require_once "Entidades/mesa.php";
require_once "Entidades/factura.php";
require_once "Entidades/items.php";
require_once "Entidades/pedido.php";
require_once "Entidades/comentario.php";
require_once "Interfaces/IApiMesa.php";

class MesaApi extends Mesa implements IApiMesa {

    public function InsertarLaMesa($request, $response, $args) {

        $objDelaRespuesta= new stdclass();
        
        $ArrayDeParametros = $request->getParsedBody();
        
        $sector = $ArrayDeParametros['sector'];
        switch($sector) {
            case "Cocina": $sector = SectoresMesa::Cocina;
                break;
            case "BarraDeTragos": $sector = SectoresMesa::BarraDeTragos;
                break;
            case "BarraDeCervezas": $sector = SectoresMesa::BarraDeCervezas;
                break;
            case "CandyBar": $sector = SectoresMesa::CandyBar;
                break;
            default: $sector = NULL;
        }
        $estado = EstadosMesa::Cerrada;
        
        $miMesa = new Mesa();
        $miMesa->sector = $sector;
        $miMesa->estado = $estado;
        if($sector != NULL) {
            $id = $miMesa->AltaDeMesa();
            $objDelaRespuesta->respuesta = "Se inserto la mesa numero: $id";
        } else {
            $objDelaRespuesta->respuesta = "Se necesita especificar el sector( Cocina / BarraDeTragos / BarraDeCervezas / CandyBar )";
        }
        
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function HacerPedido($request, $response, $args) {

        $objDelaRespuesta= new stdclass();
        
        $ArrayDeParametros = $request->getParsedBody();
        
        $tiempoestimado = $ArrayDeParametros['tiempoestimado'];
        $mesa = $ArrayDeParametros['mesa'];

        
        $archivos = $request->getUploadedFiles();
        $destino="fotos/";
        $foto = uniqid();
        if(isset($archivos['foto']))
        {
            $nombreAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $nombreAnterior)  ;
            $extension=array_reverse($extension);
            $foto = $destino.$foto.".".$extension[0];
            $archivos['foto']->moveTo($foto);
        }
        
        $miPedido = new Pedido();
        $miPedido->idMesa = $mesa;
        $miPedido->tiempoestimado = $tiempoestimado;
        $miPedido->foto = $foto;
        
        $miMesa = Mesa::TraerMesaConId($mesa);
        $miMesa->estado = EstadosMesa::Esperando;

        if($tiempoestimado != NULL && $miMesa->id != "") {
            //$codigo = $miPedido->AltaDePedido();
            //$miMesa->ModificacionDeMesa();
            $objDelaRespuesta->respuesta = "Codigo de pedido: $codigo";    
        } else {
            $objDelaRespuesta->respuesta = "Se necesita especificar una mesa (Valida) y el tiempo estimado (HH:MM:SS)";
        }
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function PedidoListo($request, $response, $args) {

        $objDelaRespuesta= new stdclass();
        $ArrayDeParametros = $request->getParsedBody();
        $codigo = $ArrayDeParametros['codigo'];
        
        $miPedido = Pedido::TraerPedidoConCodigo($codigo);
        $miPedido->estado = Estados::ListoParaServir;
        
        if($codigo != NULL && $miPedido->id != "") {
            $respuesta = $miPedido->ModificacionDePedido();
            $objDelaRespuesta->respuesta = "Pedido listo: $codigo";  
        } else {
            $objDelaRespuesta->respuesta = "Se necesita especificar un pedido (Valido)";
        }

        return $response->withJson($objDelaRespuesta, 200);
    }

    public function PedidoEntregado($request, $response, $args) {

        $objDelaRespuesta= new stdclass();
        $ArrayDeParametros = $request->getParsedBody();
        $codigo = $ArrayDeParametros['codigo'];
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $tiempoentrega = date("H:i:s", time());

        $miPedido = Pedido::TraerPedidoConCodigo($codigo);
        $miPedido->tiempoentrega = $tiempoentrega;
        $miPedido->estado = Estados::Entregado;
        
        $miMesa = Mesa::TraerMesaConId($miPedido->idmesa);
        $miMesa->estado = EstadosMesa::Comiendo;

        if($tiempoentrega != NULL && $miMesa->id != "" && $miPedido->id != "") {
            $respuesta = $miPedido->ModificacionDePedido();
            $respuesta = ($miMesa->ModificacionDeMesa() . $respuesta); 
            $objDelaRespuesta->respuesta = "Pedido entregado: $codigo";    
        } else {
            $respuesta = $miPedido->mostrarDatosDelPedido();
            $objDelaRespuesta->respuesta = "Se necesita especificar un pedido (Valido) $respuesta";
        }

        return $response->withJson($objDelaRespuesta, 200);
    }

    public function CancelarPedido($request, $response, $args) {

        $objDelaRespuesta= new stdclass();
        $ArrayDeParametros = $request->getParsedBody();
        $codigo = $ArrayDeParametros['codigo'];

        $miPedido = Pedido::TraerPedidoConCodigo($codigo);
        $miPedido->estado = Estados::Cancelado;

        if($miPedido->id != "") {
            $miPedido->ModificacionDePedido();
            $objDelaRespuesta->respuesta = "Pedido cancelado";    
        } else {
            $objDelaRespuesta->respuesta = "Se necesita especificar una pedido (Valido)";
        }

        return $response->withJson($objDelaRespuesta, 200);
    }

    public function AgregarItems($request, $response, $args) {

        $objDelaRespuesta= new stdclass();
        $ArrayDeParametros = $request->getParsedBody();
        $cantidad = $ArrayDeParametros['cantidad'];
        $descripcion = $ArrayDeParametros['descripcion'];
        $codigo = $ArrayDeParametros['codigo'];
        
        /*
        $items = array("cantidad" => $cantidad, "descripcion" => $descripcion, "codigo" => $codigo);
        $json_string = json_encode($items);
        $file = 'BaseDeDatos/items.json';
        if(file_exists($file)) {
            $datos = file_get_contents($file);
            $datos = substr($datos, 0, -1);
            file_put_contents($file, $datos . "," .$json_string . "]");
        } else {
            file_put_contents($file, "[" . $json_string . "]");
        }
        */

        $items = new Items();
        $items->cantidad = $cantidad;
        $items->descripcion = $descripcion;
        $items->codigopedido = $codigo;
        $respuesta = $items->AltaDeItem();
        $objDelaRespuesta->respuesta = "Se insertaron los items con id: $respuesta";
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function Factura($request, $response, $args) {

        $objDelaRespuesta= new stdclass();
        $ArrayDeParametros = $request->getParsedBody();
        $responsable = $ArrayDeParametros['responsable'];
        $mesa = $ArrayDeParametros['mesa'];
        $pedido = $ArrayDeParametros['pedido'];
        $importe = $ArrayDeParametros['importe'];

        $nuevaFactura = new Factura();
        $nuevaFactura->idresponsable = $responsable;
        $nuevaFactura->idpedido = $pedido;
        $nuevaFactura->idmesa = $mesa;
        $nuevaFactura->importe = $importe;

        $respuesta = $nuevaFactura->AltaDeFactura();
        $objDelaRespuesta->respuesta = "Se insertaron la factura con id: $respuesta";
        return $response->withJson($objDelaRespuesta, 200);
    }
}

?>