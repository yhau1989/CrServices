<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/glob.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/vendor/autoload.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/src/dataobject/TLotes.php");
use Medoo\Medoo;


class TOrdenTrabajo
{
    private $rt;
    private $database;
    private $table = 'ordentrabajo';
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

    public function getODTs()
    {
        $this->setResult();
        $data = $this->database->select('ordentrabajo(odt)',
        [
            '[><]tipomateriales(mat)' => ['odt.tipo_material' => 'id'],
            '[>]usuario(usr)' => ['odt.usuario_selecciona' => 'id'],
            '[>]usuario(usrt)' => ['odt.usuario_tritura' => 'id'],
            '[>]usuario(usra)' => ['odt.usuario_almacena' => 'id'],
        ],
        [
            'odt.orden_id', 'mat.tipo(tipo_material)', 'odt.peso_total'
            ,'user_selecciona' => Medoo::raw("CONCAT(usr.nombres,' ', usr.apellidos)"),'odt.fecha_ini_selecciona', 'odt.fecha_fin_selecciona'
            ,'odt.proceso_trituracion', 'user_tritura' => Medoo::raw("CONCAT(usrt.nombres,' ', usrt.apellidos)"), 'odt.fecha_ini_tritura', 'odt.fecha_fin_tritura'
            ,'odt.proceso_almacena', 'user_almacena' => Medoo::raw("CONCAT(usra.nombres,' ', usra.apellidos)"), 'odt.fecha_ini_almacena', 'odt.fecha_fin_almacena'
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
                $this->rt['data'] = $data;   
            }
        }
        return $this->rt;
    }

    public function getODTReportes()
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

