<?php

require 'vendor/autoload.php';
require_once 'BaseDeDatos/AccesoDatos.php';
require_once 'Api/mesaApi.php';
require_once 'Api/empleadosApi.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group('/mesa', function () {

    $this->post('/alta', \MesaApi::class . ':InsertarLaMesa');

});

$app->group('/pedido', function () {

    $this->post('/alta', \MesaApi::class . ':HacerPedido');

    $this->post('/listo', \MesaApi::class . ':PedidoListo');

    $this->post('/entregar', \MesaApi::class . ':PedidoEntregado');

    $this->post('/facturar', \MesaApi::class . ':Factura');

    $this->post('/cancelar', \MesaApi::class . ':CancelarPedido');

    $this->post('/items', \MesaApi::class . ':AgregarItems');

});

$app->group('/empleado', function () {

    $this->post('/alta', \EmpleadosApi::class . ':InsertarEmpleado');

});

$app->run();

?>