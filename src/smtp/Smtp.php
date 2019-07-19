<?php

include($_SERVER["DOCUMENT_ROOT"] . "/CrServices/vendor/autoload.php");

use \Mailjet\Resources;


class Smtp
{
    private $apikey = 'b4111f606dd6968cb30667de9ac54519';
    private $apisecret = '8e8b210fa76cbfbbae7a4e95a0304b58';
    private $rt = "";


    public function __construct()
    {
        $this->setResult();
    }

    public function setResult()
    {
        $this->rt = array(
            'error' => 0,
            'mensaje' => null,
            'data' => null
        );
    }
   


    public function confirmarRegistro($nombre, $url, $email)
    {
        $this->setResult();

        try {
            $mj = new \Mailjet\Client($this->apikey, $this->apisecret, true, ['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "recyclinplant@gmail.com",
                            'Name' => "App Procefibras"
                        ],
                        'To' => [
                            [
                                'Email' => $email,
                                'Name' => $nombre
                            ]
                        ],
                        'TemplateID' => 913828,
                        'TemplateLanguage' => true,
                        'Subject' => "Confirmacion de registro App Procefibras",
                        'Variables' => json_decode('{"nombre":"' . $nombre . '","url": "' . $url . '"}', true)
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            //$response->success() && var_dump($response->getData());

            $response->success();
            $result = $response->getData();
            $pos = strpos(json_encode($result), "success");

            if ($pos === false) {
                $this->rt['error'] = 99;
                $this->rt['mensaje'] = "no se pudo enviar el correo.";
                $this->rt['data'] = $result; 
            } else {
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "correo enviado con éxito";
                $this->rt['data'] = $result; 
            }

        } catch (Exception $e) {
            $this->rt['error'] = 99;
            $this->rt['mensaje'] = $e->getMessage();
            
        }

        return  $this->rt;

    }


    public function recuperarPassword($url, $email)
    {
        $this->setResult();

        try {
            $mj = new \Mailjet\Client($this->apikey, $this->apisecret, true, ['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "recyclinplant@gmail.com",
                            'Name' => "App Procefibras"
                        ],
                        'To' => [
                            [
                                'Email' => $email,
                                'Name' => ""
                            ]
                        ],
                        'TemplateID' => 913852,
                        'TemplateLanguage' => true,
                        'Subject' => "Reestrablecimiento de contraseña App Procefibras",
                        'Variables' => json_decode('{"url": "' . $url . '"}', true)
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            //$response->success() && var_dump($response->getData());

            $response->success();
            $result = $response->getData();
            $pos = strpos(json_encode($result), "success");

            if ($pos === false) {
                $this->rt['error'] = 99;
                $this->rt['mensaje'] = "no se pudo enviar el correo.";
                $this->rt['data'] = $result;
            } else {
                $this->rt['error'] = 0;
                $this->rt['mensaje'] = "correo enviado con éxito";
                $this->rt['data'] = $result;
            }
        } catch (Exception $e) {
            $this->rt['error'] = 99;
            $this->rt['mensaje'] = $e->getMessage();
        }

        return  $this->rt;
    }



    public function test()
    {
        echo "test email";
    }


}