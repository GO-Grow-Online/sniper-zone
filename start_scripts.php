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

        if (isset($row['video_path'])) {
            $video = $row['video_path'];
        }

        $db_update = null;

        // Send the email
        $mail = new PHPMailer();
        $mail_admin = new PHPMailer();

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPSecure = 'tls'; 
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'noreplysniperzone@gmail.com';
            $mail->Password = 'zpyl mazf awbf eloq';
            $mail->isHTML(true);

            // Sender & receiver
            $mail->setFrom('noreplysniperzone@gmail.com', 'Sniper zone');
            $mail->addAddress($customerEmail, 'Client');

            // Mail content
            $mail->Subject = $mail_subject[$row['lang']];
            $mail->Body = $mail_message[$row['lang']];
                        
            if(isset($picture)) {
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


            // Second mail with video attachment for admin
            $mail_admin->isSMTP();
            $mail_admin->Host = 'smtp.gmail.com';
            $mail_admin->SMTPSecure = 'tls'; 
            $mail_admin->Port = 587;
            $mail_admin->SMTPAuth = true;
            $mail_admin->Username = 'noreplysniperzone@gmail.com';
            $mail_admin->Password = 'zpyl mazf awbf eloq';

            $mail_admin->isHTML(true);

            $mail_admin->setFrom('noreplysniperzone@gmail.com', 'Sniper zone');
            $mail_admin->addAddress('noreplysniperzone@gmail.com', 'Sniper zone'); // Change this to the desired Gmail address

            $mail_admin->Subject = "Borne briefing - Sniper Zone";
            $mail_admin->Body = "Voici en pièce jointe la preuve vidéo du groupe ayant utilisé l'adresse : '" . $customerEmail . "'";

            $mail_admin->addAttachment($video, 'video.mp4');

            if ($mail_admin->send()) {
                // Update sending_success value
                $updateQuery = "UPDATE customers SET sending_admin_success = 1 WHERE ID = ?";
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

// Delete old db entries
$deleteDate = date('Y-m-d H:i', strtotime('-1 month'));
$selectIDQuery = "SELECT ID FROM customers WHERE sending_success = 1 AND sending_date < ?";

// Exécutez la requête de sélection des ID
$stmt = $conn->prepare($selectIDQuery);
$stmt->bind_param('s', $deleteDate);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    
    // Stockez les ID sélectionnés dans un tableau
    $idsToDelete = array();
    while ($row = $result->fetch_assoc()) {
        $idsToDelete[] = $row['ID'];
    }

    $deleted_entries = 0;
    
    // Maintenant, utilisez le code pour supprimer les entrées correspondantes
    foreach ($idsToDelete as $id) {
        // Check if ID is set
        if (isset($id)) { 

            // Delete entry where ID is equal the given one
            $selectQuery = "SELECT video_path, picture_path FROM customers WHERE ID = ?";
            $query = $conn->prepare($selectQuery);
            $query->bind_param("s", $id);

            if ($query->execute()) {

                // Get result first row
                $result = $query->get_result();
                $row = $result->fetch_assoc();
                
                $videoPath = $row['video_path'];
                $picturePath = $row['picture_path'];

                // Delete associated video
                if (file_exists($videoPath)) { unlink($videoPath); $video_deleted = true; }
                if (file_exists($picturePath)) { unlink($picturePath); $picture_deleted = true; }
                
            } else {
                $response = "An error occured : " . $query->error;
                $video_deleted = false;
                $picture_deleted = false;
            }


            // Delete entry where ID is equal the given one
            $deleteQuery = "DELETE FROM customers WHERE ID = ?";
            $query = $conn->prepare($deleteQuery);
            $query->bind_param("s", $id);
            
            // if entry is succefully deleted, delete associated video
            if ($query->execute()) {
                $deleted_entries++;
            } else {
                $response .= "An error occured : " . $query->error;
            }

            // Close db connection
            $query->close();
            $conn->close();
        } else {
            $response .= "ID is missing from command.";
        }
    }

    if ($deleted_entries > 1) {
        $response .= "<br/>" . $deleted_entries . " clients supprimés.";
    }elseif ($deleted_entries == 1) {
        $response .= "<br/>" . $deleted_entries . " client supprimé.";
    }else {
        $response .= "<br/>Aucun client supprimé.";
    }

} else {
    $response .= "<br/>Impossible de sélectionner les clients à supprimer.";
}

echo $response;

// Close connection
// $conn->close();
?>