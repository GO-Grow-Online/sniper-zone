<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sniperzone testing</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</head>
<body data-lang="fr">

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

        <section id="briefing" class="">
            
            <!-- button class="btn btn-round btn--previous"><svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 5H14.5C16.9853 5 19 7.01472 19 9.5C19 11.9853 16.9853 14 14.5 14H10M1 5L5 1M1 5L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></!-->

            <video autoplay class="videoPreview"></video>
            <video preload="auto" id="video">
                <source src="assets/medias/video/briefing-fr.mp4" type="video/mp4">
                <source src="assets/medias/video/briefing-de.mp4" type="video/mp4">
                <source src="assets/medias/video/briefing-en.mp4" type="video/mp4">
                <source src="assets/medias/video/briefing-nl.mp4" type="video/mp4">
            </video>
        </section>

        <section id="email" class="">
            
            <!-- button class="btn btn-round btn--previous"><svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 5H14.5C16.9853 5 19 7.01472 19 9.5C19 11.9853 16.9853 14 14.5 14H10M1 5L5 1M1 5L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></!-->

            <div class="email-form">
                <div class="email-text">
                    <p data-trad="fr">Pour terminer, veuillez entrer une adresse e-mail :</p>
                    <p data-trad="de"></p>
                    <p data-trad="en">Please, enter an e-mail address to end the briefing :</p>
                    <p data-trad="nl"></p>
                </div>
                <label for="email_field">Email</label>
                <input name="email" id="email_field" type="text"/>

                <button class="btn btn-round email-form-submit"><svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 1L6 12L1 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
            </div>
        </section>

        <section id="askPicture" class="">
            
            <button class="btn btn-round btn--previous"><svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 5H14.5C16.9853 5 19 7.01472 19 9.5C19 11.9853 16.9853 14 14.5 14H10M1 5L5 1M1 5L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>


            <p data-trad="fr">Souhaitez-vous prendre une photo de groupe avant de commencer ?</p>
            <p data-trad="fr" class="small">(La photo sera envoyée dans les jours suivants sur l'adresse mail que vous entrerez dans les prochaines étapes.)</p>

            <p data-trad="de"></p>

            <p data-trad="en">Would you like to take a group picture ?</p>
            <p data-trad="en" class="small">(The picture will be sent in the next days on the email you'll give in the next steps.)</p>

            <p data-trad="nl"></p>

            <div class="btn-group">
                <button class="btn btn-round btn--acceptPic"><svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 1L6 12L1 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                <button class="btn btn-round btn--refusePic"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
            </div>
        </section>

        <section id="takePicture" class="">
            
            <!-- button class="btn btn-round btn--previous"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></!-->

            <video autoplay class="videoPreview"></video>
            <button class="btn btn-round btn--takePicture">
                <span class="timer">10s</span>
                <svg class="timer-svg" width="38" height="26" viewBox="0 0 38 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 12.3772C1 12.0269 1 11.8517 1.01462 11.7042C1.1556 10.2813 2.28127 9.1556 3.70421 9.01462C3.85174 9 4.03636 9 4.40558 9C4.54785 9 4.61899 9 4.67939 8.99634C5.45061 8.94963 6.12595 8.46288 6.41414 7.746C6.43671 7.68986 6.45781 7.62657 6.5 7.5C6.54219 7.37343 6.56329 7.31014 6.58586 7.254C6.87405 6.53712 7.54939 6.05037 8.32061 6.00366C8.38101 6 8.44772 6 8.58114 6H13.4189C13.5523 6 13.619 6 13.6794 6.00366C14.4506 6.05037 15.126 6.53712 15.4141 7.254C15.4367 7.31014 15.4578 7.37343 15.5 7.5C15.5422 7.62657 15.5633 7.68986 15.5859 7.746C15.874 8.46288 16.5494 8.94963 17.3206 8.99634C17.381 9 17.4521 9 17.5944 9C17.9636 9 18.1483 9 18.2958 9.01462C19.7187 9.1556 20.8444 10.2813 20.9854 11.7042C21 11.8517 21 12.0269 21 12.3772V20.2C21 21.8802 21 22.7202 20.673 23.362C20.3854 23.9265 19.9265 24.3854 19.362 24.673C18.7202 25 17.8802 25 16.2 25H5.8C4.11984 25 3.27976 25 2.63803 24.673C2.07354 24.3854 1.6146 23.9265 1.32698 23.362C1 22.7202 1 21.8802 1 20.2V12.3772Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M11 20.5C13.2091 20.5 15 18.7091 15 16.5C15 14.2909 13.2091 12.5 11 12.5C8.79086 12.5 7 14.2909 7 16.5C7 18.7091 8.79086 20.5 11 20.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="28" cy="10" r="10" fill="white"/><path d="M28 7V10.2L30.0588 11.4M28 3.4C24.134 3.4 21 6.44446 21 10.2C21 13.9555 24.134 17 28 17C31.866 17 35 13.9555 35 10.2C35 6.44446 31.866 3.4 28 3.4ZM28 3.4V1M26.3529 1H29.6471M34.8592 3.87363L33.6239 2.67363L34.2415 3.27363M21.1408 3.87363L22.3761 2.67363L21.7585 3.27363" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>

            <div class="takePicture-result">
                <img class="takePicture-result-capturedImage" src="" alt="">
                <canvas class="takePicture-result-canva"></canvas>
                <div class="btn-group">
                    <button class="btn btn-round btn--validatePic"><svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 1L6 12L1 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                    <button class="btn btn-round btn--redoPic"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                </div>
            </div>
        </section>

        <!-- section id="end" class="">
            <p data-trad="fr">Merci d'avoir suivit ce briefing. Respectez les règles évoquées, et amusez-vous !</p>
            <p data-trad="de"></p>
            <p data-trad="en">Thank you for listening. Please respect the rules, and have fun !</p>
            <p data-trad="nl"></p>
        </!-->
        

        <div class="popup popup-center" data-popup="brief-begin">
            <div class="popup-msg popup-success">
                <span class="popup-closeDelay"><span></span></span>
                <p data-trad="fr">Le briefing va bientôt commencer.</p>
                <p data-trad="de"></p>
                <p data-trad="en">Briefing will start soon.</p>
                <p data-trad="nl"></p>
            </div>
        </div>

        <div class="popup" data-popup="form-error">
            <div class="popup-msg popup-failed">
                <span class="popup-closeDelay"><span></span></span>
                <p data-trad="fr">L'adresse e-mail n'est pas valide. Veuillez vérifier et réessayer.</p>
                <p data-trad="de"></p>
                <p data-trad="en">The e-mail address is invalid. Please verify and retry.</p>
                <p data-trad="nl"></p>
            </div>
        </div>

        <div class="popup" data-popup="form-empty">
            <div class="popup-msg popup-failed">
                <span class="popup-closeDelay"><span></span></span>
                <p data-trad="fr">Le champ doit être complété.</p>
                <p data-trad="de"></p>
                <p data-trad="en">The field must not be empty.</p>
                <p data-trad="nl"></p>
            </div>
        </div>

        <div class="popup" data-popup="form-sending">
            <div class="popup-msg popup-success">
                <span class="popup-closeDelay"><span></span></span>
                <p data-trad="fr">Envois de l'email...</p>
                <p data-trad="de"></p>
                <p data-trad="en">Sending email...</p>
                <p data-trad="nl"></p>
            </div>
        </div>

        <div class="popup popup-center" data-popup="succes">
            <div class="popup-msg">
                <span class="popup-closeDelay"><span></span></span>
                <p data-trad="fr">Le briefing est désormais terminé. Un email est à été envoyé sur l'adresse donnée. Merci pour votre attention.</p>
                <p data-trad="de"></p>
                <p data-trad="en">The briefing is now done. An email has been sent on the given address. Thank you for your attention.</p>
                <p data-trad="nl"></p>
            </div>
        </div>

    </main>

</body>
</html>
