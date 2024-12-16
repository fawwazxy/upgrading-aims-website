<?
	
include ('../controller/auth.php');

require "../model/lawatan_functions.php";
require "../model/lookup.php";

?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
  
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
	<h1 align="center">Terminal Imbasan Masuk</h1>
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
			<button class="btn btn-primary" data-toggle="modal"  data-target="#myModal1" id="btn_pelawat">Tambah Pelawat</button>
			<br><br>
			
                <!-- Modal -->
                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Maklumat Pelawat</h4>
                    </div>
                
                <div class="modal-body">
                
                <form method="post" action="">
					     <div>
					   
                         <label align="left"><font color="red">** Maklumat Wajib Diisi **</font></label>						 
                           </div>
						   

                                <div class="form-group row" align="left">
                                <div class="col-xs-12">
                                <label>No. Kad Pengenalan<font color="red">&nbsp;**</font></label>
                                <input class="form-control" placeholder=" " name="nokp" id="nokp" onkeyup="getPelawat(this)" required >
                                </div>
                                </div>

                                <div class="form-group row" align="left">
                                <div class="col-xs-12">
                                <label>Nama<font color="red">&nbsp;**</font></label>
                                <input class="form-control" placeholder=" " name="nama" id="nama" required  style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                                </div>

                                <div class="form-group row" align="left">
                                <div class="col-xs-12">
                                <label>No. Telefon<font color="red">&nbsp;**</font></label>
                                <input class="form-control" placeholder=" " name="notel" id="notel" required >
                                </div>
                                </div>

                                <div class="form-group row" align="left">
                                <div class="col-xs-12">
                                <label>Nama Syarikat<!-- <font color="red">&nbsp;**</font> --></label>
                                <input class="form-control" placeholder=" " name="nama_company" id="nama_company">
                                </div>
                                </div>

                                <div class="form-group row" align="left">
                                <div class="col-xs-7">
                                <label>Jenis Kenderaan<!-- <font color="red">&nbsp;**</font> --></label>
                                <input class="form-control" placeholder=" " name="jenis_kenderaan" id="jenis_kenderaan" value="">
                                </div>
                                <div class="col-xs-5">
                                <label>No. Kenderaan<!-- <font color="red">&nbsp;**</font> --></label>
                                <input class="form-control" placeholder=" " name="no_kenderaan" id="no_kenderaan" value="">
                                </div>
                                </div>
                                
		                        <div align="right">
		                        <button type="button" onclick="pelawatAdd()" class="btn btn-success">Simpan</button>
		                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
		                        </div>
                </form>
                </div><!--modal-body-->
        
                </div>
		        <!-- /.modal-content -->
		        </div><!-- /.modal-dialog -->
		        </div><!-- /.modal -->
						
			
			
		
				<div>
				 <div class="form-group" align="left">
				 <label>Kod Kad</label><br>
				  <span id="spanKodKad"></span>
				</div>
				
			    <div class="form-group" align="left">
				 <label>Nama Pelawat</label><br>
				  <span id="spanNama"></span>
				</div>
				
				<div class="form-group" align="left">
				  <label>No. Kad Pengenalan</label><br>
				  <span id="spanNokp"></span>
				</div>

				<div class="form-group" align="left">
				  <label>No. Telefon</label><br>
				  <span id="spanNotel"></span>
				</div>
				</div>
		<button class="btn btn-primary" data-toggle="modal"  data-target="#myModal2" id="btn_pelawat">Tambah Staff</button>

		 <!-- Modal -->
                <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="left" id="myModalLabel">Pilihan Staff</h4>
                    </div>
                
                <div class="modal-body">
                
                <form method="post" action="">
                	<input type="hidden" id="kod_kad" name="kod_kad" value="">
					     <div>
					   
                         <label align="left"><font color="red">** Maklumat Wajib Diisi **</font></label>						 
                           </div>

                           		<?
                                    $staff = getStaffList();
                                    $i=1;
                                    while($list_staff = $staff->fetch_assoc()) {
                                ?>

                                <input name="nokp_staff" id="nokp_staff" type="radio" style=" transform: scale(2);" value="<?echo $list_staff['noic']?>">&nbsp;&nbsp;<?echo $list_staff['name'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$list_staff['noic'].'<br><br>';?>

                                 <?}?>

                                	
		                        <div align="right">
		                        <button type="button" onclick="pelawatAddIntoDB()" class="btn btn-success">Simpan</button>
		                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
		                        </div>
                </form>
                </div><!--modal-body-->
        
                </div>
		        <!-- /.modal-content -->
		        </div><!-- /.modal-dialog -->
		        </div><!-- /.modal -->
		       <br><br>
		 <div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							
							<!-- /.panel-heading -->
							
								<table width="100%" class="table table-striped table-bordered table-hover" id="tbl_pinjaman">
									<thead>
										<tr>
											<th>#</th>
											<th>Nama Pelawat</th>
											<th>Masa Masuk</th>
										</tr>
									</thead>
									 <tbody>
                                <?
                                    $pelawat = getLogMasukPelawatSemasa();
                                    $i=1;
                                    while($log_pelawat = $pelawat->fetch_assoc()) {
                                ?>
                                <tr>

                                  <td><?echo $i++;?></td>
                                  <td><?echo $log_pelawat['nama'];?></td>
                                  <td><?echo $log_pelawat['tarikh_masa_masuk'];?></td>
                                </tr>
                            <?}?> 
                             
                            </tbody>
								</table>
							</div>
					</div>
				</div>
	</div>
</div>

<script>

$(document).on("click", "#btn_startScam", function(){
	$("#btn_startScam").hide();
			start();
		});

function getPelawat(obj){
    	if(obj.value.length > 11){
	    	$.ajax({
	                url: "../model/lawatan_functions.php",
	                type: "POST",
	                data: {action:"getPelawatDetails",nokp:obj.value},
	                success: function (response) {
	                // you will get response from your php page (what you echo or print)   
	                var dataObject = $.parseJSON(response);             
	               // $.alert('test here:'+response.length);
	                if(response.length == 2){
						
	                	$('#nama').val("");
	                	$('#notel').val("");
						
	                }else{
						
	                	$('#nama').val(dataObject[0].nama);
	                	$('#notel').val(dataObject[0].notel);
	                }
	                

	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	             	console.log(textStatus, errorThrown);
		        }


		    });
	    }
    }

    function addPelawat(){
    	
	    if($('#kod_kad').val() != '') {

	    $('#myModal1').modal('toggle');}
	    else {
	    	$.confirm({
							title: 'Info',
							content: 'Sila imbas kad pelawat dahulu',
							buttons: {
								OK: function () {
									 //start();
								}
							}
						});
	    }

    }   
function pelawatAdd(){
    	
	    $('#spanNama').html($('#nama').val());
	    $('#spanNokp').html($('#nokp').val());
	    $('#spanNotel').html($('#notel').val());
	    $('#myModal1').modal('toggle');

    }    

    function pelawatAddIntoDB(){
    	
    	var kod_kad = $('#kod_kad').val();
	   var nokp = $('#nokp').val();
	   var nama = $('#nama').val();
	   var notel = $('#notel').val();
	   var nama_company = $('#nama_company').val();
	   var jenis_kenderaan = $('#jenis_kenderaan').val();
	   var no_kenderaan = $('#no_kenderaan').val();
	   var nokp_staff = $("input[name='nokp_staff']:checked").val();
	   var mydata = {action:"prosesTambahPelawat",
						
						kod_kad:kod_kad,
						nokp:nokp,
						nama:nama,
						notel:notel,
						nama_company:nama_company,
						jenis_kenderaan:jenis_kenderaan,
						no_kenderaan:no_kenderaan,
						nokp_staff:nokp_staff
					};

	   	$.ajax({
							url: "../model/lawatan_functions.php",
							type: "POST",
							data: mydata,
							success: function (response) {
							// you will get response from your php page (what you echo or print)   
							// var dataObject = $.parseJSON(response);             
							// $.alert('test here:'+response);
							location.reload();

						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log(textStatus, errorThrown);
						}


					});
    }   

	
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
          //window.open(code.data);
			var str = code.data;
			var pattern = str.split('-');
			var kod_kad = pattern[1]+'-'+pattern[2];
          //window.open(code.data);
			  if(str=='' || pattern[1]!='PELAWAT'){
				  start();
			  }else{
			  		 $('#spanKodKad').html(kod_kad);
			  		 $('#kod_kad').val(kod_kad);
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

  function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

  </script>
  
</body>
</html>