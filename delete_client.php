<?php
// Check if ID is set
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $video_deleted = false; 

    // Connection to DB
    $servername = "localhost";
    $username = "Sniper Zone";
    $password = "sniper-zone";
    $databaseName = "recorded_videos";

    $conn = new mysqli($servername, $username, $password, $databaseName);

    if ($conn->connect_error) {
        die("DB connection failed : " . $conn->connect_error);
    }

    
    // Delete entry where ID is equal the given one
    $deleteQuery = "SELECT video_path FROM videos WHERE ID = ?";
    $query = $conn->prepare($deleteQuery);
    $query->bind_param("s", $id);

    if ($query->execute()) {

        // Get result first row
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        
        $videoPath = $row['video_path'];

        // Delete associated video
        if (file_exists($videoPath)) { unlink($videoPath); }else{ echo 'File deletion failed : Non-existing file.'; }
        $video_deleted = true;
    } else {
        echo "An error occured : " . $query->error;
        $video_deleted = false;
    }


    // Delete entry where ID is equal the given one
    $deleteQuery = "DELETE FROM videos WHERE ID = ?";
    $query = $conn->prepare($deleteQuery);
    $query->bind_param("s", $id);

    // if entry is succefully deleted, delete associated video
    if ($query->execute()) {
        if ($video_deleted) {
            echo "Client has been fully deleted.";
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
