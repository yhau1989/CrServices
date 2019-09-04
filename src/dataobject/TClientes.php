<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/glob.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/vendor/autoload.php");
use Medoo\Medoo;


class TClientes
{
    private $rt;
    private $database;
    private $table = 'cliente';
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

        $this->setResult();
    }

    public function setResult(){
        $this->rt = array(
            'error'=> 0,
            'mensaje' => null,
            'data' => null
        );
    }

    public function getClientes()
    {
        $this->setResult();
        $data = $this->database->select($this->table,'*', ['estado' => 1]);
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

    public function getClientesMant()
    {
        $this->setResult();
        $data = $this->database->select($this->table, '*');
        if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        } else {
            if ($data && count($data) > 0) {
                $this->rt['error'] = 0;
                $this->rt['data'] = $data;
            }
        }
        return $this->rt;
    }

    public function getClientesById($id)
    {
        $this->setResult();
        $data = $this->database->select($this->table,'*', ['id'=>$id, 'estado' => 1]);
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

    public function getClientesByRuc($ruc)
    {
        $this->setResult();
        $data = $this->database->select($this->table,'*', ['ruc'=>$ruc, 'estado'=>1]);
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

   
    public function insertCliente($ruc, $nombres, $apellidos, $direccion, $telefono, $estado)
    {
        $this->setResult();
        $this->database->insert($this->table,[
            'ruc' => $ruc, 
            'nombres' => $nombres, 
            'apellidos' => $apellidos, 
            'direccion' => $direccion, 
            'telefono' => $telefono,
            'estado' => $estado
        ]);

        if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
        {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        }
        else
        {
            $this->rt['error'] = 0;
            $this->rt['mensaje'] = "Datos grabados con éxito..!!";
        }
        return $this->rt;
    }

    public function updateCliente($id, $ruc, $nombres, $apellidos, $direccion, $telefono, $estado)
    {
        $this->setResult();
        $this->database->update($this->table,[
            'ruc' => $ruc, 
            'nombres' => $nombres, 
            'apellidos' => $apellidos, 
            'direccion' => $direccion, 
            'telefono' => $telefono,
            'estado' => $estado
        ], ['id' => $id]);

        if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
        {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        }
        else
        {
            $this->rt['error'] = 0;
            $this->rt['mensaje'] = "Datos actualizados con éxito..!!";
        }
        return $this->rt;
    }







}


