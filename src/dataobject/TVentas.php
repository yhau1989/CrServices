<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/glob.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/vendor/autoload.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/src/dataobject/TStock.php");


use Medoo\Medoo;


class TVentas
{
    private $rt;
    private $database;
    private $table = 'ventas';
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

        setResult();
    }

    public function setResult()
    {
        $this->rt = array(
            'error'=> 0,
            'mensaje' => null,
            'data' => null
        );
    }

    public function getVentas()
    {
        setResult();
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

    public function getVentasByVendedor($vendedor)
    {
        setResult();
        $data = $this->database->select($this->table,'*', ['usuario_vendedor'=>$vendedor]);
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

    public function getVentasByMaterial($tipo_material)
    {
        setResult();
        $data = $this->database->select($this->table,'*', ['tipo_material'=>$tipo_material]);
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

   
    public function insertVenta($usuario_vendedor, $tipo_material, $peso, $valor, $fecha_venta)
    {
        setResult();
       $stock = new TStocks();
       $movimiento = $stock->updateStocks($tipo_material, $peso, 'resta'); //movimiento de stock

       if($movimiento['error'] == 0)
       {
            if($lote['error'] == 0)
            {
                $this->database->insert($this->table,[
                    'usuario_vendedor' => $usuario_vendedor, 
                    'tipo_material' => $tipo_material, 
                    'peso' => $peso, 
                    'valor' => $valor, 
                    'fecha_venta' => $fecha_venta
                ]);
        
                if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
                {
                    $movimiento = $stock->updateStocks($tipo_material, $peso, 'suma'); //RollBack
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
       }
       else
       {
            $this->rt = $movimiento;
       }

        return $this->rt;
    }


}


