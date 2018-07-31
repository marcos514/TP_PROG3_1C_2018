<?php

require 'vendor/autoload.php';
require_once 'BaseDeDatos/AccesoDatos.php';
require_once 'Api/mesaApi.php';
require_once 'Api/empleadosApi.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group('/mesa', function () {

    $this->post('/', \MesaApi::class . ':InsertarLaMesa');

    $this->delete('/', \MesaApi::class . ':BorrarMesa');

    $this->put('/', \MesaApi::class . ':ModificarMesa');

    $this->post('/cerrar', \MesaApi::class . ':CerrarMesa');

    $this->post('/comentario', \MesaApi::class . ':AgregarComentario');

    $this->delete('/comentario', \MesaApi::class . ':BorrarComentario');

    $this->put('/comentario', \MesaApi::class . ':ModificarComentario');

});

$app->group('/pedido', function () {

    $this->post('/', \MesaApi::class . ':HacerPedido');

    $this->delete('/', \MesaApi::class . ':BorrarPedido');

    $this->put('/', \MesaApi::class . ':ModificarPedido');

    $this->post('/listo', \MesaApi::class . ':PedidoListo');

    $this->post('/entregar', \MesaApi::class . ':PedidoEntregado');

    $this->post('/facturar', \MesaApi::class . ':Facturar');

    $this->post('/cancelar', \MesaApi::class . ':CancelarPedido');

    $this->post('/items', \MesaApi::class . ':AgregarItems');

});

$app->group('/empleado', function () {

    $this->post('/', \EmpleadosApi::class . ':InsertarEmpleado');

    $this->delete('/', \MesaApi::class . ':BorrarEmpleado');

    $this->put('/', \MesaApi::class . ':ModificarEmpleado');

    $this->post('/login', \LoginApi::class . ':AltaDatos');

    $this->post('/fichar', \EmpleadosApi::class . ':Fichar');

    $this->post('/suspender', \EmpleadosApi::class . ':Suspender');

    $this->post('/borrar', \EmpleadosApi::class . ':BajaLogica');

});

$app->run();

?>