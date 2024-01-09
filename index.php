<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sniperzone testing</title>
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

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/service-worker.js')
        .then(function(registration) {
          console.log('Service Worker registered with scope:', registration.scope);
        })
        .catch(function(error) {
          console.error('Service Worker registration failed:', error);
        });
    }
  </script>
</head>
<body data-lang="fr">

    <div class="loadingScreen">
        <div class="loadingScreen-indicator">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2.25V4.75M12 18V22M18.25 12H21.75M2.75 12H4.25M5.54289 18.4571L6.25 17.75M5.33579 5.41579L6.75 6.83M19.0784 19.0784L16.25 16.25M18.8713 5.20868L16.75 7.33" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            <span class="loadingScreen-indicator-value"></span>
        </div>
    </div>

    <main>
  
        <section id="selectLang" class="current">
            <a class="btn btn-round btn-small btn--settings" aria-label="Clients enregistrés" href="clients.php"><svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.3951 18.3711L7.97955 19.6856C8.15329 20.0768 8.43683 20.4093 8.79577 20.6426C9.15472 20.8759 9.57366 21.0001 10.0018 21C10.4299 21.0001 10.8488 20.8759 11.2078 20.6426C11.5667 20.4093 11.8503 20.0768 12.024 19.6856L12.6084 18.3711C12.8165 17.9047 13.1664 17.5159 13.6084 17.26C14.0532 17.0034 14.5678 16.8941 15.0784 16.9478L16.5084 17.1C16.9341 17.145 17.3637 17.0656 17.7451 16.8713C18.1265 16.6771 18.4434 16.3763 18.6573 16.0056C18.8715 15.635 18.9735 15.2103 18.9511 14.7829C18.9286 14.3555 18.7825 13.9438 18.5307 13.5978L17.684 12.4344C17.3825 12.0171 17.2214 11.5148 17.224 11C17.2239 10.4866 17.3865 9.98635 17.6884 9.57111L18.5351 8.40778C18.787 8.06175 18.933 7.65007 18.9555 7.22267C18.978 6.79528 18.8759 6.37054 18.6618 6C18.4479 5.62923 18.131 5.32849 17.7496 5.13423C17.3681 4.93997 16.9386 4.86053 16.5129 4.90556L15.0829 5.05778C14.5722 5.11141 14.0577 5.00212 13.6129 4.74556C13.17 4.48825 12.82 4.09736 12.6129 3.62889L12.024 2.31444C11.8503 1.92317 11.5667 1.59072 11.2078 1.3574C10.8488 1.12408 10.4299 0.99993 10.0018 1C9.57366 0.99993 9.15472 1.12408 8.79577 1.3574C8.43683 1.59072 8.15329 1.92317 7.97955 2.31444L7.3951 3.62889C7.18803 4.09736 6.83798 4.48825 6.3951 4.74556C5.95032 5.00212 5.43577 5.11141 4.9251 5.05778L3.49066 4.90556C3.06499 4.86053 2.6354 4.93997 2.25397 5.13423C1.87255 5.32849 1.55567 5.62923 1.34177 6C1.12759 6.37054 1.02555 6.79528 1.04804 7.22267C1.07052 7.65007 1.21656 8.06175 1.46844 8.40778L2.3151 9.57111C2.61704 9.98635 2.77964 10.4866 2.77955 11C2.77964 11.5134 2.61704 12.0137 2.3151 12.4289L1.46844 13.5922C1.21656 13.9382 1.07052 14.3499 1.04804 14.7773C1.02555 15.2047 1.12759 15.6295 1.34177 16C1.55589 16.3706 1.8728 16.6712 2.25417 16.8654C2.63554 17.0596 3.06502 17.1392 3.49066 17.0944L4.92066 16.9422C5.43133 16.8886 5.94587 16.9979 6.39066 17.2544C6.83519 17.511 7.18687 17.902 7.3951 18.3711Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.99998 14C11.6568 14 13 12.6569 13 11C13 9.34315 11.6568 8 9.99998 8C8.34313 8 6.99998 9.34315 6.99998 11C6.99998 12.6569 8.34313 14 9.99998 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
            
            <ul class="languages">
                <li>
                    <button class="btn--lang" data-lang="fr">
                        <img src="assets/medias/image/fr_flag.svg" alt="Français">
                        <span>Français</span>
                    </button>
                </li>
                <li>
                    <button class="btn--lang" data-lang="de">
                        <img src="assets/medias/image/de_flag.svg" alt="Deutsch">
                        <span>Deutsch</span>
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
                        <img src="assets/medias/image/nl_flag.svg" alt="Nederlands">
                        <span>Nederlands</span>
                    </button>
                </li>
            </ul>
        </section>

        <section id="briefing" class="">
            
            <!-- button class="btn btn-round btn--previous"><svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 5H14.5C16.9853 5 19 7.01472 19 9.5C19 11.9853 16.9853 14 14.5 14H10M1 5L5 1M1 5L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></!-->

            <video autoplay class="videoPreview"></video>
            <video preload="auto" id="video">
                <source src="" type="video/mp4">
            </video>
        </section>

        <section id="email" class="">
            
            <button class="btn btn-round btn--previous"><svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 5H14.5C16.9853 5 19 7.01472 19 9.5C19 11.9853 16.9853 14 14.5 14H10M1 5L5 1M1 5L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>

            <div class="email-form">
                <div class="email-text">
                    <p data-trad="fr">Pour terminer, veuillez entrer une adresse e-mail :</p>
                    <p data-trad="de">Bitte geben Sie eine E-Mail-Adresse ein, um den Briefing abzuschließen:</p>
                    <p data-trad="en">Please enter an email address to complete the briefing:</p>
                    <p data-trad="nl">Voer alstublieft een e-mailadres in om de briefing af te ronden:</p>
                </div>
                <label for="email_field">Email</label>
                <input name="email" id="email_field" type="text"/>

                <button class="btn btn-round btn--confirm"><svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 1L6 12L1 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>

                <div class="email-text small">
                    <p data-trad="fr">En acceptant de recevoir cette photo, vous vous inscrivez à notre Newsletter.</p>
                    <p data-trad="de">Durch das Akzeptieren dieses Fotos melden Sie sich für unseren Newsletter an.</p>
                    <p data-trad="en">By accepting to receive this photo, you are subscribing to our newsletter.</p>
                    <p data-trad="nl">Door deze foto te accepteren, schrijft u zich in voor onze nieuwsbrief.</p>
                </div>

            </div>
        </section>

        <section id="askPicture" class="">
            
            <!-- button class="btn btn-round btn--previous"><svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 5H14.5C16.9853 5 19 7.01472 19 9.5C19 11.9853 16.9853 14 14.5 14H10M1 5L5 1M1 5L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></!-->

            <p data-trad="fr">Souhaitez-vous prendre une photo de groupe avant de commencer ?</p>
            <p data-trad="fr" class="small">(La photo sera envoyée dans les jours suivants sur l'adresse e-mail que vous entrerez dans les prochaines étapes.)</p>

            <p data-trad="de">Möchten Sie vor dem Beginn ein Gruppenfoto machen?</p>
            <p data-trad="de" class="small">(Das Foto wird in den nächsten Tagen an die E-Mail-Adresse gesendet, die Sie in den nächsten Schritten angeben.)</p>

            <p data-trad="en">Would you like to take a group picture?</p>
            <p data-trad="en" class="small">(The picture will be sent in the next days to the email address you will provide in the next steps.)</p>

            <p data-trad="nl">Wilt u een groepsfoto maken voordat u begint?</p>
            <p data-trad="nl" class="small">(De foto wordt in de komende dagen naar het opgegeven e-mailadres gestuurd tijdens de volgende stappen.)</p>

            <div class="btn-group">
                <button class="btn btn-round btn--confirm"><svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 1L6 12L1 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                <button class="btn btn-round btn--cancel"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
            </div>
        </section>

        <section id="takePicture" class="">
            
            <button class="btn btn-round btn--previous"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>

            <div class="takePicture-preview">
                <video autoplay class="videoPreview"></video>
                <img class="takePicture-preview-watermark" src="assets/medias/image/logo.png" alt="Sniper Zone">
            </div>

            <button class="btn btn-round btn--takePicture">
                <span class="timer">10s</span>
                <svg class="timer-svg" width="38" height="26" viewBox="0 0 38 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 12.3772C1 12.0269 1 11.8517 1.01462 11.7042C1.1556 10.2813 2.28127 9.1556 3.70421 9.01462C3.85174 9 4.03636 9 4.40558 9C4.54785 9 4.61899 9 4.67939 8.99634C5.45061 8.94963 6.12595 8.46288 6.41414 7.746C6.43671 7.68986 6.45781 7.62657 6.5 7.5C6.54219 7.37343 6.56329 7.31014 6.58586 7.254C6.87405 6.53712 7.54939 6.05037 8.32061 6.00366C8.38101 6 8.44772 6 8.58114 6H13.4189C13.5523 6 13.619 6 13.6794 6.00366C14.4506 6.05037 15.126 6.53712 15.4141 7.254C15.4367 7.31014 15.4578 7.37343 15.5 7.5C15.5422 7.62657 15.5633 7.68986 15.5859 7.746C15.874 8.46288 16.5494 8.94963 17.3206 8.99634C17.381 9 17.4521 9 17.5944 9C17.9636 9 18.1483 9 18.2958 9.01462C19.7187 9.1556 20.8444 10.2813 20.9854 11.7042C21 11.8517 21 12.0269 21 12.3772V20.2C21 21.8802 21 22.7202 20.673 23.362C20.3854 23.9265 19.9265 24.3854 19.362 24.673C18.7202 25 17.8802 25 16.2 25H5.8C4.11984 25 3.27976 25 2.63803 24.673C2.07354 24.3854 1.6146 23.9265 1.32698 23.362C1 22.7202 1 21.8802 1 20.2V12.3772Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M11 20.5C13.2091 20.5 15 18.7091 15 16.5C15 14.2909 13.2091 12.5 11 12.5C8.79086 12.5 7 14.2909 7 16.5C7 18.7091 8.79086 20.5 11 20.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="28" cy="10" r="10" fill="white"/><path d="M28 7V10.2L30.0588 11.4M28 3.4C24.134 3.4 21 6.44446 21 10.2C21 13.9555 24.134 17 28 17C31.866 17 35 13.9555 35 10.2C35 6.44446 31.866 3.4 28 3.4ZM28 3.4V1M26.3529 1H29.6471M34.8592 3.87363L33.6239 2.67363L34.2415 3.27363M21.1408 3.87363L22.3761 2.67363L21.7585 3.27363" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>

            <div class="takePicture-result">
                <img class="takePicture-result-capturedImage" src="" alt="">
                <canvas class="takePicture-result-canva"></canvas>
                <div class="btn-group">
                    <button class="btn btn-round btn--confirm"><svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 1L6 12L1 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                    <button class="btn btn-round btn--cancel"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 1L1 13M1 1L13 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                </div>
            </div>
        </section>        

        <div class="popup popup-center" data-popup="brief-begin">
            <div class="popup-msg popup-success">
                <span class="popup-closeDelay"><span></span></span>
                <p data-trad="fr">Le briefing va bientôt commencer.</p>
                <p data-trad="de">Die Besprechung beginnt bald.</p>
                <p data-trad="en">Briefing will start soon.</p>
                <p data-trad="nl">De briefing begint binnenkort.</p>
            </div>
        </div>

        <div class="popup" data-popup="form-error">
            <div class="popup-msg popup-failed">
                <span class="popup-closeDelay"><span></span></span>
                <p data-trad="fr">L'adresse e-mail n'est pas valide. Veuillez vérifier et réessayer.</p>
                <p data-trad="de">Die E-Mail-Adresse ist ungültig. Bitte überprüfen und erneut versuchen.</p>
                <p data-trad="en">The e-mail address is invalid. Please verify and retry.</p>
                <p data-trad="nl">Het e-mailadres is ongeldig. Controleer en probeer opnieuw.</p>
            </div>
        </div>

        <div class="popup" data-popup="form-empty">
            <div class="popup-msg popup-failed">
                <span class="popup-closeDelay"><span></span></span>
                <p data-trad="fr">Le champ doit être complété.</p>
                <p data-trad="de">Das Feld darf nicht leer sein.</p>
                <p data-trad="en">The field must not be empty.</p>
                <p data-trad="nl">Het veld mag niet leeg zijn.</p>
            </div>
        </div>

        <div class="popup popup-infinite popup-center" data-popup="form-sending">
            <div class="popup-msg">
                <svg class="loader" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.25V4.75M12 18V22M18.25 12H21.75M2.75 12H4.25M5.54289 18.4571L6.25 17.75M5.33579 5.41579L6.75 6.83M19.0784 19.0784L16.25 16.25M18.8713 5.20868L16.75 7.33" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <p data-trad="fr">Envoi de l'email...</p>
                <p data-trad="de">E-Mail wird gesendet...</p>
                <p data-trad="en">Sending email...</p>
                <p data-trad="nl">E-mail wordt verzonden...</p>
            </div>
        </div>

        <div class="popup popup-center" data-popup="succes">
            <div class="popup-msg">
                <span class="popup-closeDelay"><span></span></span>
                <p data-trad="fr">Un email a été envoyé à l'adresse fournie. Merci pour votre attention.</p>
                <p data-trad="de">Eine E-Mail wurde an die angegebene Adresse gesendet. Vielen Dank für Ihre Aufmerksamkeit.</p>
                <p data-trad="en">An email has been sent to the provided address. Thank you for your attention.</p>
                <p data-trad="nl">Een e-mail is verzonden naar het opgegeven adres. Bedankt voor uw aandacht.</p>
            </div>
        </div>

        <div class="popup popup-infinite popup-center" data-popup="failed-mails-sending">
            <div class="popup-msg">
                <svg class="loader" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.25V4.75M12 18V22M18.25 12H21.75M2.75 12H4.25M5.54289 18.4571L6.25 17.75M5.33579 5.41579L6.75 6.83M19.0784 19.0784L16.25 16.25M18.8713 5.20868L16.75 7.33" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <p>Envois des mails...</p>
            </div>
        </div>

        <div class="popup" data-popup="failed-mails-error">
            <div class="popup-msg">
                <span class="popup-closeDelay"><span></span></span>
                <p class="failed-mail-text"></p>
            </div>
        </div>

        <div class="popup" data-popup="failed-mails-success">
            <div class="popup-msg">
                <span class="popup-closeDelay"><span></span></span>
                <p class="succes-mail-text"></p>
            </div>
        </div>

    </main>

</body>
</html>
