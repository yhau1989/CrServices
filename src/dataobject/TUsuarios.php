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



    public function getUsuarios()
    {
        $this->setResult();
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
            } else {
                $this->rt['error'] = 1;
                $this->rt['mensaje'] = 'No existen usuarios';
            }
        }
        return $this->rt;
    }

    public function getUsuariosById($id)
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
            } else {
                $this->rt['error'] = 1;
                $this->rt['mensaje'] = 'Usuario no existe';
            }
        }
        return $this->rt;
    }

    public function getUsuariosByEmail($email)
    {
        $this->setResult();
        $data = $this->database->select($this->table,'*', ['email'=>$email],1);
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
            else
            {
                $this->rt['error'] = 1;
                $this->rt['mensaje'] = 'Usuario no existe';  
            }
        }
        return $this->rt;
    }


    public function insertUsuario($nombres, $apellidos, $email, $password, $estado)
    {
        $this->setResult();
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
            $this->rt['error'] = 0;
            $this->rt['mensaje'] = "Datos grabados con éxito..!!";
            $this->rt['data'] =   $this->database->id();   
        }
        return $this->rt;
    }

    public function updateUsuario($id, $nombres, $apellidos, $email, $password, $estado)
    {
        $this->setResult();
        $verifica = $this->getUsuariosById($id);

        if($verifica['error'] == 0)
        {
            $pass = ($verifica['data'][0]['password'] === MD5($password)) ? $verifica['data'][0]['password'] : MD5($password);

            $data = $this->database->update($this->table,[
            'nombres' => $nombres, 
            'apellidos' => $apellidos, 
            'email' => $email, 
            'password' => $pass, 
            'estado' => $estado], ['id' => $id]);

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
        else
        {
            $this->rt['error'] = 1;
            $this->rt['mensaje'] = "No existe id de usuario";
        }
                
        return $this->rt;
    }




    public function login($email, $password)
    {
        $this->setResult();
        $data = $this->database->select($this->table,'*', ['email'=>$email, 'password'=> MD5($password), 'estado' => 1, 'admin' => 0]);
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
                $this->rt['mensaje'] = 'ok';   
            }
            else
            {
                $this->rt['error'] = 1;
                $this->rt['mensaje'] = 'Usuario o clave incorrectos'; 
            }
        }
        return $this->rt;
    }


    public function InsertResetPassword($email)
    {
        $this->setResult();
        $existe = $this->getUsuariosByEmail($email);

        if($existe['error'] == 0)
        {
            $token = md5($email . getdate()[0]);
            $this->database->insert('tokenpassword', ['token' => $token, 'email' => $email]);

            if (count($this->database->error()) > 0 && isset($this->database->error()[1])) {
                $this->rt['error'] = $this->database->error()[1];
                $this->rt['mensaje'] = $this->database->error()[2];
            } else {
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "Datos grabados con éxito..!!";
                $this->rt['data'] = $token;
            }
        }
        else
        {
            $this->rt['error'] = 1;
            $this->rt['mensaje'] = "Email no existe";
        }

        return $this->rt;
    }



    private function getTokenResetPassword($id)
    {
        $this->setResult();
        $data = $this->database->select('tokenpassword','*', ['id'=>$id], 1);
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
            else
            {
                $this->rt['error'] = 1;
                $this->rt['mensaje'] = 'Usuario o clave incorrectos'; 
            }
        }
        return $this->rt;
    }

}


