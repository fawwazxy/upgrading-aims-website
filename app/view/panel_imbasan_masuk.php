<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
  
  <title>Pengimbas kod QR</title>
  <script src="../../js/jsQR.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Ropa+Sans" rel="stylesheet">
  <style>
    body {
      font-family: 'Ropa Sans', sans-serif;
      color: #333;
      max-width: 640px;
      margin: 0 auto;
      position: relative;
    }
    #githubLink {
      position: absolute;
      right: 0;
      top: 12px;
      color: #2D99FF;
    }
    h1 {
      margin: 10px 0;
      font-size: 40px;
    }
    #loadingMessage {
      text-align: center;
      padding: 40px;
      background-color: #eee;
    }
    #canvas {
      width: 100%;
    }
    #output {
      margin-top: 20px;
      background: #eee;
      padding: 10px;
      padding-bottom: 0;
    }
    #output div {
      padding-bottom: 10px;
      word-wrap: break-word;
    }
    #noQRFound {
      text-align: center;
    }
  </style>
</head>
<body>
  <h1>#1 Terminal Pengimbas ID Kad - MASUK</h1>
  <!--<p>Pure JavaScript QR code decoding library.</p>-->
  <div id="loadingMessage">Unable to access video stream (please make sure you have a webcam enabled)</div>
  <canvas id="canvas" hidden></canvas>
  <div id="output" hidden>
    <div id="outputMessage">Tiada Kod QR yang dikesan.</div>
    <div hidden><b>Data:</b> <span id="outputData"></span></div>
  </div>

  <div class="select">
      <label for="videoSource">Pilih Kamera: </label><select id="videoSource"></select>
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
            location.href = "../controller/masuk_keluar_exec.php?act=masuk&nokp="+decodedIC;
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
  </script>
</body>
</html>