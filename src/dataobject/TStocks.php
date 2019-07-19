<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/glob.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/vendor/autoload.php");
use Medoo\Medoo;


class TStocks
{
    private $rt;
    private $database;
    private $table = 'stockmateriales';
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

    public function getStocks()
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

    public function getStocksById($id)
    {
        $this->setResult();
        $data = $this->database->select($this->table,'*', ['id_material'=>$id]);
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

       
    public function insertStock($idMaterial)
    {
        $this->setResult();
        $data = $this->database->insert($this->table,[
            'id_material' => $idMaterial
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


    public function updateStocks($idMaterial, $cantidad, $operacion)
    {
        //operacion puede ser "suma" o "resta"
        $this->setResult();
        $existe = $this->getStocksById($idMaterial);


        

        if($existe['error'] == 0 && count($existe['data']) > 0)
        {
            if($operacion === 'suma'){
                $stock = $existe['data'][0]['stock'] + $cantidad;

                $this->database->update($this->table,['stock' =>  $stock], ['id_material' => $idMaterial]);
    
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
            }
            else{
                $stock = $existe['data'][0]['stock'] - $cantidad ;
                if($stock < 0){
                    $this->rt['error'] = 2;
                    $this->rt['mensaje'] = "Error, el stock no puede quedar en negativo: (Stock actual ". $existe['data'][0]['stock'] .")";
                }
                else{
                    $this->database->update($this->table,['stock' =>  $stock], ['id_material' => $idMaterial]);
    
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
                }
            }
        }
        else
        {
            $this->rt['error'] = 2;
            $this->rt['mensaje'] = "No existe tipo de material para actualizar el stock";
        }
        
        return $this->rt;
    }

}


