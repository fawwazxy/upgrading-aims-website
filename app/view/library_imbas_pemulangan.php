<?
	
include ('../controller/auth.php');

require "../model/library_functions.php";

?>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>
	  <script src="../../js/jsQR.js"></script>
	  <style>
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
<body class="panel">
<div class="col-lg-12">
	 <h1 align="center">Terminal Imbasan Pemulangan</h1>
	<div class="col-lg-6">
			  <!--<p>Pure JavaScript QR code decoding library.</p>-->
			  <div id="loadingMessage">🎥 Unable to access video stream (please make sure you have a webcam enabled)</div>
			  <canvas id="canvas" hidden></canvas>
			  <div id="output" hidden>
				<div id="outputMessage">Tiada Kod QR yang dikesan.</div>
				<div hidden><b>Data:</b> <span id="outputData"></span></div>
			  </div>

			  <div class="select">
				  <label for="videoSource">Pilih Kamera: </label><select id="videoSource"></select>
			</div>
	</div>
	<div class="col-lg-6">
		<div class="row">
                <div class="col-lg-12">

                        <div class="panel panel-default">
                        <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Log Pemulangan</label>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="10%">Bil.</th>
                                        <th >Nama</th>
                                        <th >Bahan dipulangkan</th>
                                        <th >Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?  
								    $tarikh = date('Y-m-d');
                                    $pemulangan = logPemulangan($tarikh);
                                    $i=1;
                                   while($log_pemulangan = $pemulangan->fetch_assoc()) {
									   $tarikh_hantar=$log_pemulangan['tarikh_hantar'];
									   $tarikh_akhir=$log_pemulangan['tarikh_akhir'];
                                ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $log_pemulangan['nama'];?></td>
                                        <td><?echo $log_pemulangan['nama_bahan'];?></td>
                                        <td><?
											if(strtotime($tarikh_hantar) < strtotime($tarikh_akhir)){
												echo '<strong><font size="3" color="green">Hantar Awal</font></strong>';
											}else if(strtotime($tarikh_hantar) == strtotime($tarikh_akhir)){
												echo '<strong><font size="3" color="blue">Hantar Tepat Masa</font></strong>';
											}else{
												echo '<strong><font size="3" color="red">Hantar Lewat</font></strong>';
											}
										
										?>
										</td>
                                    </tr>
                                <?}?> 
                                 
                                </tbody>
                            </table>
                        </div>

                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
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
          outputMessage.hidden = true;
          outputData.parentElement.hidden = false;
          outputData.innerText = code.data;
		  var str = code.data; 
		  var pattern = str.split('-');
      var id_naskah = pattern[2];
      if(str=='' || pattern[0]!='elib'){
			  start();
		  }else{
			  $.ajax({
                url: "../model/library_functions.php",
                type: "POST",
                data: {action:"checkPemulangan", id_naskah:id_naskah},
                success: function (response) {
					var dataObject = $.parseJSON(response); 
					//$.alert('test here:'+response.length);
					if(dataObject[0].bil > 0){
						 $.ajax({
							url: "../model/library_functions.php",
							type: "POST",
							data: {action:"libraryPemulangan", id_naskah:id_naskah},
							success: function (result) {
									 $.confirm({
										title: 'Info',
										content: 'Telah Berjaya Dipulangkan',
										buttons: {
											OK: function () {
												 location.href = "library_imbas_pemulangan.php";
											}
										}
									});
									
								
							},
								error: function(jqXHR, textStatus, errorThrown) {
								 console.log(textStatus, errorThrown);
								 //location.href = "acara_sumber_info.php?id_sesi=<?echo $id_sesi?>";
							 }


							});     
					}else{
						 $.confirm({
							title: 'Info',
							content: 'Tiada rekod untuk Pemulangan',
							buttons: {
								OK: function () {
									 start();
								}
							}
						});
						
					}
                },
                    error: function(jqXHR, textStatus, errorThrown) {
                     console.log(textStatus, errorThrown);
                 }


                });     
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