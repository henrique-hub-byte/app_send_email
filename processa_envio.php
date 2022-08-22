<?php
require "./bibliotecas/PHPMailer/Exception.php";
/* require "./bibliotecas/PHPMailer/OAuth.php"; */
require "./bibliotecas/PHPMailer/OAuthTokenProvider.php";
require "./bibliotecas/PHPMailer/PHPMailer.php";
require "./bibliotecas/PHPMailer/POP3.php";
require "./bibliotecas/PHPMailer/SMTP.php";
/* print_r($_POST); */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mensagem
{
    private $para = null;
    private $assunto = null;
    private $mensagem = null;

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function mensagemValida()
    {
        if (!empty($this->para) || !empty($assunto) || !empty($mensagem)) {
            return true;
        } else {
            return false;
        }
    }
}


$mensagem = new Mensagem();
$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

if (!$mensagem->mensagemValida()) {
    echo "mensagem não é valida";
    die();
}

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'luis75henrique75@gmail.com';                     //SMTP username
    $mail->Password   = 'ninguem sabera';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('luis75henrique75@gmail.com', 'Web completo remetente');
    $mail->addAddress('luis.bonfim@meisters.solutions', 'web completo destinatario');     //Add a recipient
    //$mail->addAddress('luis.bonfim@meisters.solutions');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'OI eu sou um assunto';
    $mail->Body    = 'oi. eu sou o coneuto do <strong> e-mail!</strong>';
    $mail->AltBody = 'oi eu sou o conteudo do e-mail';

    $mail->send();
    echo 'Não foi possivel  este e-mail! tente mais tarde';
} catch (Exception $e) {
    echo "Detalhes do erro: {$mail->ErrorInfo}";
}
