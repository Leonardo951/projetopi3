<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
// ini_set('smtp_port', 587);
require_once '../conexao.php';
require_once("../class/class.phpmailer.php");
require_once("../class/class.smtp.php");

$mail = new PHPMailer;
$mail->IsSMTP();

$email = $_POST['email'];
$codigo = base64_encode($email);
$expirar = base64_encode(date("Y-m-d H:i:s", strtotime('+1 day')));

$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$meuemail = 'suporte.cables@gmail.com';
$minhasenha = 'Senac9090';
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $PDO = $conex;
    $sql = "SELECT nome, email FROM tb_usuario WHERE email = :email";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $usuario = $user['nome'];
    $count = $stmt->rowCount();
    if ($count > 0) {
        try {
            $mail->Host = 'smtp.gmail.com'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
            $mail->SMTPAuth = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
            $mail->Port = 587; //  Usar 587 porta SMTP 465
            $mail->SMTPSecure = 'TSL';
            $mail->Username = 'suporte.cables@gmail.com'; // Usuário do servidor SMTP (endereço de email)
            $mail->Password = 'Senac9090'; // Senha do servidor SMTP (senha do email usado)

            //Define o remetente
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $mail->SetFrom($meuemail, 'CABLES'); //Seu e-mail
            $mail->AddReplyTo($meuemail, 'CABLES'); //Seu e-mail
            $mail->Subject = 'CABLES: Recuperação de senha';//Assunto do e-mail
            $mail->SetLanguage("br");

            //Define os destinatário(s)
            //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $mail->AddAddress($email, $user['nome']);

            //Define o corpo do email
            $mail->MsgHTML('<h6>Prezado(a) ' . $usuario . ',</h6><br>
                    <p>Recebemos uma solicitação para redefinição de senha vinda de você.</p><br>
                    <p>Para definir sua nova senha, clique <b><a href="recuperar-senha.php?=id=' . $codigo . '&page=' . $expirar . '">AQUI</a>.</p></b><br>
                    <p>Este é um e-mail automático. Não é necessário respondê-lo.</p><br>
                    <p><b>Obs.:</b>Caso você não tenha realizado esta ação, redefina sua senha imediatamente ou entre em contato com o administrador.</p><br>
                    <br><p>Atenciosamente,</p><br>
                    <p><b>CABLES Informática</b></p>');
            $mail->Send();
            echo $mail;
            echo 'deu certo!';
//            $_SESSION['recuper'] = 'Enviamos um e-mail para você.';
//            header('location: relembre-me.php');
        }
            //caso apresente algum erro é apresentado abaixo com essa exceção.
        catch (phpmailerException $e) {
            $_SESSION['recuper'] = $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer;
            header('Location: relembre-me.php');
        }
    }
}
