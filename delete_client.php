<?php
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
        if (file_exists($videoPath)) { unlink($videoPath); $video_deleted = true; }
        if (file_exists($picturePath)) { unlink($picturePath); $picture_deleted = true; }
        
    } else {
        echo "An error occured : " . $query->error;
        $video_deleted = false;
        $picture_deleted = false;
    }


    // Delete entry where ID is equal the given one
    $deleteQuery = "DELETE FROM customers WHERE ID = ?";
    $query = $conn->prepare($deleteQuery);
    $query->bind_param("s", $id);

    // if entry is succefully deleted, delete associated video
    if ($query->execute()) {
        if ($video_deleted && $picture_deleted) {
            echo "DataBase entry deleted. Deleted files : vidéo(" . $video_deleted . "), picture(" . $picture_deleted . ")";
        }
    } else {
        echo "An error occured : " . $query->error;
    }

    // Fermer la connexion à la base de données
    $query->close();
    $conn->close();
} else {
    echo "ID is missing from command.";
}
?>
