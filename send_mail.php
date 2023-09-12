<?php
require 'mail_content.php';

require_once 'assets/PHPMailer-master/src/Exception.php';
require_once 'assets/PHPMailer-master/src/PHPMailer.php';
require_once 'assets/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Vérification du formulaire soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['video'])) {

        $response = "";

        // Define variables
        $client_ID = uniqid();

        $video = $_FILES['video'];
        $videoPath = 'videos/' . $client_ID . '_'  . $video['name'];

        $customerEmail = $_POST['customer_email'];
        $customer_lang = $_POST['lang'];
        $sendingDate = date('Y-m-d H:i');

        if (isset($_FILES['image'])) {
            $picture = $_FILES['image'];
            $picturePath = 'pictures/' . $client_ID . '_'  . $picture['name'];
        }




        // Send the email
        $mail = new PHPMailer();

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPSecure = 'ssl'; 
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->Username = 'julien.growonline@gmail.com';
            $mail->Password = 'dbiqnrvmmsqcrira';
            $mail->isHTML(true);

            // Sender & receiver
            $mail->setFrom('julien.growonline@gmail.com', 'Sniper zone');
            $mail->addAddress($customerEmail, 'Client');

            // Mail content
            $mail->Subject = $mail_subject[$customer_lang];
            $mail->Body = $mail_message[$customer_lang];
            
            // $mail->addAttachment($video['tmp_name'], $video['name']);
            
            if(isset($picture)) {
                $mail->addAttachment($picture['tmp_name'], $picture['name']);
            }

            if ($mail->send()) {
                $response .=  "Le mail à bien été envoyé.";
                $sendingSuccess = true;
            } else {
                // $response .=  $mail->ErrorInfo;
                $response .=  "L'nvois du mail à échoué. Connection internet indisponible.";
                $sendingSuccess = false;
            }


        } catch (Exception $error) {
            $response =  "Erreur lors de l'envoi de l'e-mail : " . $error->getMessage();
        }

            



        // Save file locally
        move_uploaded_file($video['tmp_name'], $videoPath);
        if (isset($picture)) {
            move_uploaded_file($picture['tmp_name'], $picturePath);
        }

        // Create an entry in database to keep a sorted record of each video associated with date and associated email
        // Connect to database
        $conn = new mysqli('localhost', 'Sniper Zone', 'sniper-zone');

        if ($conn->connect_error) {
            $response .= 'La connexion à la base de données a échoué : ' . $conn->connect_error;
        }else {
            if ($conn->select_db("sniper_zone")) {
                $sql_video_ID = mysqli_real_escape_string($conn, $client_ID);
                $sql_customerEmail = mysqli_real_escape_string($conn, $customerEmail);
                $sql_videoPath = mysqli_real_escape_string($conn, $videoPath);
                $sql_picturePath = isset($picturePath) ? mysqli_real_escape_string($conn, $picturePath) : "";
                $sql_sendingDate = mysqli_real_escape_string($conn, $sendingDate);
                $sql_lang = $_POST['lang'];

                $insertQuery = "INSERT INTO customers (ID, lang, customer_email, video_path, picture_path, sending_date, sending_success) VALUES (?, ?, ?, ?, ?, ?, ?)";
                
                $stmt = $conn->prepare($insertQuery);
                if (!$stmt) { die("Erreur de préparation de la requête : " . $conn->error); }                
                $stmt->bind_param('ssssssi', $sql_video_ID, $sql_lang, $sql_customerEmail, $sql_videoPath, $sql_picturePath, $sql_sendingDate, $sendingSuccess);
                
                if ($stmt->execute()) {
                    $response .= 'Enregistrement du client et des médias réussit.';
                } else {
                    $response .= "Erreur lors de l'insertion dans la base de données : " . $stmt->error;
                }
                
                // Fermez la connexion à la base de données
                $stmt->close();
                $conn->close();
            }else{
                $response = 'Impossible de rentrer dans la DB : ' . $conn->connect_error;
            }
        }

        echo $response;

    }
}

?>
