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
	<h1 align="center">Terminal Imbasan Pinjaman</h1>
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
	<button class="btn btn-primary" data-toggle="modal"  data-target="#myModal" id="btn_peminjam">Peminjam</button>
		<br><br>
			
						 
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Maklumat Pinjaman</h4>
                    </div>
                
                <div class="modal-body">
                
                <form method="post" action="">
					     <div>
					   
                         <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>						 
                           </div>
						   
								<div class="form-group"> 
								<label class="control-label">No. Kad Pengenalan<font color="red">**</font></label>
								<input class="form-control" id="nokp" name="nokp" type="text" onkeyup="getPeminjam(this)" required />
							</div> 
							<div class="form-group"> 
								<label class="control-label">Nama<font color="red">**</font></label>
								<input class="form-control" id="nama" name="nama" type="text" required />
							</div>
							<div class="form-group"> 
								<label class="control-label">No. Telefon<font color="red">**</font></label>
								<input class="form-control" id="notel" name="notel" type="text" required />
							</div>
							<div class="form-group"> 
								<label class="control-label">Bil. Hari Dipinjam<font color="red">**</font></label>
								<input class="form-control" id="bil_hari_pinjam" name="bil_hari_pinjam" type="number" min="1" max="14" value="1" required />
							</div>
				             
    						
											
                        <div class="modal-footer">
                        <button type="button" onclick="peminjamProses()" class="btn btn-primary">Simpan</button>
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
				 <label>Nama Peminjam</label><br>
				  <span id="spanNama"></span>
				</div>
				
				<div class="form-group" align="left">
				  <label>No KP</label><br>
				  <span id="spanNokp"></span>
				</div>

				<div class="form-group" align="left">
				  <label>Telefon</label><br>
				  <span id="spanNotel"></span>
				</div>
			</div>
		<div class="row">
			<div class="panel-heading" align="right">
			
			<button  id="btn_startScam" class="btn btn-primary">Tambah Pinjaman</button>
		
		</div>
		 <div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							
							<!-- /.panel-heading -->
							
								<table width="100%" class="table table-striped table-bordered table-hover" id="tbl_pinjaman">
									<thead>
										<tr>
											<th>#</th>
											<th>Nama Bahan</th>
											<th>Tarikh Pinjam</th>
											<th>Tarikh Tamat</th>
											<th>Tindakan</th>
										</tr>
									</thead>
									<tbody>
									<tr>
									</tr>
									
									</tbody>

								</table>

							</div>
							<button class="btn btn-success" id="btn_pinjaman"  onclick="prosesPinjaman()">Sahkan Pinjaman</button>
							<button class="btn btn-warning" type="reset" onclick="resetAll()">Pinjaman Baru</button>
					</div>
				</div>
	</div>
</div>

<script>
$("#btn_startScam").hide();
$("#btn_pinjaman").hide();
$(document).on("click", ".glyphicon-remove", function(){
			var curr_tr = $(this).parents("tr");
			var row_id = curr_tr.find('input[type="hidden"]');
			var curr_id="";
	        row_id.each(function(){
	            curr_id = $(this).val();
	        });
	        //alert($(this).parents("tr").find("td").eq(4).html());
			

			$.confirm({
	            'title'     : 'Padam',
	            'content'   : 'Anda pasti untuk mengeluarkan bahan Pinjaman dari senarai?',
	            'buttons'   : {
	                'YA'   : {
	                    'class' : 'blue',
	                    'action': function(){
	                       
					        curr_tr.remove();
	                    }
	                },
	                'TDAK'    : {
	                    'class' : 'gray',
	                    'action': function(){}  // Nothing to do in this case. You can as well omit the action property.
	                }
	            }
	        });
			
		});
$(document).on("click", "#btn_startScam", function(){
	$("#btn_startScam").hide();
			start();
		});
