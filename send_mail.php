<?php

require_once 'assets/PHPMailer-master/src/Exception.php';
require_once 'assets/PHPMailer-master/src/PHPMailer.php';
require_once 'assets/PHPMailer-master/src/SMTP.php';

// Vérification du formulaire soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $data = array();
    $response = array();

    /*
    // Get every fields values
    foreach ($_POST as $name => $value) {
        $data[$name] = $value;
    }
    */


    /*
    // Add custom HTML template for mail and replace "{ field key }" with the form values
    $body = file_get_contents('assets/mail-tpl.html');

    if(isset($data)){
        foreach($data as $key => $value){
            $body = str_replace('{'.strtoupper($key).'}', $value, $body);
        }
    }*/

    $mail = new PHPMailer\PHPMailer\PHPMailer();

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

    if ($mail->send()) {
        $response['success'] = true;
    } else {
        $response['error'] =  $mail->ErrorInfo;
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>