    public function getODTById($idOdt)
    {
        $this->setResult();
        $data = $this->database->select($this->table, '*', ['orden_id' => $idOdt]);

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

    
    public function getODTByPendingTriturar()
    {
        $this->setResult();
        $data = $this->database->select(
            'ordentrabajo(odt)',
            [
                '[><]tipomateriales(mat)' => ['odt.tipo_material' => 'id'],
                '[>]usuario(usr)' => ['odt.usuario_selecciona' => 'id'],
                '[>]usuario(usrt)' => ['odt.usuario_tritura' => 'id'],
                '[>]usuario(usra)' => ['odt.usuario_almacena' => 'id'],
            ],
            [
                'odt.orden_id', 'mat.tipo(tipo_material)', 'odt.peso_total', 
                'user_selecciona' => Medoo::raw("CONCAT(usr.nombres,' ', usr.apellidos)"), 
                'odt.fecha_ini_selecciona', 'odt.fecha_fin_selecciona', 'odt.proceso_trituracion', 
                'user_tritura' => Medoo::raw("CONCAT(usrt.nombres,' ', usrt.apellidos)"), 
                'odt.fecha_ini_tritura', 'odt.fecha_fin_tritura', 'odt.proceso_almacena', 
                'user_almacena' => Medoo::raw("CONCAT(usra.nombres,' ', usra.apellidos)"), 'odt.fecha_ini_almacena', 'odt.fecha_fin_almacena'
            ],
            ['AND' => [
                'odt.proceso_trituracion' => 0,
                'odt.proceso_almacena' => 0
            ]]
        );
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

    public function getODTByPendingAlmacenar()
    {
        $this->setResult();
        $data = $this->database->select(
            'ordentrabajo(odt)',
            [
                '[><]tipomateriales(mat)' => ['odt.tipo_material' => 'id'],
                '[>]usuario(usr)' => ['odt.usuario_selecciona' => 'id'],
                '[>]usuario(usrt)' => ['odt.usuario_tritura' => 'id'],
                '[>]usuario(usra)' => ['odt.usuario_almacena' => 'id'],
            ],
            [
                'odt.orden_id', 'mat.tipo(tipo_material)', 'odt.peso_total',
                'user_selecciona' => Medoo::raw("CONCAT(usr.nombres,' ', usr.apellidos)"),
                'odt.fecha_ini_selecciona', 'odt.fecha_fin_selecciona', 'odt.proceso_trituracion',
                'user_tritura' => Medoo::raw("CONCAT(usrt.nombres,' ', usrt.apellidos)"),
                'odt.fecha_ini_tritura', 'odt.fecha_fin_tritura', 'odt.proceso_almacena',
                'user_almacena' => Medoo::raw("CONCAT(usra.nombres,' ', usra.apellidos)"), 'odt.fecha_ini_almacena', 'odt.fecha_fin_almacena'
            ],
            ['AND' => [
                'odt.proceso_trituracion' => 1,
                'odt.proceso_almacena' => 0
            ]]
        );
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


    public function updateOdtTrituracion($idOdt, $usuarioProcess, $fechaIniProcess, $fechaFinProcess)
    {
        $this->setResult();
        $this->database->update($this->table,[
            'proceso_trituracion' => 1,
            'usuario_tritura' => $usuarioProcess,
            'fecha_ini_tritura' => $fechaIniProcess,
            'fecha_fin_tritura' => $fechaFinProcess
        ], ['orden_id' => $idOdt]);

        if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
        {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        }
        else
        {
            $this->updateLotesTritura($idOdt, $usuarioProcess, $fechaIniProcess, $fechaFinProcess);
            $this->rt['error'] = 0;
            $this->rt['mensaje'] = "Datos actualizados con éxito..!!";
            
        }
        return $this->rt;
    }


    function updateLotesTritura($odt, $usuarioProcess, $fechaIniProcess, $fechaFinProcess)
    {
        $this->setResult();
        $data = $this->database->select('ordentrabajolotes', 'id_lote', ['id_orden_trabajo' => $odt]);

        if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        } else {

           
            if ($data && count($data) > 0) {
                $lotes = new TLotes();
                foreach ($data as $clave => $valor) {
                    $lotes->updateLoteSetProcessProceso($valor, $usuarioProcess, $fechaIniProcess, $fechaFinProcess);
                }
                $this->rt['error'] = 0;
                $this->rt['data'] = null;
            }
        }
        return $this->rt;
    }


    function updateLotesAlmacena($odt, $usuarioProcess, $fechaIniProcess, $fechaFinProcess)
    {
        $this->setResult();
        $data = $this->database->select('ordentrabajolotes', 'id_lote', ['id_orden_trabajo' => $odt]);

        if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        } else {

            if ($data && count($data) > 0) {
                $lotes = new TLotes();
                foreach ($data as $clave => $valor) {
                    $lotes->updateLoteSetProcessAlmacena($valor, $usuarioProcess, $fechaIniProcess, $fechaFinProcess);
                }
                $this->rt['error'] = 0;
                $this->rt['data'] = null;
            }
        }
        return $this->rt;
    }







    public function updateODTSetProcessAlmacena($odt, $material, $peso , $usuarioProcess, $fechaIniProcess, $fechaFinProcess, $faltante)
    {
        $this->setResult();
        //$material = $this->getODTById($odt); //obtener el tipo de material
        $movimiento = array('error'=> -256,'mensaje' => null,'data' => null); 


        $stock = new TStocks();
        $movimiento = $stock->updateStocks($material, $peso, 'suma'); //movimiento de stock

        if($movimiento['error'] == 0)
        {
            $this->database->update($this->table,[
                'proceso_almacena' => 1,
                'usuario_almacena' => $usuarioProcess,
                'fecha_ini_almacena' => $fechaIniProcess,
                'fecha_fin_almacena' => $fechaFinProcess,
                'faltante' => $faltante
            ], ['orden_id' => $odt]);
    
            if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
            {
                $movimiento = $stock->updateStocks($material, $peso, 'resta'); //RollBack
                $this->rt['error'] = $this->database->error()[1];
                $this->rt['mensaje'] = $this->database->error()[2];
            }
            else
            {
                $this->updateLotesAlmacena($odt, $usuarioProcess, $fechaIniProcess, $fechaFinProcess);
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "Datos actualizados con éxito..!!";
            }    
        }
        else
        {
            $this->rt = $movimiento;
        }
       

        return $this->rt;

    }





    public function insertODT($material, $peso, $usuarioSelecciona, $fecIniSeleccion, $fecFinSeleccion, $lotes)
    {
        $this->setResult();
        $this->database->insert($this->table, [
            'tipo_material' => $material,
            'peso_total' => $peso,
            'usuario_selecciona' => $usuarioSelecciona,
            'fecha_ini_selecciona' => $fecIniSeleccion,
            'fecha_fin_selecciona' => $fecFinSeleccion,
        ]);

        if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        } else {

            $idOdt = $this->database->id();
            $resukl = $this->insertODTLotes($idOdt,$lotes, $usuarioSelecciona, $fecIniSeleccion, $fecFinSeleccion);
            if($resukl ['error'] == 0)
            {
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "Datos grabados con éxito, Id de ODT generada: " . $idOdt;
                $this->rt['data'] =  $idOdt;
            }
            else
            {
                $this->database->delete($this->table,  ["AND" => ["orden_id" => $idOdt]]);
                $this->rt = $resukl;
            }
        }
        return $this->rt;
    }


    public function insertODTLotes($idOtd, $lotes, $usuarioProceso, $incio, $fin )
    {
        $items = null; 
        foreach($lotes as $clave => $valor)
        {
            $items[$clave] = array('id_orden_trabajo'=> $idOtd,'id_lote' => $valor,);
        }

        $this->setResult();
        if(count($items) > 0)
        {

            $this->database->insert('ordentrabajolotes', $items);
            if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
                $this->rt['error'] = $this->database->error()[1];
                $this->rt['mensaje'] = $this->database->error()[2];
            } else {

                //Actualizar el proceso de seleccion del lote 
                foreach ($lotes as $clave => $valor) {
                    $tlotes = new TLotes();
                    $tlotes->updateLoteSetProcessSeleccion($valor, $usuarioProceso, $incio, $fin);
                }

                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "Datos grabados con éxito..!!";
                $this->rt['data'] =   null;
            }
        }
        else{
                $this->rt['error'] = 1;
                $this->rt['mensaje'] = "No se han encontrado lotes para esta ODT";
                $this->rt['data'] =   null;
        }
        return $this->rt;

    }






}


