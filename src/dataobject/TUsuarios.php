<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/glob.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/vendor/autoload.php");
use Medoo\Medoo;


class TUsuarios
{
    private $rt;
    private $database;
    private $table = 'usuario';
    public function __construct(){
        $this->database = new Medoo([
            // required
            'database_type' => 'mysql',
            'database_name' => DATABASE,
            'server' => SQL_HOST,
            'username' => SQL_USER,
            'password' => SQL_PASS,
         
            // [optional]
            'charset' => 'utf8',
            'port' => SQL_PORT
        ]);

        $this->rt = array(
            'error'=> 0,
            'mensaje' => null,
            'data' => null
        );
    }



    public function getUsuarios()
    {
        $data = $this->database->select($this->table,'*',['estado'=>1]);
        if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
        {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        }
        else
        {
            if($data && count($data) > 0)
            {
                $this->rt['error'] = 0;
                $this->rt['data'] = $data;   
            }
        }
        return $this->rt;
    }

    public function getUsuariosById($id)
    {
        $data = $this->database->select($this->table,'*', ['id'=>$id]);
        if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
        {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        }
        else
        {
            if($data && count($data) > 0)
            {
                $this->rt['error'] = 0;
                $this->rt['data'] = $data;   
            }
        }
        return $this->rt;
    }

    public function getUsuariosByEmail($email)
    {
        $data = $this->database->select($this->table,'*', ['email'=>$email]);
        if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
        {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        }
        else
        {
            if($data && count($data) > 0)
            {
                $this->rt['error'] = 0;
                $this->rt['data'] = $data;   
            }
        }
        return $this->rt;
    }


    public function insertUsuario($nombres, $apellidos, $email, $password, $estado)
    {
        $data = $this->database->insert($this->table,[
            'nombres' => $nombres, 
            'apellidos' => $apellidos, 
            'email' => $email, 
            'password' => MD5($password), 
            'estado' => $estado
        ]);

        if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
        {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        }
        else
        {
            if($data && count($data) > 0)
            {
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "Datos grabados con éxito..!!";
                $this->rt['data'] =   $this->database->id();
            }
        }
        return $this->rt;
    }

    public function updateUsuario($id, $nombres, $apellidos, $email, $password, $estado)
    {
        $data = $this->database->update($this->table,[
            'nombres' => $nombres, 
            'apellidos' => $apellidos, 
            'email' => $email, 
            'password' => MD5($password), 
            'estado' => $estado
        ], ['id' => $id]);

        if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
        {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        }
        else
        {
            if($data && count($data) > 0)
            {
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "Datos actualizados con éxito..!!";
            }
        }
        return $this->rt;
    }







}


