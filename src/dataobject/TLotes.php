<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/glob.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/vendor/autoload.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/src/dataobject/TStock.php");
use Medoo\Medoo;


class TLotes
{
    private $rt;
    private $database;
    private $table = 'lotes';
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

    public function setResult(){
        $this->rt = array(
            'error'=> 0,
            'mensaje' => null,
            'data' => null
        );
    }

    public function getLotes()
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

    public function getLotesById($id)
    {
        setResult();
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

    public function getLotesByPendingSeleccion()
    {
        setResult();
        $data = $this->database->select($this->table,'*', [
            'proceso_venta' => 1, 
            'proceso_selecciona'=> 0, 
            'proceso_procesar' => 0, 
            'proceso_almacenar' => 0]
        );
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

    public function getLotesByPendingProcesar()
    {
        setResult();
        $data = $this->database->select($this->table,'*', [
            'proceso_venta' => 1, 
            'proceso_selecciona'=> 1, 
            'proceso_procesar' => 0, 
            'proceso_almacenar' => 0]
        );
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

    public function getLotesByPendingAlmacenar()
    {
        setResult();
        $data = $this->database->select($this->table,'*', [
            'proceso_venta' => 1, 
            'proceso_selecciona'=> 1, 
            'proceso_procesar' => 1, 
            'proceso_almacenar' => 0]
        );
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




    public function updateLoteSetProcessSeleccion($lote, $usuarioProcess, $fechaIniProcess, $fechaFinProcess)
    {
        setResult();
        $this->database->update($this->table,[
            'proceso_selecciona' => 1,
            'usuario_selecciona' => $usuarioProcess,
            'fecha_ini_selecciona' => $fechaIniProcess,
            'fecha_fin_selecciona' => $fechaFinProcess
        ], ['lote' => $id]);

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

    public function updateLoteSetProcessProceso($lote, $usuarioProcess, $fechaIniProcess, $fechaFinProcess)
    {
        setResult();
        $this->database->update($this->table,[
            'proceso_procesar' => 1,
            'usuario_procesa' => $usuarioProcess,
            'fecha_ini_procesa' => $fechaIniProcess,
            'fecha_fin_procesa' => $fechaFinProcess
        ], ['lote' => $id]);

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


    public function updateLoteSetProcessAlmacena($lote, $usuarioProcess, $fechaIniProcess, $fechaFinProcess)
    {
        setResult();
        $material = getLotesById($lote); //obtener el tipo de material
        $movimiento = array('error'=> -256,'mensaje' => null,'data' => null); 

        if($material['error'] == 0 &&  count($material['data']) > 0){
            $stock = new TStocks();
            $movimiento = $stock->updateStocks($material['data']['material'], $material['data']['peso'], 'suma'); //movimiento de stock

            if($movimiento['error'] == 0)
            {
                $this->database->update($this->table,[
                    'proceso_almacenar' => 1,
                    'usuario_almacena' => $usuarioProcess,
                    'fecha_ini_almacena' => $fechaIniProcess,
                    'fecha_fin_almacena' => $fechaFinProcess
                ], ['lote' => $id]);
        
                if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
                {
                    $movimiento = $stock->updateStocks($tipo_material['data']['material'], $material['data']['peso'], 'resta'); //RollBack
                    $this->rt['error'] = $this->database->error()[1];
                    $this->rt['mensaje'] = $this->database->error()[2];
                }
                else
                {
                    $this->rt['error'] = 0;
                    $this->rt['mensaje'] = "Datos actualizados con éxito..!!";
                }    
            }
            else
            {
                $this->rt = $movimiento;
            }
        }
        else
        {
            $this->rt = $material;
        }

        return $this->rt;

        
    }









}


