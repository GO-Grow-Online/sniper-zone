<?php
$response = "";

// Check if ID is set
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $video_deleted = false; 
    $picture_deleted = false;

    // Connection to DB
    $servername = "localhost";
    $username = "Sniper Zone";
    $password = "sniper-zone";
    $databaseName = "sniper_zone";

    $conn = new mysqli($servername, $username, $password, $databaseName);

    if ($conn->connect_error) {
        die("DB connection failed : " . $conn->connect_error);
    }

    
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
        if (file_exists($videoPath)) { unlink($videoPath); $video_deleted = true; }else{ $video_deleted = true; }
        if (file_exists($picturePath)) { unlink($picturePath); $picture_deleted = true; }else{ $picture_deleted = true; }

        $response .= "Fichiers supprimés. ";
        
    } else {
        $response = "An error occured : " . $query->error;
        $video_deleted = false;
        $picture_deleted = false;
    }


    // Update the database to clear the URLs
    $updateQuery = "UPDATE customers SET ";
    $updateQuery .= $video_deleted ? "video_path = '' " : "";
    $updateQuery .= $video_deleted && $picture_deleted ? ", " : "";
    $updateQuery .= $picture_deleted ? "picture_path = '' " : "";
    $updateQuery .= "WHERE ID = ?";
    $update = $conn->prepare($updateQuery);
    $update->bind_param("s", $id);

    if ($update->execute()) {
        $response .= "Urls de la DB supprimées. ";
    } else {
        $response .= "An error occurred during database update: " . $update->error;
    }


    // Delete entry where ID is equal the given one - DISABLED
    /*
    $deleteQuery = "DELETE FROM customers WHERE ID = ?";
    $query = $conn->prepare($deleteQuery);
    $query->bind_param("s", $id);

    // if entry is succefully deleted, delete associated video
    if ($query->execute()) {
        $response = "DataBase entry deleted. Deleted files : vidéo(" . $video_deleted . "), picture(" . $picture_deleted . ")";
    } else {
        $response = "An error occured : " . $query->error;
    }

    // Fermer la connexion à la base de données
    $query->close();
    $conn->close();
    */
} else {
    $response = "ID is missing from command.";
}

echo $response;
?>
