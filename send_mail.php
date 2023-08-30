<?php

require_once 'assets/PHPMailer-master/src/Exception.php';
require_once 'assets/PHPMailer-master/src/PHPMailer.php';
require_once 'assets/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Vérification du formulaire soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['video'])) {
        $video = $_FILES['video'];
        $response = array();
        $mail = new PHPMailer();

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPSecure = 'ssl'; 
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->Username = 'julien.growonline@gmail.com';
            $mail->Password = 'dbiqnrvmmsqcrira';

            // Sender & receiver
            $mail->setFrom('julien.growonline@gmail.com', 'Sniper zone');
            $mail->addAddress('julien19991227@gmail.com', 'Client de Sniper zone');

            // Mail content
            $mail->Subject = 'Video';
            $mail->Body = 'message';
            
            $mail->addAttachment($video['tmp_name'], $video['name']);

            if ($mail->send()) {
                $response['success'] = true;
            } else {
                $response['error'] =  $mail->ErrorInfo;
            }
        } catch (Exception $error) {
            $response['error'] =  $error->getMessage();
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

?>
