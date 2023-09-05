jQuery(function($) {
    // video();
    step_select_lang();
    step_ask_picture();
    step_ask_mail();
    step_take_picture();
    // send_form();
    // popup();
    // loadApp();
    // loadApp_2();

    var video_to_send = null;
    var group_picture_to_send = null;
    var customer_email = null;
    var selected_lang = null;

    var previousStepId = null;

    function loadApp_2() {
        var video = $('#video');
        video[0].play();
    }

    function loadApp() {
        var video = $('#video');
        var sources = video.find('source');
        var totalSources = sources.length;
        var loadedSources = 0;

        if (video.length) {
            sources.each(function() {
                let source = $(this);
                var video_url = $(this).attr('data-src');

                var xhr = new XMLHttpRequest();
                xhr.open('GET', video_url, true);
                xhr.responseType = 'blob';

                
                // Get and display current download progress
                xhr.onprogress = function(event) {
                    if (event.lengthComputable) {
                        var progress = Math.floor((event.loaded / event.total) * 100);
                        $('.loadingScreen-indicator-value').text(progress);
                    }
                };

                // Hide loading screen
                xhr.onload = function() {
                    loadedSources++;

                    if (loadedSources === totalSources) {
                        $('body').removeClass('loading');
                        console.log('Toutes les vidéos ont été chargées.');
                    }
                };

                xhr.send();
            });
        }
    }

    function send_form() {

        console.log('sendForm')

        popup('form-sending', 15000, $('#email .email-form input'));

        var mail_message_fr = "<h1>Merci pour votre visite chez Sniper Zone !</h1><br/><p>Cher client, merci d'être venu chez Sniper Zone. En pièce jointe, vous trouverez une vidéo prouvant votre prise de connaissance du règlement ainsi qu'une photo de groupe (uniquement is vous aviez sélectionné l'option lors du briefing).</p><p>Dans l'attente de vous revoir pour une autre partie !</p><p>Sniper Zone</p>";

        var mail_message_de = "<h1>Vielen Dank für Ihren Besuch bei Sniper Zone!</h1><br/><p>Lieber Kunde, vielen Dank, dass Sie zu Sniper Zone gekommen sind. Im Anhang finden Sie ein Video, das Ihre Kenntnis der Regeln bestätigt, sowie ein Gruppenfoto (nur, wenn Sie die Option während der Einweisung ausgewählt haben).</p><p>Wir freuen uns darauf, Sie wieder für eine weitere Runde zu sehen!</p><p>Sniper Zone</p>";

        var mail_message_en = "<h1>Thank you for visiting Sniper Zone!</h1><br/><p>Dear customer, thank you for coming to Sniper Zone. Attached, you will find a video confirming your acknowledgment of the rules, as well as a group photo (only if you selected the option during the briefing).</p><p>We look forward to seeing you again for another game!</p><p>Sniper Zone</p>";

        var mail_message_nl = "<h1>Bedankt voor uw bezoek aan Sniper Zone!</h1><br/><p>Beste klant, bedankt dat u bij Sniper Zone bent geweest. In de bijlage vindt u een video die uw kennis van de regels bevestigt, evenals een groepsfoto (alleen als u de optie tijdens de briefing hebt geselecteerd).</p><p>We kijken ernaar uit om u weer te zien voor een volgend spel!</p><p>Sniper Zone</p>";

        var formData = new FormData();
        formData.append('video', video_to_send, 'proof.mp4');

        console.log(group_picture_to_send !== null);

        if(group_picture_to_send !== null) {
            formData.append('image', group_picture_to_send, 'captured_image.png');
        }

        if(selected_lang == "fr") {
            formData.append('message', mail_message_fr);

        }else if (selected_lang == "de") {
            formData.append('message', mail_message_de);
            
        }else if (selected_lang == "en") {
            formData.append('message', mail_message_en);
            
        }else if (selected_lang == "nl") {
            formData.append('message', mail_message_nl);
        }
        formData.append('customer_email', customer_email)
        
        // Send video in ajax form
        
        $.ajax({
            type: 'POST',
            url: 'send_mail.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {

                $('#email .email-form input').trigger('click');
                popup('succes', 7000);
                setTimeout(() => {
                    // location.reload();
                }, 7000);

                console.log(response);
            },
            error: function(response) {
                $('#email .email-form input').trigger('click');
                popup('succes', 7000);
                setTimeout(() => {
                    // location.reload();
                }, 7000);

                console.log(response);
            }
        });
    }

    function popup(data_popup, opening_time = 7000, click_close_trigger = null) {
        
        var popup = $(".popup[data-popup='" + data_popup + "']");
        var progress_bar = popup.find('.popup-closeDelay > span');
        popup.addClass('popup--open');

        // Animate a progression bar for popup
        var startTime = Date.now();
        var endTime = startTime + opening_time;

        function updateProgressBar() {
            var currentTime = Date.now();
            var elapsedTime = currentTime - startTime;
            var progress = (elapsedTime / opening_time) * 100;

            progress_bar.css('width', progress + "%");

            if (currentTime < endTime) {
                requestAnimationFrame(updateProgressBar);
            } else {
                popup.removeClass('popup--open');
            }
        }

        updateProgressBar();

        if(click_close_trigger != null) {
            click_close_trigger.on('click', function(){
                popup.removeClass('popup--open')
            });
        }
    }

    function step_ask_mail() {

        var form = $('#email .email-form');
        var email_field = form.find('input');

        form.find('.email-form-submit').on('click', function() {

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

    function step_ask_picture() {
        $('section#askPicture .btn--acceptPic').on('click', function(){
            stepChange('takePicture');
        });

        $('section#askPicture .btn--refusePic').on('click', function(){
            popup("brief-begin", 4000);
            console.log(group_picture_to_send);
            setTimeout(() => {
                step_briefing();
            }, 4000);
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

            var timer_lenght = 1000;

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
                    // Display picture
                    capturedImage.src = canvas.toDataURL('image/png');
                    capturedImage.attr('src', capturedImage.src);

                    timer_btn.removeClass('timerOn');
                    $('section#takePicture').addClass('takePicture--showResult');
                }
            }

            updateCountdown();
        });

        $('#takePicture .btn--validatePic').on('click', function() {         
            // Convert image into a blob to make in sendable
            canvas.toBlob(function(blob) {
                group_picture_to_send = blob;
            }, 'image/png');

            $('section#takePicture').removeClass('takePicture--showResult');

            // stepClose();

            console.log(group_picture_to_send);

            popup("brief-begin", 4000);
            setTimeout(() => {
                step_briefing();
                
            }, 4000);
        });
        
        $('#takePicture .btn--redoPic').on('click', function() {
            capturedImage.attr('src', '');
            $('section#takePicture').removeClass('takePicture--showResult');
            console.log(group_picture_to_send);
        });
    }

    function stepChange(nextStep) {
        var previousStep = $('section.current');
        previousStep.removeClass('current');

        previousStepId = previousStep.attr('id');

        $('section#' + nextStep).addClass('current'); 
        
        $('.btn--previous').on('click', function() {
            stepChange(previousStepId);
        });
    }

    function step_briefing() {

        stepChange('briefing');

        // Change to briefing explaination and ask email after
        let video = $('#briefing #video');
        var video_preview = $('#briefing .videoPreview');
        video[0].play();

        function hasGetUserMedia() {
            return !!(navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
        }

        
        // Detect if browser is able to record the video
        if (hasGetUserMedia()) {
            var errorCallback = function(error) {
                console.log('Reeeejected!', error);
            };
            
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                
                    video_preview.prop('srcObject', stream);
                
                    // Note: onloadedmetadata doesn't fire in Chrome when using it with getUserMedia.
                    video_preview.onloadedmetadata = function(e) {
                        // console.log('onloadedmetadata');
                    };
    
                    var mediaRecorder = new MediaRecorder(stream);
                    var recordedChunks = [];
            
                    mediaRecorder.ondataavailable = function(event) {
                        if (event.data.size > 0) {
                            recordedChunks.push(event.data);
                        }
                    };
            
                    mediaRecorder.onstop = function() {
                        // Convert recorded video into a blob to make it sendable
                        video_to_send = new Blob(recordedChunks, { type: 'video/mp4' });
    
                        stepChange('email');
                        // stepClose();
                    };
    
                    mediaRecorder.start();
    
                    $('#briefing #video').on('ended', function() {
                        if (mediaRecorder && mediaRecorder.state === 'recording') {
                            mediaRecorder.stop();
                        }
                    });                })
                .catch(function(error) {
                    console.error('Error accessing webcam:', error);
                });
        } else {
            alert('getUserMedia() is not supported in your browser');
        }
    }

    function step_select_lang() {
        $('#selectLang .btn--lang').on('click', function() {
            let lang = $(this).attr('data-lang');
            $('body').attr('data-lang', lang);
            $('html').attr('lang', lang);

            selected_lang = lang;

            // Load video in right language
            stepChange('askPicture');
        });
    }
});