jQuery(function($) {
    // video();
    select_lang();
    loadApp();

    function loadApp() {
        var video = $('#video');
        var sources = video.find('source');
        var totalSources = sources.length;
        var loadedSources = 0;

        if (video.length) {
            sources.each(function() {
                var video_url = $(this).attr('data-src');
                var $source = $(this);

                var xhr = new XMLHttpRequest();
                xhr.open('GET', video_url, true);
                xhr.responseType = 'blob';

                xhr.onprogress = function(event) {
                    if (event.lengthComputable) {
                        var progress = Math.floor((event.loaded / event.total) * 100);
                        console.log(event.loaded / event.total);
                        console.log('Chargement en cours : ' + progress + '%');
                    }
                };

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

    function stepChange(nextStep) {
        var previousStep = $('section.current');
        previousStep.removeClass('current');

        $('section#' + nextStep).addClass('current'); 
    }

    function video() {
    }

    function select_lang() {
        $('#selectLang .btn--lang').on('click', function() {
            let lang = $(this).attr('data-lang');

            // Load video in right language
            let video = $('#videoPlayer #video')
            video.find('source').attr('src', "assets/medias/video/briefing-" + lang + ".mp4");
            video[0].load();
            video[0].play();
            stepChange('videoPlayer');


            function hasGetUserMedia() {
                return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
                        navigator.mozGetUserMedia || navigator.msGetUserMedia);
            }
            
            // Detect if browser is able to record the video
            if (hasGetUserMedia()) {
                var errorCallback = function(error) {
                    console.log('Reeeejected!', error);
                };
            
                // Not showing vendor prefixes
                navigator.getUserMedia({video: true}, function(stream) {
                    var video = document.querySelector('#videoPreview');
                    
                    // video.src = window.URL.createObjectURL(stream);
                    video.srcObject = stream;
                
                    // Note: onloadedmetadata doesn't fire in Chrome when using it with getUserMedia.
                    video.onloadedmetadata = function(e) {
                        console.log('onloadedmetadata');
                    };

                    var mediaRecorder = new MediaRecorder(stream);
                    var recordedChunks = [];
            
                    mediaRecorder.ondataavailable = function(event) {
                        if (event.data.size > 0) {
                            recordedChunks.push(event.data);
                        }
                    };
            
                    mediaRecorder.onstop = function() {
                        var blob = new Blob(recordedChunks, { type: 'video/webm' });
                        var formData = new FormData();
                        // formData.append('video', blob, 'video.webm');
                        // formData.append('video', blob, 'video.webm');
                        formData.append('message', "Message test pour voir si l'envoie fonctionne.")

                        console.log(formData, blob);
                        
                        /*
                        // Send video in ajax form
                        $.ajax({
                            type: 'POST',
                            url: 'send_mail.php',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                console.log(response);
                                console.log('Vidéo envoyée avec succès');
                            },
                            error: function(response) {
                                console.error('Erreur lors de l\'envoi de la vidéo', response.error);
                            }
                        });
                        */
                    };

                    mediaRecorder.start();

                    $('#stopRec').click(function() {
                        if (mediaRecorder && mediaRecorder.state === 'recording') {
                            mediaRecorder.stop();
                        }
                    });
            
                }, errorCallback);
            } else {
                alert('getUserMedia() is not supported in your browser');
            }
        });
    }
});