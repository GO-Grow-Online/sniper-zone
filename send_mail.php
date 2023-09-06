<?php

require_once 'assets/PHPMailer-master/src/Exception.php';
require_once 'assets/PHPMailer-master/src/PHPMailer.php';
require_once 'assets/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Vérification du formulaire soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['video'])) {

        // Define variables
        $response = array();
        $video = $_FILES['video'];
        $video_ID = uniqid();
        $videoPath = 'recorded_videos/' . $video_ID . '_'  . $video['name'];

        $customerEmail = $_POST['customer_email'];
        $sendingDate = date('Y-m-d H:i');

        if (isset($_FILES['image'])) {
            $group_pic = $_FILES['image'];
        }


        // Save file locally
        move_uploaded_file($video['tmp_name'], $videoPath);

        // Create an entry in database to keep a sorted record of each video associated with date and associated email
        // Connect to database
        $conn = new mysqli('localhost', 'Sniper Zone', 'sniper-zone');

        if ($conn->connect_error) {
            $response['error'] = 'La connexion à la base de données a échoué : ' . $conn->connect_error;
        }else {
            
            if ($conn->select_db("recorded_videos")) {
                $sql_video_ID = mysqli_real_escape_string($conn, $video_ID);
                $sql_customerEmail = mysqli_real_escape_string($conn, $customerEmail);
                $sql_videoPath = mysqli_real_escape_string($conn, $videoPath);
                $sql_sendingDate = mysqli_real_escape_string($conn, $sendingDate);

                $insertQuery = "INSERT INTO videos (ID, customer_email, video_path, sending_date) VALUES (?, ?, ?, ?)";
                
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param('ssss', $sql_video_ID, $sql_customerEmail, $sql_videoPath, $sql_sendingDate);
                
                if ($stmt->execute()) {
                    $response['success'] = true;
                } else {
                    $response['error'] = 'Erreur lors de l\'insertion dans la base de données : ' . $stmt->error;
                }
                
                // Fermez la connexion à la base de données
                $stmt->close();
                $conn->close();
            }else{
                $response['error'] = 'Impossible de rentrer dans la DB : ' . $conn->connect_error;
            }
        }

        
        $mail = new PHPMailer();

        // Send the email
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
            $mail->Subject = 'Video';
            $mail->Body = $_POST['message'];
            
            $mail->addAttachment($video['tmp_name'], $video['name']);
            
            if(isset($group_pic)) {
                $mail->addAttachment($group_pic['tmp_name'], $group_pic['name']);
            }

            if ($mail->send()) {
                $response['succes'] =  true;
            } else {
                $response['succes'] =  false;
                $response['error'] =  $mail->ErrorInfo;
            }
        } catch (Exception $error) {
            $response['succes'] =  false;
            $response['error'] =  'Erreur lors de l\'envoi de l\'e-mail : ' . $error->getMessage();
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

?>
