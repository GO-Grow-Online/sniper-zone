<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sniperzone testing</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/app.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="loading">

    <div class="loadingScreen">

    </div>

    <main>

        <section id="selectLang" class="current">
            <ul class="languages">
                <li>
                    <button class="btn--lang" data-lang="fr">
                        <img src="assets/medias/image/fr_flag.svg" alt="Français">
                        <span>Français</span>
                    </button>
                </li>
                <li>
                    <button class="btn--lang" data-lang="de">
                        <img src="assets/medias/image/de_flag.svg" alt="Deutch">
                        <span>Deutch</span>
                    </button>
                </li>
                <li>
                    <button class="btn--lang" data-lang="en">
                        <img src="assets/medias/image/en_flag.svg" alt="English">
                        <span>English</span>
                    </button>
                </li>
                <li>
                    <button class="btn--lang" data-lang="nl">
                        <img src="assets/medias/image/nl_flag.svg" alt="Neederlands">
                        <span>Neederlands</span>
                    </button>
                </li>
            </ul>
        </section>

        <section id="videoPlayer">
            <button id="stopRec">stopRec</button>
            <video autoplay id="videoPreview"></video>
            <video id="video" preload="auto">
                <!--source src="video.php" type="video/mp4"-->
                <source src="..." data-src="assets/medias/video/briefing-fr.mp4" type="video/mp4">
                <!-- <source src="..." data-src="briefing-de.php" type="video/mp4"> -->
                <!-- <source src="..." data-src="briefing-en.php" type="video/mp4"> -->
                <!-- <source src="..." data-src="briefing-nl.php" type="video/mp4"> -->
                
                Votre navigateur ne supporte pas la lecture de vidéos.
            </video>
        </section>

        <section>

        </section>

        <section>

        </section>

    </main>

</body>
</html>
