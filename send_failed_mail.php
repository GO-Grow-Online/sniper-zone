<?php

require 'mail_content.php';

require_once 'assets/PHPMailer-master/src/Exception.php';
require_once 'assets/PHPMailer-master/src/PHPMailer.php';
require_once 'assets/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$servername = "localhost";
$username = "Sniper Zone";
$password = "sniper-zone";

$databaseName = "sniper_zone";
$tableName = "customers";

// Connection to DB
$conn = new mysqli($servername, $username, $password, $databaseName);

// Verify connection
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Execute query that select all videos from table
$selectQuery = "SELECT * FROM customers WHERE sending_success = 0";
$result = $conn->query($selectQuery);

$mail_count = $result->num_rows;

if ($result === false) {
    die("Erreur lors de la récupération des données : " . $conn->error);
}

$sended_mails = 0;
$failed_mails = 0;
// Display results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $customerID = $row['ID'];
        $customerEmail = $row['customer_email'];
        if (isset($row['picture_path'])) {
            $picture = $row['picture_path'];
        }

        $db_update = null;

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
            $mail->Subject = $mail_subject[$row['lang']];
            $mail->Body = $mail_message[$row['lang']];
                        
            if(isset($$picture)) {
                $mail->addStringAttachment($picture, 'picture.jpg', 'base64', 'image/jpeg');
            }

            if ($mail->send()) {
                // Update sending_success value
                $updateQuery = "UPDATE customers SET sending_success = 1 WHERE ID = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param('i', $customerID);

                if ($stmt->execute()) {
                    $db_update = true;
                } else {
                    $db_update = false;
                }

                $sended_mails++;
            } else {
                $failed_mails++;
            }

        } catch (Exception $error) {
            $response =  "Erreur lors de l'envoi de l'e-mail : " . $error->getMessage();
        }

        $response = $sended_mails . " mail(s) envoyé(s). " . $failed_mails . " échec(s).";
        $response = $sended_mails == 0 ? "Connection internet indisponible. Veuillez réessayer plus tard." : $response;

        $response .= $db_update ? "<br/> Tous les clients sont bien à jours." : "" ;
    }
}else {
    $response = "Tous les mails ont bien été envoyés.";
}

echo $response;

// Close connection
$conn->close();
?>