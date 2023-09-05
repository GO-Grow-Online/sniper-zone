<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients enregistrés</title>

    <link rel="stylesheet" href="style.css">

    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="assets/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-config" content="assets/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
</head>
<body class="clients">

    <h1>Clients enregistrés</h1> 

<?php
$servername = "localhost";
$username = "Sniper Zone";
$password = "sniper-zone";
$databaseName = "recorded_videos";

// Connection to DB
$conn = new mysqli($servername, $username, $password, $databaseName);

// Verify connection
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Execute query that select all videos from table
$selectQuery = "SELECT * FROM videos";
$result = $conn->query($selectQuery);

if ($result === false) {
    die("Erreur lors de la récupération des données : " . $conn->error);
}

// Display results
if ($result->num_rows > 0) : ?>
    <table class="table">

        <tr class="table-heading">
            <th>ID</th>
            <th>Date de visionnage</th>
            <th>Email du client</th>
            <th>Preuve visionnage</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr class="table-row">
            <td class="table-row-id"> <?php echo $row['ID']; ?> </td>
            <td class="table-row-date"> <?php echo $row['sending_date']; ?> </td>
            <td class="table-row-email">
            <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.525 15L13.2143 9M7.78571 9L1.47503 15M1 4L8.75667 9.71544C9.38479 10.1783 9.69884 10.4097 10.0405 10.4993C10.3422 10.5785 10.6578 10.5785 10.9595 10.4993C11.3012 10.4097 11.6152 10.1783 12.2433 9.71544L20 4M5.56 17H15.44C17.0361 17 17.8342 17 18.4439 16.673C18.9801 16.3854 19.4161 15.9265 19.6894 15.362C20 14.7202 20 13.8802 20 12.2V5.8C20 4.11984 20 3.27976 19.6894 2.63803C19.4161 2.07354 18.9801 1.6146 18.4439 1.32698C17.8342 1 17.0361 1 15.44 1H5.56C3.96385 1 3.16578 1 2.55613 1.32698C2.01987 1.6146 1.58387 2.07354 1.31063 2.63803C1 3.27976 1 4.11984 1 5.8V12.2C1 13.8802 1 14.7202 1.31063 15.362C1.58387 15.9265 2.01987 16.3854 2.55613 16.673C3.16578 17 3.96385 17 5.56 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <?php echo $row['customer_email']; ?>
            </td>
            <td class="table-row-video">
                <a href="<?php echo $row['video_path']; ?>">
                <svg width="17" height="22" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 3.98951C1 3.01835 1 2.53277 1.20249 2.2651C1.37889 2.03191 1.64852 1.88761 1.9404 1.87018C2.27544 1.85017 2.67946 2.11953 3.48752 2.65823L14.0031 9.6686C14.6708 10.1137 15.0046 10.3363 15.1209 10.6168C15.2227 10.8621 15.2227 11.1377 15.1209 11.383C15.0046 11.6635 14.6708 11.886 14.0031 12.3312L3.48752 19.3415C2.67946 19.8802 2.27544 20.1496 1.9404 20.1296C1.64852 20.1122 1.37889 19.9679 1.20249 19.7347C1 19.467 1 18.9814 1 18.0103V3.98951Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Cliquez pour récupérer la video
                </a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>
<?php else : ?>
    <p class="error_msg">Aucun client trouvé.</p> 
<?php endif; 

// Close connection
$conn->close();
?>


    
</body>
</html>