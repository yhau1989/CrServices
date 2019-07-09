<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/glob.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/vendor/autoload.php");
use Medoo\Medoo;


class TMateriales
{
    private $rt;
    private $database;
    private $table = 'tipomateriales';
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



    public function getMateriales()
    {
        $data = $this->database->select($this->table,'*');
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

    public function getMaterialesById($id)
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

       
    public function insertMaterial($tipo)
    {
        $this->database->insert($this->table,['tipo' => $tipo]);

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

    public function updateMaterial($id, $tipo)
    {
        $this->database->update($this->table,['tipo' => $tipo], ['id' => $id]);

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


