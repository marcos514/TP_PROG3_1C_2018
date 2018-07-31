<?php

class Login {
    
    public $id;
    public $usuario;
    public $contrasenia;
    public $idempleado;

    public function AltaDatos() {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into login (usuario,contrasenia,idempleado)values(:usuario,:contrasenia)");
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':contrasenia', $this->contrasenia, PDO::PARAM_STR);
        $consulta->bindValue(':idempleado', $this->id, PDO::PARAM_INT);
        $consulta->execute();

        $ultimoIdInsertado = $objetoAccesoDato->RetornarUltimoIdInsertado();
        return Pedido::InsertarElCodigo($ultimoIdInsertado);
    }

    public function BajaDatos() {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE from login WHERE id=:id");	
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);		
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificacionDatos() {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE login set usuario=:usuario, contrasenia=:contrasenia, idempleado=:idempleado WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':contrasenia', $this->contrasenia, PDO::PARAM_STR);
        $consulta->bindValue(':idempleado', $this->idempleado, PDO::PARAM_INT);
        return $consulta->execute();
    }

    public static function Verificar($usuario, $contrasenia) {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from login where usuario=$usuario AND contrasenia=$contrasenia");
	    $consulta->execute();			
        $datos = $consulta->fetchObject('Login');
        if($datos != NULL) {
            return true;
        } else {
            return false;
        }
    }
?>