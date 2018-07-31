<?php

require_once "Entidades/personal.php";
require_once "Entidades/horarioEmpleados.php"

class MWempleados
{
    public function TraerDiasHorarios($request, $response, $next) {
        
        $response = $next($request, $response);
        
        foreach($empleados as $aux) {
            $respuesta = $respuesta . $aux->mostrarDatosDelPedido() . "<br>";
        }
        $empleados
        Personal::TraerEmpleadoConId();
    }

}

?>