function getPeminjam(obj){
    	if(obj.value.length > 11){
	    	$.ajax({
	                url: "../model/library_functions.php",
	                type: "POST",
	                data: {action:"peminjam_detail",nokp:obj.value},
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
function peminjamProses(){
    	
	    $('#spanNama').html($('#nama').val());
	    $('#spanNokp').html($('#nokp').val());
	    $('#spanNotel').html($('#notel').val());
	    $('#myModal').modal('toggle');

    }
function resetAll(){
    	//$('form-control').reset();
    	window.location = "library_imbas_pinjaman.php";

    }
function pinjamanAdd(id_naskah,nama_bahan,tarikh_hantar){
	var isExist = false;

	$('#tbl_pinjaman').find('tbody tr').each(function(){

		if ($(this).find('input[name="id_naskah"]').val() == id_naskah) {
			isExist=true;		
		}
	})
	if(!isExist){
		var res = new Date();
		var tarikh_pinjam = res.toISOString().split("T")[0];

	    var index = $("#tbl_pinjaman tbody tr:last-child").index();

        var row = '<tr>' +
        '<td>'+(index+1)+'</td>' +
        '<td>'+nama_bahan+''+
        '<input type="hidden" name="bil_hari_pinjam" value="'+$('#bil_hari_pinjam').val()+'"/>' +
        '<input type="hidden" name="id_naskah" value="'+id_naskah+'"/></td>' +
        '<td>'+tarikh_pinjam+'</td>' +
        '<td>'+tarikh_hantar+'</td>' +
        '<td align="center">' +
        '<i class="glyphicon glyphicon-remove"></i>'+     
        '<input type="hidden" id="row_id" value="'+(index+1)+'"> '+
        '</td>' +
        '</tr>';
        //$("table").append(row); 
		$('table tr').eq(-1).before(row);
		//start();
		$("#btn_startScam").show();
		$("#btn_pinjaman").show();
	}else{
		alert('Naskah ini telah diimbas !!!');
		start();
		$("#btn_startScam").show();
		$("#btn_pinjaman").show();
	}
    	    
				

    }
function prosesPinjaman(){
		//maklumat pelanggan
		var nokp = $('#nokp').val();
		if(nokp!='') {
			if($('#tbl_pinjaman').find('input[name="id_naskah"]').val() != undefined){
					var nama = $('#nama').val();
					var notel = $('#notel').val();
					
					var created_by = '<?echo $_SESSION['SESS_ID']?>';

					var info = '[';
					var lenInfo = 0;

					$('#tbl_pinjaman').find('tbody tr').each(function(){
						//curr_id = $(this).val();
						//$(this).find('input[name="tbl_kodbar"]').val();
						

						if ($(this).find('input[name="id_naskah"]').val() != undefined) {
							if(lenInfo > 0) info += ',';

							info += '{"id_naskah":"'+$(this).find('input[name="id_naskah"]').val()
							+'","bil_hari_pinjam":"'+$(this).find('input[name="bil_hari_pinjam"]').val()+'"}';
						}
						lenInfo++;
					});

					info += ']';

					var mydata = {action:"prosesPinjaman",
						nokp:nokp,
						nama:nama,
						notel:notel,
						created_by:created_by,
						info:info
					};

					//alert(sys_id);

					$.ajax({
							url: "../model/library_functions.php",
							type: "POST",
							data: mydata,
							success: function (response) {
							// you will get response from your php page (what you echo or print)   
							// var dataObject = $.parseJSON(response);             
							// $.alert('test here:'+response);

							$("#btn_pinjaman").hide();
							$("#btn_peminjam").hide();
							$("#btn_startScam").hide();
							
							$('#myModal1').modal('toggle');
						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log(textStatus, errorThrown);
						}


					});
			}else {
				  $.confirm({
					title: 'Warning',
					content: 'Tiada Bahan Untuk Dipinjam',
					buttons: {
						OK: function () {
							 start();
						}
					}
					});
				}
	}else {
		  $.confirm({
										title: 'Warning',
										content: 'Sila Isi Maklumat Pengguna',
										buttons: {
											OK: function () {
												 start();
											}
										}
									});
	}
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
			//var pattern = str.substring(0,5);
			//var id_naskah = str.substring(5, str.length)
			var pattern = str.split('-');
			var id_naskah = pattern[2];
          //window.open(code.data);
			  if(str=='' || pattern[0]!='elib'){
				  start();
			  }else{
				  if($('#nokp').val()){
					  $.ajax({
							url: "../model/library_functions.php",
							type: "POST",
							data: {action:"BahanPinjamanDetails", id_naskah:id_naskah},
							success: function (response) {
								var dataObject = $.parseJSON(response); 
								//$.alert('test here:'+dataObject[0].nama);
								var nama_bahan=dataObject[0].nama;
								var nama_peminjam=dataObject[0].nama_peminjam;
								var notel=dataObject[0].notel;
								//var nama_bahan=dataObject[0].nama;
								var days=parseInt($('#bil_hari_pinjam').val());
								var res = new Date();
								
								res.setDate(res.getDate() + days);
								var tarikh_hantar = res.toISOString().split("T")[0];
								
								//$.alert('test here:'+tarikh_hantar);
								var status=dataObject[0].status;
								var status_pinjam = dataObject[0].status_pinjam;
								//checking dah ada yang pinjam
								if(status != '0' && status_pinjam == '1'){
									pinjamanAdd(id_naskah,nama_bahan,tarikh_hantar);

								}else if(status_pinjam == '0'){
									alert('Naskah '+str+' tidak boleh dipinjam');
									start();
									$("#btn_startScam").show();
									$("#btn_pinjaman").show();
								}else{
									alert('Naskah '+str+' sedang dipinjam oleh \nNama : '+nama_peminjam+'\nNo Telefon : '+notel);
									start();
									$("#btn_startScam").show();
									$("#btn_pinjaman").show();
								}
								
								
							},
								error: function(jqXHR, textStatus, errorThrown) {
								 console.log(textStatus, errorThrown);
								 //location.href = "acara_sumber_info.php?id_sesi=<?echo $id_sesi?>";
							 }


							});
				  }else{
					   $.confirm({
										title: 'Warning',
										content: 'Sila Isi Maklumat Pengguna',
										buttons: {
											OK: function () {
												 start();
											}
										}
									});
				  }
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