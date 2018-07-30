<?php

require_once "Entidades/personal.php";
require_once "Interfaces/IApiEmpleados.php";

class EmpleadosApi extends Personal implements IApiEmpleados {

    public function InsertarEmpleado($request, $response, $args) {

        $objDelaRespuesta= new stdclass();
        
        $ArrayDeParametros = $request->getParsedBody();
        
        $tipo = $ArrayDeParametros['tipo'];
        switch($tipo) {
            case "Socio": $tipo = TipoDePersonal::Socio;
                break;
            case "Mozo": $tipo = TipoDePersonal::Mozo;
                break;
            case "Cocinero": $tipo = TipoDePersonal::Cocinero;
                break;
            case "Cervecero": $tipo = TipoDePersonal::Cervecero;
                break;
            case "Bartender": $tipo = TipoDePersonal::Bartender;
                break;
            default: $tipo = 0;
        }
        $estado = EstadoPersonal::Activo;
        
        $empleado = new Personal();
        $empleado->tipo = $tipo;
        $empleado->estado = $estado;

        if($empleado->tipo != 0) {
            $id = $empleado->AltaDePersonal();
            $objDelaRespuesta->respuesta = "Se inserto el empleado numero: $id";
        } else {
            $objDelaRespuesta->respuesta = "Se necesita especificar el tipo( Socio / Mozo / Cocinero / Cervecero / Bartender )";
        }
        
        return $response->withJson($objDelaRespuesta, 200);
    }
}

?>