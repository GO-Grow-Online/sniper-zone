<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sniperzone briefing - Clients enregistrés</title>
    <script src="assets/jquery.js"></script>
    <script src="assets/app.js"></script>
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

    <meta name="robots" content="noindex, nofollow">
</head>
<body class="clients">
    <a href="index.php" class="btn btn-round btn--previous"><svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 5H14.5C16.9853 5 19 7.01472 19 9.5C19 11.9853 16.9853 14 14.5 14H10M1 5L5 1M1 5L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>

    <h1>Clients enregistrés</h1> 

<?php
$servername = "localhost";
$username = "Sniper Zone";
$password = "sniper-zone";
$databaseName = "sniper_zone";

// Connection to DB
$conn = new mysqli($servername, $username, $password, $databaseName);

// Verify connection
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Execute query that select all videos from table
$selectQuery = "SELECT * FROM customers ORDER BY sending_date DESC";
$result = $conn->query($selectQuery);

if ($result === false) {
    die("Erreur lors de la récupération des données : " . $conn->error);
}

// Display results
if ($result->num_rows > 0) : ?>
    <table class="table">

        <tr class="table-heading">
            <th>Date de visionnage</th>
            <th>Email du client</th>
            <th>Preuve visionnage</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr class="table-row <?php if($row['sending_success']) : ?> table-row-mailSuccess<?php endif; ?> <?php if($row['sending_admin_success']) : ?> table-row-mailAdminSuccess<?php endif; ?>">
            <?php if($row['video_path'] != "" || $row['picture_path'] != "") : ?>
                <td class="table-row-actions"><button data-delete="<?php echo $row['ID']; ?>" class="btn btn-round btn-small btn--deleteClient"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 7L7 17M7 7L17 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button></td>
            <?php endif; ?>
            <td class="table-row-infos">
                <span class="table-row-lang"><?php echo $row['lang']; ?></span>
                <svg class="table-icon table-icon-sendingSuccess" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.49952 12.5001L19.9995 2.00005M9.6271 12.8281L12.2552 19.5861C12.4867 20.1815 12.6025 20.4791 12.7693 20.566C12.9139 20.6414 13.0862 20.6415 13.2308 20.5663C13.3977 20.4796 13.5139 20.1821 13.7461 19.587L20.3364 2.69925C20.5461 2.16207 20.6509 1.89348 20.5935 1.72185C20.5437 1.5728 20.4268 1.45583 20.2777 1.40604C20.1061 1.34871 19.8375 1.45352 19.3003 1.66315L2.41258 8.25349C1.8175 8.48572 1.51997 8.60183 1.43326 8.76873C1.35809 8.91342 1.35819 9.08567 1.43353 9.23027C1.52043 9.39707 1.81811 9.51283 2.41345 9.74436L9.17146 12.3725C9.29231 12.4195 9.35273 12.443 9.40361 12.4793C9.44871 12.5114 9.48815 12.5509 9.52031 12.596C9.55661 12.6468 9.58011 12.7073 9.6271 12.8281Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <svg class="table-icon table-icon-sendingAdminSuccess" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H15.2C16.8802 22 17.7202 22 18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362C20 19.7202 20 18.8802 20 17.2V8M14 2L20 8M14 2V8H20M12 18C12 18 15 16.5701 15 14.4252V11.9229L12.8124 11.1412C12.2868 10.9529 11.712 10.9529 11.1864 11.1412L9 11.9229V14.4252C9 16.5701 12 18 12 18Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <?php echo $row['sending_date']; ?>
                <span class="table-row-id"><?php echo $row['ID']; ?></span>
            </td>
            <td class="table-row-email">
                  <a href="mailto:<?php echo $row['customer_email']; ?>">
                    <svg class="table-icon" width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.525 15L13.2143 9M7.78571 9L1.47503 15M1 4L8.75667 9.71544C9.38479 10.1783 9.69884 10.4097 10.0405 10.4993C10.3422 10.5785 10.6578 10.5785 10.9595 10.4993C11.3012 10.4097 11.6152 10.1783 12.2433 9.71544L20 4M5.56 17H15.44C17.0361 17 17.8342 17 18.4439 16.673C18.9801 16.3854 19.4161 15.9265 19.6894 15.362C20 14.7202 20 13.8802 20 12.2V5.8C20 4.11984 20 3.27976 19.6894 2.63803C19.4161 2.07354 18.9801 1.6146 18.4439 1.32698C17.8342 1 17.0361 1 15.44 1H5.56C3.96385 1 3.16578 1 2.55613 1.32698C2.01987 1.6146 1.58387 2.07354 1.31063 2.63803C1 3.27976 1 4.11984 1 5.8V12.2C1 13.8802 1 14.7202 1.31063 15.362C1.58387 15.9265 2.01987 16.3854 2.55613 16.673C3.16578 17 3.96385 17 5.56 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <?php echo $row['customer_email']; ?>
                </a>
            </td>
            <?php if($row['video_path'] != "" || $row['picture_path'] != "") : ?>
            <td class="table-row-video <?php if($row['video_path'] == "") : ?>table-row--disabled<?php endif; ?>">
                <a href="<?php echo $row['video_path']; ?>" download>
                <svg class="table-icon" width="17" height="22" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 3.98951C1 3.01835 1 2.53277 1.20249 2.2651C1.37889 2.03191 1.64852 1.88761 1.9404 1.87018C2.27544 1.85017 2.67946 2.11953 3.48752 2.65823L14.0031 9.6686C14.6708 10.1137 15.0046 10.3363 15.1209 10.6168C15.2227 10.8621 15.2227 11.1377 15.1209 11.383C15.0046 11.6635 14.6708 11.886 14.0031 12.3312L3.48752 19.3415C2.67946 19.8802 2.27544 20.1496 1.9404 20.1296C1.64852 20.1122 1.37889 19.9679 1.20249 19.7347C1 19.467 1 18.9814 1 18.0103V3.98951Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Récupérer la video
                </a>
            </td>
            <td class="table-row-picture <?php if($row['picture_path'] == "") : ?>table-row--disabled<?php endif; ?>">
                <a href="<?php echo $row['picture_path']; ?>" download>
                <svg class="table-icon" width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.27209 18.7279L9.86863 12.1314C10.2646 11.7354 10.4627 11.5373 10.691 11.4632C10.898 11.3979 11.1082 11.3979 11.309 11.4632C11.5373 11.5373 11.7354 11.7354 12.1314 12.1314L18.6839 18.6839M13 13L15.8686 10.1314C16.2646 9.73535 16.4627 9.53735 16.691 9.46316C16.8918 9.3979 17.1082 9.3979 17.309 9.46316C17.5373 9.53735 17.7354 9.73535 18.1314 10.1314L21 13M9 7C9 8.10457 8.10457 9 7 9C5.89543 9 5 8.10457 5 7C5 5.89543 5.89543 5 7 5C8.10457 5 9 5.89543 9 7ZM5.8 19H16.2C17.8802 19 18.7202 19 19.362 18.673C19.9265 18.3854 20.3854 17.9265 20.673 17.362C21 16.7202 21 15.8802 21 14.2V5.8C21 4.11984 21 3.27976 20.673 2.63803C20.3854 2.07354 19.9265 1.6146 19.362 1.32698C18.7202 1 17.8802 1 16.2 1H5.8C4.11984 1 3.27976 1 2.63803 1.32698C2.07354 1.6146 1.6146 2.07354 1.32698 2.63803C1 3.27976 1 4.11984 1 5.8V14.2C1 15.8802 1 16.7202 1.32698 17.362C1.6146 17.9265 2.07354 18.3854 2.63803 18.673C3.27976 19 4.11984 19 5.8 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Récupérer la photo
                </a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endwhile; ?>

    </table>
<?php else : ?>
    <p class="error_msg">Aucun client trouvé.</p> 
<?php endif; 

// Close connection
$conn->close();
?>

<div class="popup popup-center" data-popup="deletion-warning">
    <div class="popup-msg">
        <span class="popup-closeDelay"><span></span></span>
        <p>Cette action est iréversible, êtes-vous sûr ?</p>

        <div class="btn-group">
            <button class="btn btn-round btn--confirm"><svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 1L6 12L1 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
            <button class="btn btn-round btn--cancel"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
        </div>
    </div>
</div>

<div class="popup" data-popup="deletion-failed">
    <div class="popup-msg popup-failed">
        <span class="popup-closeDelay"><span></span></span>
        <p>La suppression à échouée. Veuillez contacter votre programmeur.</p>
    </div>
</div>
    
</body>
</html>