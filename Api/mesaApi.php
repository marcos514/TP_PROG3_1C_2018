<?php
abstract class Acumulador {
    const Acumulador = 0;
}
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
            $miMesa->AltaDeMesa();
            $objDelaRespuesta->respuesta = "Se inserto la mesa";
        } else {
            $objDelaRespuesta->respuesta = "Se necesita especificar el sector( Cocina / BarraDeTragos / BarraDeCervezas / CandyBar )";
        }
        
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function HacerPedido($request, $response, $args) {

        $objDelaRespuesta= new stdclass();
        
        $ArrayDeParametros = $request->getParsedBody();
        
        $sector = $ArrayDeParametros['tiempoEstimado'];
        $mesa = $ArrayDeParametros['mesa'];
        $archivos = $request->getUploadedFiles();
        $destino="/fotos/";
        var_dump($archivos);
        var_dump($archivos['foto']);
        if(isset($archivos['foto']))
        {
            $nombreAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $nombreAnterior)  ;
            //var_dump($nombreAnterior);
            $extension=array_reverse($extension);
            $archivos['foto']->moveTo($destino.$foto.".".$extension[0]);
        }       
        
        $miMesa = new Pedido();
        $miMesa->sector = $sector;
        $miMesa->estado = $estado;
        if($sector != NULL) {
            $miMesa->AltaDeMesa();
            $objDelaRespuesta->respuesta = "Se inserto la mesa";
        } else {
            $objDelaRespuesta->respuesta = "Se necesita especificar el sector( Cocina / BarraDeTragos / BarraDeCervezas / CandyBar )";
        }
        
        return $response->withJson($objDelaRespuesta, 200);
    }
}

?>