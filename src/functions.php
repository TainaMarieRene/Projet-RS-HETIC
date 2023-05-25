<?php
// Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($user_id, $user_firstname, $user_lastname, $user_mail){
    require_once '../vendor/autoload.php';

    $email = new PHPMailer(true);
    $email->SMTPDebug = 0;
    $email->isSMTP();
    $email->Host = 'mail.gandi.net';
    $email->SMTPAuth = true;
    $email->Username = 'unilink@heitzjulien.com';
    $email->Password = '29i8v9JjvsTCunilink-gQwoLX';
    $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $email->Port = 587;
    $email->setFrom('unilink@heitzjulien.com', 'Unilink');
    $email->addAddress($user_mail, $user_firstname . ' ' . $user_lastname);
    $email->CharSet = 'UTF-8';

    $email->isHTML(true);
    $email->Subject = 'Bienvenue sur Unilink';
    $email->Body = "
    <html>
    <head>
        <title>Bienvenue sur Unilink</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                margin: 0;
                padding: 0;
            }
    
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }
    
            h1 {
                font-size: 24px;
                color: #333;
                margin-bottom: 20px;
            }
    
            p {
                font-size: 16px;
                color: #555;
            }
    
            a {
                display: inline-block;
                background-color: #3AE168;
                color: #050505;
                text-decoration: none;
                padding: 10px 20px;
                border-radius: 4px;
                margin-top: 10px;
            }
    
            img {
                max-width: 60px;
                margin-top: 5px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Merci $user_firstname pour votre inscription sur Unilink !</h1>
            <p>Nous sommes ravis de vous accueillir parmi nous.</p>
            <p>Veuillez cliquer sur le lien ci-dessous pour vérifier votre compte :</p>
            <a href='http://localhost/Projet-RS-Hetic/public/index.php?p=validateUser&type=valid&id=$user_id'>Vérifier mon compte</a>
            <p>Merci encore, et à bientôt sur Unilink !</p>
            <img src='https://www.hebergeur-image.com/upload/91.173.15.179-646f23ce3210c.png' alt='Logo Unilink'>
        </div>
    </body>
    </html>";
    $email->AltBody = "Merci pour votre inscription sur Unilink. Veuillez vérifier votre compte en cliquant sur le lien suivant : https://localhost/Projet-RS-Hetic/public/index.php?p=validateUser&type=valid&id=$user_id";
    $email->send();
}