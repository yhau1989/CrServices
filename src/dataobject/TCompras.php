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

    public function getComprasList($fini=null, $ffin=null)
    {
        $this->setResult();
        $data = null;
        
        if((isset($fini) && isset($ffin)) && strlen($fini) > 0 && strlen($ffin) > 0 )
        {
            $data = $this->database->select($this->table, [
                "[><]usuario" => ["compras.usuario_compra" => "id"],
                "[><]proveedor" => ["compras.proveedor" => "id"]
            ],
            ['compras.id', 'proveedor.nombres(prov_nombre)', 'proveedor.apellidos(proc_apellidoo)', 'compras.lote', 'compras.fecha_compra',
            'usuario.nombres(usr_nombre)', 'usuario.apellidos(usr_apellido)'],
            ['compras.fecha_compra[<>]' => [$fini,$ffin]]
            );
        }
        else if (isset($fini) && isset($ffin) && strlen($fini) > 0 && strlen($ffin) == 0)
        {
            $data = $this->database->select($this->table, [
                "[><]usuario" => ["compras.usuario_compra" => "id"],
                "[><]proveedor" => ["compras.proveedor" => "id"]
            ],
            ['compras.id', 'proveedor.nombres(prov_nombre)', 'proveedor.apellidos(proc_apellidoo)', 'compras.lote', 'compras.fecha_compra',
            'usuario.nombres(usr_nombre)', 'usuario.apellidos(usr_apellido)'],
            ['compras.fecha_compra[>=]' => $fini]
            );
        }
        else if (isset($fini) && isset($ffin) && strlen($fini) == 0 && strlen($ffin) > 0)
        {
            $data = $this->database->select($this->table, [
                "[><]usuario" => ["compras.usuario_compra" => "id"],
                "[><]proveedor" => ["compras.proveedor" => "id"]
            ],
            ['compras.id', 'proveedor.nombres(prov_nombre)', 'proveedor.apellidos(proc_apellidoo)', 'compras.lote', 'compras.fecha_compra',
            'usuario.nombres(usr_nombre)', 'usuario.apellidos(usr_apellido)'],
            ['compras.fecha_compra[<=]' => $ffin]
            );
        }
        else
        {
            $data = $this->database->select($this->table, [
                "[><]usuario" => ["compras.usuario_compra" => "id"],
                "[><]proveedor" => ["compras.proveedor" => "id"]
            ],
            ['compras.id', 'proveedor.nombres(prov_nombre)', 'proveedor.apellidos(proc_apellidoo)', 'compras.lote', 'compras.fecha_compra',
            'usuario.nombres(usr_nombre)', 'usuario.apellidos(usr_apellido)']);
        }

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

   
    public function insertCompra($proveedor, $valor_total, $peso, $usuarioCompra, $items)
    {    
        $this->setResult();
        $this->database->insert($this->table,[
            'proveedor' => $proveedor, 
            'valor_total' => $valor_total,
            'peso_total' => $peso,
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
            $idCompra = $this->database->id();
            $prelotes = $this->insertPreLotes($idCompra, $items) ; //insertamos los lotes 

            if($prelotes['error'] == 0)
            {
                $detalleStatus = $this->insertCompraDetalles($idCompra, $items);
                if($detalleStatus['error'] == 0)
                {
                    $this->rt['error'] = 0;
                    $this->rt['mensaje'] = "Datos grabados con éxito, id de compra: " . $idCompra;
                    $this->rt['data'] =  null;
                }
                else
                {
                    $this->deletLotesByIdCompra($idCompra); //rollback lotes
                    $this->deleteCompraById($idCompra); //rollback compra
                    $this->rt =  $detalleStatus;
                }
            }
            else{
                $this->deleteCompraById($idCompra); //rollBack compra cabecera
                $this->rt = $prelotes;
            }
        }
        return $this->rt;
    }

    

    public function insertPreLotes($idCompra, $items)
    {
        foreach ($items as $key => $value) 
        {
            $this->setResult();
            $this->database->insert(
                'lotes',
                [
                    'id_compra' => $idCompra,
                    'material' => $value->material,
                    'peso' => $value->peso
                ]
            );

            if (count($this->database->error()) > 0 && isset($this->database->error()[1])) 
            {
                $errorStPreLote = $this->database->error()[1];
                $errorprelote = $this->database->error()[2];
                $this->deletLotesByIdCompra($idCompra); //rollBack Lotes

                $this->rt['error'] = $errorStPreLote;
                $this->rt['mensaje'] = $errorprelote;
                $this->rt['data'] =  null;

                break;
            } else {
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "Datos grabados con éxito..!!";
                $this->rt['data'] =  null;
            }
        }
        return $this->rt;
    }

    private function deletLotesByIdCompra($idCompra)
    {
        $this->setResult();
        $this->database->delete('lotes', array('id_compra' => $idCompra));

        if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        } else {
            $this->rt['error'] = 0;
            $this->rt['mensaje'] = "Datos eliminados con éxito..!!";
            $this->rt['data'] =  null;
        }
        return $this->rt;
    }


    public function deleteCompraById($idCompra)
    {
        $this->setResult();
        $this->database->delete($this->table, array('id' => $idCompra));

        if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        } else {
            $this->rt['error'] = 0;
            $this->rt['mensaje'] = "Datos eliminados con éxito..!!";
            $this->rt['data'] =  null;
        }

        return $this->rt;
    }



    public function insertCompraDetalles($idCompra, $items)
    {
        foreach ($items as $key => $value) {
            $this->setResult();
            $this->database->insert(
                'compradetalle',
                [
                    'id_compra' => $idCompra,
                    'id_material' => $value->material,
                    'peso' => $value->peso,
                    'valor' => $value->valor,
                    'iva' => $value->iva,
                    'valor_total' => $value->valor_total,
                ]
            );

            if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
                $errorDetalle = $this->database->error()[1];
                $errorDetalleMsg = $this->database->error()[2] ;
                $this->deletLotesByIdCompra($idCompra); //rollBack Lotes

                $this->rt['error'] = $errorDetalle;
                $this->rt['mensaje'] = $errorDetalleMsg;
                $this->rt['data'] =  null;

                break;
            } else {
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "Datos grabados con éxito..!!";
                $this->rt['data'] =  null;
            }
        }
        return $this->rt;
    }


    public function deleteDetalleCompraByIdCompra($idCompra)
    {
        $this->setResult();
        $this->database->delete('compradetalle', array('id_compra' => $idCompra));

        if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
            $this->rt['error'] = $this->database->error()[1];
            $this->rt['mensaje'] = $this->database->error()[2];
        } else {
            $this->rt['error'] = 0;
            $this->rt['mensaje'] = "Datos eliminados con éxito..!!";
            $this->rt['data'] =  null;
        }

        return $this->rt;
    }


    

}


