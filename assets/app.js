jQuery(function($) {
    // video();
    start_scripts();
    step_select_lang();
    step_ask_picture();
    step_ask_mail();
    step_take_picture();
    delete_client();
    virtual_keyboard();
    stepPrevious();
 
    init_pwa()

    // loadApp();

    // send_form();
    // popup();

    var video_to_send = null;
    var group_picture_to_send = null;
    var customer_email = null;
    var selected_lang = null;

    var previousStepId = null;


    
    function init_pwa(params) {

        var cacheName = 'my-cache';
    
        // Fichiers à vérifier
        var videoUrls = [
            '/assets/medias/video/briefing-de.mp4', 
            '/assets/medias/video/briefing-en.mp4', 
            '/assets/medias/video/briefing-fr.mp4', 
            '/assets/medias/video/briefing-nl.mp4', 
        ];
    
        var progressBar = $('.loadingScreen-indicator-value');

        var progressStep = 100 / videoUrls.length;
        var currentProgress = 0;
    
        function updateProgress() {
            currentProgress += progressStep;
            progressBar.text(currentProgress + '%');
        }
    
        function cacheVideo(url) {
            caches.open(cacheName).then(function(cache) {
                cache.match(url).then(function(response) {
                    if (!response) {
                        // Si la vidéo n'est pas en cache, l'ajouter
                        cache.add(url).then(function() {
                            console.log('Vidéo ajoutée au cache:', url);
                            updateProgress();
                        }).catch(function(error) {
                            console.error('Erreur lors de l\'ajout de la vidéo au cache:', error);
                        });
                    } else {
                        console.log('La vidéo est déjà en cache:', url);
                        updateProgress();
                    }
                }).catch(function(error) {
                    console.error('Erreur lors de la mise en cache de la vidéo:', error);
                });
            });
        }
    
        // Charger chaque vidéo une première fois
        videoUrls.forEach(function(url) {
            var video = document.createElement('video');
            video.src = url;
            video.css('display', 'none');
            video.addEventListener('loadedmetadata', function() {
                console.log('Vidéo chargée:', url);
                cacheVideo(url);

                video.remove();
            });
        });
    
        // Masquer l'écran de chargement une fois la mise en cache terminée
        Promise.all(videoUrls.map(cacheVideo)).then(function() {
            $('#loader-container').hide();
        }).catch(function(error) {
            console.error('Erreur lors de la mise en cache des vidéos:', error);
            // Gérer les erreurs si nécessaire
        });
        
    }

    
    function loadApp() {
        var videos = [
            { path: '../assets/medias/video/briefing-de.mp4' },
            { path: '../assets/medias/video/briefing-fr.mp4' },
            { path: '../assets/medias/video/briefing-en.mp4' },
            { path: '../assets/medias/video/briefing-nl.mp4' }
        ];
    
        var maVideo = $('#video')[0];
        
        var videosToLoad = videos.length;
    
        videos.forEach(function(video) {
            var videoData = localStorage.getItem(video.path);
            
            // Video found in localStorage
            if (videoData) {
                var blob = base64toBlob(videoData);
                var videoURL = URL.createObjectURL(blob);
                maVideo.src = videoURL;
                videosToLoad--;
    
                // Vérifier si toutes les vidéos ont été chargées
                if (videosToLoad === 0) {
                    // Fermer l'écran de chargement
                    $('.loadingScreen-indicator-value').text("Vidéos déjà chargées.");
                    $('body').removeClass('loading');
                }

            // No video in localStorage
            } else {
                var xhr = new XMLHttpRequest();

                // Placez xhr.onload avant d'ouvrir la requête
                xhr.onload = function() {
                    var reader = new FileReader();
    
                    console.log('Pxhr.onload');
                    reader.onloadend = function() {
    
                        console.log('reader.onloadend');
    
                        var base64Data = reader.result.split(',')[1];
                        localStorage.setItem(video.path, base64Data);
                        maVideo.src = "data:video/mp4;base64," + base64Data;
    
                        // Vérifier si toutes les vidéos ont été chargées
                        videosToLoad--;
                        console.log("Ajouté au storage" + video.path);
                        if (videosToLoad === 0) {
                            // Fermer l'écran de chargement
                            $('.loadingScreen-indicator-value').text(video.path + "ajoutée");
                            $('body').removeClass('loading');
                        }
                    };
                    reader.readAsDataURL(xhr.response);
                };
    
                xhr.open('GET', video.path, true);
                xhr.responseType = 'blob';
                
                console.log('Pas de vidéos dans le localStorage.');
                xhr.send();
            }
        });
    }

    function base64toBlob(base64Data) {
        var sliceSize = 1024;
        var byteCharacters = atob(base64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);
            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
            var byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }

        return new Blob(byteArrays, { type: 'video/mp4' });
    }
    
    function stepChange(nextStep) {
        var previousStep = $('section.current');
        previousStepId = previousStep.attr('id');
        previousStep.removeClass('current');

        $('section#' + nextStep).addClass('current'); 
    }

    function stepPrevious() {
        $('.btn--previous').on('click', function() {

            let parent_section = $(this).parent().attr('id');

            // console.log("section parent : " + parent_section);
            // console.log(parent_section == "takePicture");

            // Exeptions
            if(parent_section == "takePicture") {
                stepChange('askPicture');

            // Normal behavior
            }else{
                stepChange(previousStepId);
            }
        });
    }

    function delete_client() {
        $('.btn--deleteClient').on('click', function() {
            let id = $(this).attr('data-delete');
            let target = $(this).parent().parent();
            var formData = new FormData();
            formData.append('id', id);
            
            popup('deletion-warning', 10000, $('[data-popup="deletion-warning"] .btn'));
            $('[data-popup="deletion-warning"] .btn--confirm').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: 'delete_client.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        target.slideUp(600);
                        // console.log(response);

                        location.reload();
                    },
                    error: function(response) {
                        popup("deletion-failed");
                        // console.log(response);

                        location.reload();
                    }
                });
            });    
        });
    }

    function popup(data_popup, opening_time = 7000, click_close_trigger = null) {
        
        var popup = $(".popup[data-popup='" + data_popup + "']");
        
        popup.addClass('popup--open');
        if (!popup.hasClass('popup-infinite')) {
            var timer;
            var progress_bar = popup.find('.popup-closeDelay > span');    
    
            // Animate a progression bar for popup
            var startTime = Date.now();
            var endTime = startTime + opening_time;
    
            function updateProgressBar() {
                var currentTime = Date.now();
                var elapsedTime = currentTime - startTime;
                var progress = (elapsedTime / opening_time) * 100;
    
                progress_bar.css('width', progress + "%");
    
                if (currentTime < endTime) {
                    // requestanimation is used to close the popup after delay
                    // timber will be killed when closing popup to prevent affecting the upcommings ones 
                    timer = requestAnimationFrame(updateProgressBar);
                } else {
                    popup.removeClass('popup--open');
                }
            }
    
            updateProgressBar();
    
            if(click_close_trigger != null) {
                click_close_trigger.on('click', function(){
                    // kill animationframe so it does not affect upcomming popups
                    cancelAnimationFrame(timer);
                    popup.removeClass('popup--open')
                });
            }
        }
    }

    function closePopup(data_popup) {
        var popup_to_close = $(".popup[data-popup='" + data_popup + "']");
        if (popup_to_close.hasClass('popup-infinite')) {
            popup_to_close.removeClass('popup--open');
        }
    }
    


    
    function step_select_lang() {
        $('#selectLang .btn--lang').on('click', function() {
            let delay = 4000;
            let lang = $(this).attr('data-lang');
            $('body').attr('data-lang', lang);
            $('html').attr('lang', lang);

            var videoPath = '../assets/medias/video/briefing-' + lang + '.mp4';

            $('#video')[0].src = videoPath;

            
            popup("brief-begin", delay);
            setTimeout(() => {
                step_briefing();
            }, delay);
            
            /*
            // Construction de l'URL de la vidéo en fonction de la langue sélectionnée
            var videoPath = '../assets/medias/video/briefing-' + selected_lang + '.mp4';

            // Get video from local storage
            var maVideo = $('#video')[0];
            var videoData = localStorage.getItem(videoPath);

            if (videoData) {

                // Load video in right language
                var blob = base64toBlob(videoData);
                var videoURL = URL.createObjectURL(blob);
                maVideo.src = videoURL;

                popup("brief-begin", delay);
                setTimeout(() => {
                    step_briefing();
                }, delay);
            } else {
                console.error('La vidéo pour la langue sélectionnée n\'a pas été préalablement chargée.');
            }
            */


            
        });
    }

    function step_briefing() {

        stepChange('briefing');


        // Change to briefing explaination and ask email after
        let video = $('#briefing #video');
        let source = video.find('source');
        if (selected_lang) {
            // This line displays a short video to avoid loosing 7 minutes of your life
            // source.attr('src', 'assets/medias/video/debug.mp4')
            source.attr('src', 'assets/medias/video/briefing-' + selected_lang + '.mp4')
        }
        var video_preview = $('#briefing .videoPreview');
        video[0].load();
        video[0].play();

        function hasGetUserMedia() {
            return !!(navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
        }

        
        // Detect if browser is able to record the video
        if (hasGetUserMedia()) {
            var errorCallback = function(error) {
                // console.log('Reeeejected!', error);
            };

            var constraints = {
                video: {
                    frameRate: { ideal: 6 }
                },
            };
            
            navigator.mediaDevices.getUserMedia(constraints)
                .then(function(stream) {
                
                    video_preview.prop('srcObject', stream);
                
                    // Note: onloadedmetadata doesn't fire in Chrome when using it with getUserMedia.
                    /* video_preview.onloadedmetadata = function(e) {
                        console.log('onloadedmetadata');
                    }; */
    
                    var mediaRecorder = new MediaRecorder(stream, {
                        mimeType: 'video/webm; codecs=vp9',
                        bufferSize: 10240 * 10240
                    });
                    var recordedChunks = [];
            
                    mediaRecorder.ondataavailable = function(event) {
                        if (event.data.size > 0) {
                            recordedChunks.push(event.data);
                        }
                    };



                    mediaRecorder.start();

                    $('#briefing #video').on('ended', function() {
                        if (mediaRecorder && mediaRecorder.state === 'recording') {
                            mediaRecorder.stop();
                        }
                    });

                    mediaRecorder.onstop = function() {
                        // Convert recorded video into a blob to make it sendable
                        video_to_send = new Blob(recordedChunks, { type: 'video/webm' });

                        stepChange('askPicture');
                    };




                })
                .catch(function(error) {
                    console.error('Error accessing webcam:', error);
                });
        } else {
            alert('getUserMedia() is not supported in your browser');
        }
    }

    function step_ask_picture() {
        $('section#askPicture .btn--confirm').on('click', function(){
            stepChange('takePicture');
        });

        $('section#askPicture .btn--cancel').on('click', function(){
            stepChange('email');

            // Unset picture in case user stepped back from email and takePicture
            group_picture_to_send = null;
        });
    }

    function step_take_picture() {

        var video_preview = $('#takePicture .videoPreview');
        var capturedImage = $('#takePicture .takePicture-result-capturedImage');
        var canvas = $('#takePicture .takePicture-result-canva')[0];

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                video_preview.prop('srcObject', stream);
                // $('#takePicture .videoPreview')[0].play();
                
            })
            .catch(function(error) {
                console.error('Error accessing webcam:', error);
            });

        $('.btn--takePicture').on('click', function() {

            var timer_btn = $(this);
            timer_btn.addClass('timerOn');

            var timer_lenght = 10000;

            // Animate a progression bar for popup
            var startTime = Date.now();
            var endTime = startTime + timer_lenght;

            function updateCountdown() {
                var currentTime = Date.now();
                var remainingTime = Math.max(0, endTime - currentTime);
                var remainingSeconds = Math.ceil(remainingTime / 1000); // Round to seconds

                timer_btn.find('span').text(remainingSeconds + "s");

                if (remainingTime > 0) {
                    requestAnimationFrame(updateCountdown);
                } else {

                    // Take picture
                    canvas.width = video_preview[0].videoWidth;
                    canvas.height = video_preview[0].videoHeight;
                    const context = canvas.getContext('2d');
                    context.drawImage(video_preview[0], 0, 0, canvas.width, canvas.height);

                    // Draw watermark (logo) on the bottom right corner
                    var watermark = $('.takePicture-preview-watermark')[0];

                    // Set width and height while keeping aspect Ratio
                    var watermarkWidth = 150;
                    var watermarkHeight = (watermarkWidth / watermark.width) * watermark.height;
                    var watermarkX = 10; // 10 pixels from the left edge
                    var watermarkY = canvas.height - watermarkHeight - 10; // 10 pixels from the bottom edge
                    context.save();
                    context.scale(-1, 1);
                    context.drawImage(video_preview[0], -canvas.width, 0, canvas.width, canvas.height);
                    context.restore();
                    
                    // Dessine le watermark à la position ajustée
                    context.drawImage(watermark, canvas.width - watermarkX - watermarkWidth, watermarkY, watermarkWidth, watermarkHeight);
                                        
                    // Display picture
                    capturedImage.src = canvas.toDataURL('image/png');
                    capturedImage.attr('src', capturedImage.src);

                    timer_btn.removeClass('timerOn');
                    $('section#takePicture').addClass('takePicture--showResult');
                }
            }

            updateCountdown();
        });

        $('#takePicture .btn--confirm').on('click', function() {         
            // Convert image into a blob to make in sendable
            canvas.toBlob(function(blob) {
                group_picture_to_send = blob;
            }, 'image/png');

            $('section#takePicture').removeClass('takePicture--showResult');

            stepChange('email');
        });
        
        $('#takePicture .btn--cancel').on('click', function() {
            capturedImage.attr('src', '');
            $('section#takePicture').removeClass('takePicture--showResult');
        });
    }

    function step_ask_mail() {

        var form = $('#email .email-form');
        var email_field = $('#email_field');

        form.find('.btn--confirm').on('click', function() {

            if (email_field.val() == "") {
                popup("form-empty", 7000, email_field);
            }

            // Check if e-mail is valid
            if (email_field.val()) {
                var is_email_valid = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email_field.val());
                if(!is_email_valid) {
                    popup("form-error", 7000, email_field);

                // If e-mail is valid store it 
                }else {
                    customer_email = email_field.val();
                    popup("form-succes", 5000, email_field);
                    send_form();
                }
            }
        });
            
    }

    function send_form() {

        popup('form-sending', 15000, $('#email .email-form input'));

        var formData = new FormData();

        formData.append('video', video_to_send, 'video.webm');

        if(group_picture_to_send !== null) {
            formData.append('image', group_picture_to_send, 'picture.png');
        }        
        
        formData.append('lang', selected_lang);

        formData.append('customer_email', customer_email)
        
        // Send video in ajax form
        $.ajax({
            type: 'POST',
            url: 'send_mail.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {

                closePopup("form-sending");
                popup('succes', 7000);
                setTimeout(() => {
                    location.reload();
                }, 7000);

                // console.log(response);
            },
            error: function(response) {
                closePopup("form-sending");
                popup('succes', 10000);
                setTimeout(() => {
                    location.reload();
                }, 10000);

                // console.log(response);
            }
        });
    }

    function start_scripts() {

        popup('failed-mails-sending');

        var formData = new FormData();
        
        // Send video in ajax form
        $.ajax({
            type: 'POST',
            url: 'start_scripts.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('[data-popup="failed-mails-sending"]').removeClass('popup--open');
                popup('failed-mails-success', 5000);
                $('.succes-mail-text').html(response);
            },
            error: function(response) {
                $('[data-popup="failed-mails-sending"]').removeClass('popup--open');
                popup('failed-mails-error', 5000);
                $('.failed-mail-text').html(response);
            }
        });
    }

    function virtual_keyboard() {
        const Keyboard = {
            elements: {
                main: null,
                keysContainer: null,
                keys: []
            },
        
            eventHandlers: {
                oninput: null,
                onclose: null
            },
        
            properties: {
                value: "",
                capsLock: false
            },
        
            init() {
                // Create main elements
                this.elements.main = $('<div></div>');
                this.elements.inputPreview = $('<div></div>');
                this.elements.inputPreviewText = $('<span></span>');
                this.elements.keysContainer = $('<div></div>');
        
                // Setup main elements
                this.elements.main.addClass("keyboard keyboard--hidden");
                this.elements.keysContainer.addClass("keyboard-keys");
                this.elements.inputPreview.addClass("keyboard-preview");
                this.elements.keysContainer.append(this._createKeys());
        
                this.elements.keys = this.elements.keysContainer.find(".keyboard-key");
        
                // Add to DOM
                this.elements.inputPreview.append(this.elements.inputPreviewText);
                this.elements.main.append(this.elements.inputPreview);
                this.elements.main.append(this.elements.keysContainer);
                $("body").append(this.elements.main);
        
                // Automatically use keyboard for elements with .use-keyboard-input
                $(".use-keyboard-input").each(function () {
                    $(this).on("focus", () => {
                        Keyboard.open($(this).val(), (currentValue) => {
                            $(this).val(currentValue);
                        });
                    });
                });
            },
        
            _createKeys() {
                const fragment = $(document.createDocumentFragment());
                const keyLayout = [
                    "@", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0",
                    "a", "z", "e", "r", "t", "y", "u", "i", "o", "p",
                    "q", "s", "d", "f", "g", "h", "j", "k", "l", "m",
                    "w", "x", "c", "v", "b", "n", ".", "backspace",
                    "caps", 'done'
                ];
        
                // Creates HTML for an icon
                const createIconHTML = (icon) => {
                    return icon;
                };
        
                // Build the keyboard
                keyLayout.forEach(key => {
                    const keyElement = $("<button></button>");
                    const insertLineBreak = ["backspace", "p", "m", "backspace"].indexOf(key) !== -1;
        
                    // Add attributes/classes
                    keyElement.attr("type", "button");
                    keyElement.addClass("keyboard-key");
        
                    switch (key) {
                        case "backspace":
                            keyElement.addClass("keyboard-key--wide");
                            keyElement.html(createIconHTML('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 9L11 15M11 9L17 15M2.72 12.96L7.04 18.72C7.392 19.1893 7.568 19.424 7.79105 19.5932C7.9886 19.7432 8.21232 19.855 8.45077 19.9231C8.72 20 9.01334 20 9.6 20H17.2C18.8802 20 19.7202 20 20.362 19.673C20.9265 19.3854 21.3854 18.9265 21.673 18.362C22 17.7202 22 16.8802 22 15.2V8.8C22 7.11984 22 6.27976 21.673 5.63803C21.3854 5.07354 20.9265 4.6146 20.362 4.32698C19.7202 4 18.8802 4 17.2 4H9.6C9.01334 4 8.72 4 8.45077 4.07689C8.21232 4.14499 7.9886 4.25685 7.79105 4.40675C7.568 4.576 7.392 4.81067 7.04 5.28L2.72 11.04C2.46181 11.3843 2.33271 11.5564 2.28294 11.7454C2.23902 11.9123 2.23902 12.0877 2.28294 12.2546C2.33271 12.4436 2.46181 12.6157 2.72 12.96Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'));
        
                            keyElement.on("click", () => {
                                this.properties.value = this.properties.value.substring(0, this.properties.value.length - 1);
                                this._triggerEvent("oninput");
                            });
        
                            break;
        
                        case "caps":
                            keyElement.addClass("keyboard-key--wide keyboard-key--activatable");
                            keyElement.html(createIconHTML('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 3H3M18 13L12 7M12 7L6 13M12 7V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'));
        
                            keyElement.on("click", () => {
                                this._toggleCapsLock();
                                keyElement.toggleClass("keyboard-key--active", this.properties.capsLock);
                            });
        
                            break;
        
                        case "enter":
                            keyElement.addClass("keyboard-key--wide");
                            keyElement.html(createIconHTML("keyboard_return"));
        
                            keyElement.on("click", () => {
                                this.properties.value += "\n";
                                this._triggerEvent("oninput");
                            });
        
                            break;
        
                        case "space":
                            keyElement.addClass("keyboard-key--extra-wide");
                            keyElement.html(createIconHTML("space_bar"));
        
                            keyElement.on("click", () => {
                                this.properties.value += " ";
                                this._triggerEvent("oninput");
                            });
        
                            break;
        
                        case "done":
                            keyElement.addClass("keyboard-key--wide keyboard-key--success");
                            keyElement.html(createIconHTML('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 11.0857V12.0057C21.9988 14.1621 21.3005 16.2604 20.0093 17.9875C18.7182 19.7147 16.9033 20.9782 14.8354 21.5896C12.7674 22.201 10.5573 22.1276 8.53447 21.3803C6.51168 20.633 4.78465 19.2518 3.61096 17.4428C2.43727 15.6338 1.87979 13.4938 2.02168 11.342C2.16356 9.19029 2.99721 7.14205 4.39828 5.5028C5.79935 3.86354 7.69279 2.72111 9.79619 2.24587C11.8996 1.77063 14.1003 1.98806 16.07 2.86572M22 4L12 14.01L9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'));
        
                            keyElement.on("click", () => {
                                this.close();
                                this._triggerEvent("onclose");
                            });
        
                            break;
        
                        default:
                            keyElement.text(key.toLowerCase());
        
                            keyElement.on("click", () => {
                                this.properties.value += this.properties.capsLock ? key.toUpperCase() : key.toLowerCase();
                                this._triggerEvent("oninput");
                                // this.elements.inputPreview.text(this.properties.value);
                            });
        
                            break;
                    }
        
                    fragment.append(keyElement);
        
                    if (insertLineBreak) {
                        fragment.append(document.createElement("br"));
                    }
                });
        
                return fragment;
            },
        
            _triggerEvent(handlerName) {
                if (typeof this.eventHandlers[handlerName] == "function") {
                    this.eventHandlers[handlerName](this.properties.value);
                    this.elements.inputPreviewText.text(this.properties.value);
                }
            },
        
            _toggleCapsLock() {
                this.properties.capsLock = !this.properties.capsLock;
        
                for (const key of this.elements.keys) {
                    if (key.childElementCount === 0) {
                        key.textContent = this.properties.capsLock ? key.textContent.toUpperCase() : key.textContent.toLowerCase();
                    }
                }
            },
        
            open(initialValue, oninput, onclose) {
                this.properties.value = initialValue || "";
                this.eventHandlers.oninput = oninput;
                this.eventHandlers.onclose = onclose;
                this.elements.main.removeClass("keyboard--hidden");
            },
        
            close() {
                this.properties.value = "";
                this.eventHandlers.oninput = oninput;
                this.eventHandlers.onclose = onclose;
                this.elements.main.addClass("keyboard--hidden");
            }
        };

        Keyboard.init();
        
        $("input, textarea").on("focus", function() {
            var field = $(this);
            Keyboard.open($(this).val(), (currentValue) => {
                field.val(currentValue);
            });
        });
    }
});