<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";
$id = $_SESSION['SESS_ID'];
$act = $_GET['act'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <? require "../global/header.php"; ?>
</head>
<script src="../../js/jsQR.js"></script>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include "../global/menu_top.php"; ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include "../global/menu_left.php"; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    ATTENDANCE <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> TERMINAL MANUAL
                    <a href="panel_imbasan_masuk.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_attendance_homepage.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to menu
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <label style="font-size: 18px;padding-top: 4px;">Step 1: Card ID Scanner Terminal - Clock In</label>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <!--<input name="outputData" id="outputData" value="">-->
                        <input type="hidden" name="act" id="act" value="<? echo $act; ?>">
                        <div id="loadingMessage">Unable to access video stream (please make sure you have a webcam enabled)</div>
                        <canvas id="canvas" hidden></canvas>
                        <div id="output" hidden>
                            <div id="outputMessage">No QR Code detected</div>
                            <div hidden><b>Data:</b> <span id="outputData"></span></div>
                        </div>
                        <div class="select">
                            <label for="videoSource">Choose Camera : </label><select id="videoSource"></select>
                        </div>
                        <div id="next">
                            <!--New Item Row-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<script>
    var video = document.createElement("video");
    var canvasElement = document.getElementById("canvas");
    var canvas = canvasElement.getContext("2d");
    var loadingMessage = document.getElementById("loadingMessage");
    var outputContainer = document.getElementById("output");
    var outputMessage = document.getElementById("outputMessage");
    var outputData = document.getElementById("outputData");
    function drawLine(begin, end, color) {
        canvas.beginPath();
        canvas.moveTo(begin.x, begin.y);
        canvas.lineTo(end.x, end.y);
        canvas.lineWidth = 4;
        canvas.strokeStyle = color;
        canvas.stroke();
    }
    // navigator.mediaDevices.getUserMedia(constraints)
    // .then(function(stream) {
    //   /* use the stream */
    //   video.srcObject = stream;
    //   video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
    //   video.play();
    //   requestAnimationFrame(tick);
    // })
    // .catch(function(err) {
    //   /* handle the error */
    // });

    function tick() {
        var act = $('#act').val();
        loadingMessage.innerText = "⌛ Loading video..."
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            loadingMessage.hidden = true;
            canvasElement.hidden = false;
            outputContainer.hidden = false;
            canvasElement.height = video.videoHeight;
            canvasElement.width = video.videoWidth;
            canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
            var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
            var code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });
            if (code) {
                drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
                drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
                drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
                drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
                let dataEncoded = code.data;
                console.log(dataEncoded);
                const dataEncodedArray = dataEncoded.split("#");
                let encodedIC = dataEncodedArray[0];
                var decodedIC = atob(encodedIC);
                outputMessage.hidden = true;
                outputData.parentElement.hidden = false;
                outputData.innerText = decodedIC.toString();
                if(decodedIC.length!=12){
                    start();
                }else{
                    //window.open(code.data);
                    /*location.href = "../controller/v02_aims_attendance_clock_in.php?act=in&staff_id="+decodedIC;*/
                    location.href = "../view/v02_aims_attendance_photo_log.php?act="+act+"&staff_ic="+decodedIC;

                }
            } else {
                outputMessage.hidden = false;
                outputData.parentElement.hidden = true;
                requestAnimationFrame(tick);
            }
        }else{
            requestAnimationFrame(tick);
        }
        //   requestAnimationFrame(tick);
        //   setTimeout(requestAnimationFrame(tick), 3000);
    }

    var videoSelect = document.querySelector("select#videoSource");
    var selectors = [videoSelect];

    function gotDevices(deviceInfos) {
        // Handles being called several times to update labels. Preserve values.
        var values = selectors.map(function(select) {
            return select.value;
        });
        selectors.forEach(function(select) {
            while (select.firstChild) {
                select.removeChild(select.firstChild);
            }
        });

        for (var i = 0; i !== deviceInfos.length; ++i) {
            var deviceInfo = deviceInfos[i];
            var option = document.createElement("option");
            option.value = deviceInfo.deviceId;

            if (deviceInfo.kind === "videoinput") {
                option.text = deviceInfo.label || "camera " + (videoSelect.length + 1);
                videoSelect.appendChild(option);
            } else {
                console.log("Some other kind of source/device: ", deviceInfo);
            }

            selectors.forEach(function(select, selectorIndex) {
                if (
                    Array.prototype.slice.call(select.childNodes).some(function(n) {
                        return n.value === values[selectorIndex];
                    })
                ) {
                    select.value = values[selectorIndex];
                }
            });
        }
    }

    navigator.mediaDevices
        .enumerateDevices()
        .then(gotDevices)
        .catch(handleError);

    function gotStream(stream) {
        arToolkitSource.domElement.srcObject = stream; // make stream available to console
        // video.srcObject = stream;
        // Refresh button list in case labels have become available
        return navigator.mediaDevices.enumerateDevices();
    }

    function start() {
        if (window.stream) {
            window.stream.getTracks().forEach(function(track) {
                track.stop();
                video.src="";
            });
        }
        var videoSource = videoSelect.value;
        var constraints = {
            video: {
                deviceId: videoSource ? { exact: videoSource } : undefined
            }
        };
//   navigator.mediaDevices
//     .getUserMedia(constraints)
//     .then(gotStream)
//     .then(gotDevices)
//     .catch(handleError);

// Use facingMode: environment to attemt to get the front camera on phones
        navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
            video.srcObject = stream;
            video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
            video.play();
            requestAnimationFrame(tick);
            //tick();
            //setTimeout(tick, 100); /* We launch the tick function 100ms later (see next step) */
        });
    }

    videoSelect.onchange = start;

    function handleError(error) {
        console.log("navigator.getUserMedia error: ", error);
    }
    start();

    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach( '#my_camera' );

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>
</body>
</html>