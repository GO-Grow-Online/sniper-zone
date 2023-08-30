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
        <div class="loadingScreen-indicator">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 1.25V3.75M11 17V21M4.75 11H1.25M20.25 11H18.75M17.4571 17.4571L16.75 16.75M17.6642 4.41579L16.25 5.83M3.92157 18.0784L6.75 15.25M4.12868 4.20868L6.25 6.33" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>

            <p>Chargement des médias : <span class="loadingScreen-indicator-value"></span>%</p>
        </div>
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
            <video id="video" pause preload="auto">
                <!--source src="video.php" type="video/mp4"-->
                <source src="briefing-fr.php" data-file="assets/medias/video/briefing-fr.mp4" type="video/mp4">
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
