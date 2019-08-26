<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/glob.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/vendor/autoload.php");
include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/src/dataobject/TStocks.php");


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

        $this->setResult();
    }

    public function setResult()
    {
        $this->rt = array(
            'error'=> 0,
            'mensaje' => null,
            'data' => null
        );
    }

    public function getVentas($fini=null, $ffin=null)
    {
        $this->setResult();
        $data = null;
        if((isset($fini) && isset($ffin)) && strlen($fini) > 0 && strlen($ffin) > 0 )
        {
            $data = $this->database->select(
                $this->table,
                ['[><]usuario' => ['ventas.usuario_vendedor' => 'id'],'[><]cliente' => ['ventas.cliente' => 'id']],
                ['ventas.id', 'usuario.nombres(nombre_vendedor)', 'usuario.apellidos(apellidos_vendedor)','cliente.ruc(ruc_cliente)', 'cliente.nombres(nombre_cliente)',
                'cliente.apellidos(apellido_cliente)', 'ventas.valor_total','ventas.fecha_venta' ],
                ['ventas.fecha_venta[<>]' => [$fini, $ffin]]
            );
        }
        else if (isset($fini) && isset($ffin) && strlen($fini) > 0 && strlen($ffin) == 0)
        {
            $data = $this->database->select(
                $this->table,
                ['[><]usuario' => ['ventas.usuario_vendedor' => 'id'],'[><]cliente' => ['ventas.cliente' => 'id']],
                ['ventas.id', 'usuario.nombres(nombre_vendedor)', 'usuario.apellidos(apellidos_vendedor)','cliente.ruc(ruc_cliente)', 'cliente.nombres(nombre_cliente)',
                'cliente.apellidos(apellido_cliente)', 'ventas.valor_total','ventas.fecha_venta' ],
                ['ventas.fecha_venta[>=]' => $fini]
            );
        }
        else if (isset($fini) && isset($ffin) && strlen($fini) == 0 && strlen($ffin) > 0)
        {
            $data = $this->database->select(
                $this->table,
                ['[><]usuario' => ['ventas.usuario_vendedor' => 'id'],'[><]cliente' => ['ventas.cliente' => 'id']],
                ['ventas.id', 'usuario.nombres(nombre_vendedor)', 'usuario.apellidos(apellidos_vendedor)','cliente.ruc(ruc_cliente)', 'cliente.nombres(nombre_cliente)',
                'cliente.apellidos(apellido_cliente)', 'ventas.valor_total','ventas.fecha_venta' ],
                ['ventas.fecha_venta[<=]' => $ffin]
            );
        }
        else
        {
            $data = $this->database->select(
                $this->table,
                ['[><]usuario' => ['ventas.usuario_vendedor' => 'id'],'[><]cliente' => ['ventas.cliente' => 'id']],
                ['ventas.id', 'usuario.nombres(nombre_vendedor)', 'usuario.apellidos(apellidos_vendedor)','cliente.ruc(ruc_cliente)', 'cliente.nombres(nombre_cliente)',
                'cliente.apellidos(apellido_cliente)', 'ventas.valor_total','ventas.fecha_venta' ]
            );
        }

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


    public function subtotales($detalle)
    {
        $iteValue = 0;

        foreach ($detalle as $item => $value) {
            $iteValue = $iteValue + $value['valor'];
        }

        $subtotales = array(
            'subtotal'=>  number_format((float)($iteValue), 2, '.', ''),
            'iva' => number_format((float)($iteValue * 0.12), 2, '.', ''),
            'neto' => number_format((float)($iteValue * 1.12), 2, '.', '')
        );

        return $subtotales;

    }

    public function getVentaDetalle($idVenta)
    {
        $this->setResult();
        $data = $this->database->select('ventadetalle','*', ['id_venta'=>$idVenta]);
        if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
        {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];

        }
        else
        {
            if($data && count($data) > 0)
            {

                $this->rt = array(
                    'error'=> 0,
                    'mensaje' => 'ok',
                    'data' => $data,
                    'subtotal' => $this->subtotales($data)
                );
            }
            else
            {
                $this->rt['error'] = 1;
                $this->rt['mensaje'] = 'No existen detalles de esta venta.';
            }
        }
        return $this->rt;
    }



    public function getVentasByVendedor($vendedor)
    {
        $this->setResult();
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
        $this->setResult();
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





   
    public function insertVenta($usuario_vendedor, $cliente, $valorTotal, $detalle)
    {
        $this->setResult();
        $this->database->insert($this->table,[
            'usuario_vendedor' => $usuario_vendedor, 
            'cliente' => $cliente, 
            'valor_total' => $valorTotal,
        ]);

        if(count($this->database->error()) > 0 && isset($this->database->error()[1]))
        {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        }
        else
        {
            $idVenta = $this->database->id();
            $error = 0;
            $limite = 0;
            foreach ($detalle as $item => $value) {
                $limite++;
                $det = $this->insertVentaDetalle($idVenta, $value->idmaterial, $value->descripcion, $value->peso, $value->precio, $value->iva, $value->valortotal);
                if($det['error'] != 0)
                {
                    $error = 1;
                    $this->deleteVentas($idVenta);
                    $this->rollbackStockVentas($detalle, $limite);
                    $this->rt = $det;
                    break;
                }
            }

            if($error == 0)
            {
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "Datos grabados con éxito..!!";
                $this->rt['data'] = "código de venta: #" . sprintf("%09d", $idVenta);

            }
        }
            
        return $this->rt;
    }



    public function insertVentaDetalle($idventa, $idMaterial, $descripcion, $peso, $valor, $iva, $valorTotal)
    {
        $this->setResult();
        $stock = new TStocks();
        $this->database->insert('ventadetalle', [
            'id_venta' => $idventa,
            'id_material' => $idMaterial,
            'descripcion' => $descripcion,
            'peso' => $peso,
            'valor' => $valor,
            'iva' => $iva,
            'valor_total' => $valorTotal
        ]);

        if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
            
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        } else {
            $movimiento = $stock->updateStocks($idMaterial, $peso, 'resta'); //RollBack
            if($movimiento['error'] == 0)
            {
                $this->rt = $movimiento;
            }
            else
            {
                $this->rt['error'] = $movimiento['error'];
                $this->rt['mensaje'] = $movimiento['mensaje'];
            }
        }
           
        return $this->rt;
    }


    public function deleteVentas($idVenta)
    {
        $this->setResult();
        $this->database->delete($this->table, ['AND' => ['id' => $idVenta]]);

        if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {

            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        } else {
        
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = 'Venta eliminada correctamente...!!';
        }

        return $this->rt;
    }


    public function rollbackStockVentas($items, $limite)
    {
        $limit = 0;
        $this->setResult();
        foreach ($items as $item => $value) {
            $limit++;
            if($limit < $limite)
            {
                $stock = new TStocks();
                $movimiento = $stock->updateStocks($value->material, $value->peso, 'suma'); //RollBack
                if ($movimiento['error'] == 0) {
                    $this->rt = $movimiento;
                } else {
                    $this->rt['error'] = 0;
                    $this->rt['mensaje'] = "ok";
                    $this->rt['data'] = null;
                }
            }
            else
            {
                break;
            }
        }

        return $this->rt;
    }


}


