<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/glob.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/vendor/autoload.php");
use Medoo\Medoo;


class TCompras
{
    private $rt;
    private $database;
    private $table = 'compras';
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

    public function getCompras()
    {
        $this->setResult();
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

    public function getComprasById($id)
    {
        $this->setResult();
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

    public function getComprasByRuc($ruc)
    {
        $this->setResult();
        $data = $this->database->select($this->table,'*', ['ruc'=>$ruc]);
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

   
    public function insertCompra($proveedor, $valor_total, $material, $peso, $usuarioCompra)
    {
        $this->setResult();
        $lote =  $this->insertPreLote($material, $peso);

        if($lote['error'] == 0)
        {
            $this->setResult();
            $this->database->insert($this->table,[
                'proveedor' => $proveedor, 
                'lote' => $lote['data'], 
                'valor_total' => $valor_total,
                'usuario_compra' => $usuarioCompra
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
        }
        else
        {
            $this->rt = $lote;
        }
        return $this->rt;
    }

    

    public function insertPreLote($material, $peso)
    {
        $this->setResult();
        $this->database->insert('lotes' ,[
            'material' => $material,
            'peso' => $peso
        ]);

        if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        } else {
            $this->rt['error'] = 0;
            $this->rt['mensaje'] = "Datos grabados con éxito..!!";
            $this->rt['data'] =   $this->database->id();
        }
        return $this->rt;
    }







}


