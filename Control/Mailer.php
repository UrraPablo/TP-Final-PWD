<?php
//include_once '../configuracion.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function


//include_once '../vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader

//Create an instance; passing `true` enables exceptions

class Mailer{
    private $mail;
    private $nomberDestinatario;
    private $mailDestinatario;
    
    public function __construct($name,$mail){
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet='utf-8';
        $this->mail->isHTML(true);                                  //Set email format to HTML
        //$this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   ='pablourra2016@gmail.com' ;//'franinsua7@gmail.com';                     //SMTP username
        $this->mail->Password   = 'fseoslwslwbmuzfy';//'nwtrbloritlhvkxq';                               //SMTP password
        $this->mail->SMTPSecure = 'ssl';            // tls  Enable implicit TLS encryption
        $this->mail->Port       = 465;     
        $this->nomberDestinatario=$name;
        $this->mailDestinatario=$mail;                               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $this->mail->setFrom('pablourra2016@gmail.com', 'JP WEB DESIGN');
        
    }// fin constructor 

    public function getNombre(){
        return $this->nomberDestinatario;
    }
    public function getMail(){
        return $this->mailDestinatario;
    }


    public function mandarMail($idCompra){
        $objCE = new AbmCompraEstado();
        $asunto='';
        $body='';
        $ultimoCE=$objCE->buscar(['idcompra'=>$idCompra,'cefechafin'=>'null'])[0];
        var_dump($ultimoCE);
        if($ultimoCE!=null){
            $idCET = $ultimoCE->getObjCompraEstadoTipo()->getId();
            switch($idCET){
                case 1:
                    $asunto = 'Compra iniciada';
                    $body='Gracias '.$this->getNombre().' . Registramos su compra correctamente. Espere la confirmacion de envio';
                    break;
                case 2:
                    $asunto='Confirmacion de pago';
                    $body=' EL pago de la compra ID: '.$idCompra.', se realizó exitosamente';
                    break;
                case 3: 
                    $asunto='Su compra esta en camino';
                    $body='Su compra ID: '.$idCompra.'  fue enviada. Verifique si algunos productos fueron cancelados por 
                    problemas de stock';
                    break;
                case 4:
                    $asunto='cancelacion de compra - productos';
                    $body='Se realizó la cancelacion de la compra o de algunos productos. Dirigase a la aplicación para mas detalle';
                    break;
                case 5: 
                    $asunto='Entrega de Compra';
                    $body='Ya recibimos la confirmacion de entrega de su compra. Gracias por confiar en nosotros !!';
                    break;
                default:
                $asunto='Upss al salio mal';
                $body='Se produjo un erro al procesar los estados de su compra, pronto lo solucionaremos';
                break;                    

            }// fin switch

        }// fin if 
        $this->mail->addAddress($this->getMail(),$this->getNombre());
        //Content
        $this->mail->Subject = $asunto;
        $this->mail->Body    = $body;
        
        try{
            $this->mail->send();
           // return $salida;
        }
        catch (Exception $e){
            //return $e;

        }
    }// fin function 



}// fin class