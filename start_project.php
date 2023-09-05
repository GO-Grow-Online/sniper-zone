<?php
$servername = "localhost";
$username = "Sniper Zone";
$password = "sniper-zone";

$databaseName = "recorded_videos";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Verify connection
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Create DB "recorded_videos"
$createDatabaseSQL = "CREATE DATABASE IF NOT EXISTS recorded_videos";

if ($conn->select_db($databaseName)) {
    echo "La base de données '$databaseName' existe déjà.<br>";
} else {
    $createDatabaseSQL = "CREATE DATABASE $databaseName";
    if ($conn->query($createDatabaseSQL) === TRUE) {
        echo "Base de données '$databaseName' créée avec succès.<br>";
        
        // Enter DB "recorded_videos"
        $conn->select_db("recorded_videos");
        
        // Create table "videos" in "recorded_videos"
        $createTableSQL = "
        CREATE TABLE IF NOT EXISTS videos (
            ID VARCHAR(255) NOT NULL,
            customer_email VARCHAR(255) NOT NULL,
            video_path VARCHAR(255) NOT NULL,
            sending_date VARCHAR(255) NOT NULL
        )";
        
        if ($conn->query($createTableSQL) === TRUE) {
            echo "Table 'videos' créée avec succès.<br>";
        } else {
            echo "Erreur lors de la création de la table : " . $conn->error . "<br>";
        }
        
        // Close connection
        $conn->close();
    } else {
        echo "Erreur lors de la création de la base de données : " . $conn->error . "<br>";
    }
}

?>
