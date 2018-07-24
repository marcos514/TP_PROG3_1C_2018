<?php

require 'vendor/autoload.php';
require_once 'BaseDeDatos/AccesoDatos.php';
require_once 'Api/mesaApi.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group('/mesa', function () {

    $this->post('/', \MesaApi::class . ':InsertarLaMesa');

    $this->post('/pedido/', \MesaApi::class . ':InsertarLaMesa');

});

$app->run();

?>