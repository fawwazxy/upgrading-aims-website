<?php
  $masa_id = $_GET['id'];
  $page = $_GET['page'];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Panel Imbasan Gambar</title>
    <script src="../../js/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="../../js/jquery/jquery-confirm.css">
    <script src="../../js/jquery/jquery-confirm.js"></script>
    <link rel="stylesheet" href="../../resources/css/panel_imbasan_photo.css">
</head>
<body>
 <input type="hidden" id="masa_id" value="<?echo $masa_id; ?>">
 <input type="hidden" id="mypage" value="<?echo $page; ?>">
  <center><h1>#2 Konfirmasi Gambar Kamera</h1></center>
<div class="layout">
 <!--  <div id="newImages"></div> -->
  
  <div class="row">
    <div class="cell">
      <video id="player" autoplay></video>
    </div>
    <div class="cell"></div>
      <canvas id="canvas" width="320px" height="240px"></canvas>
    </br>
      <button class="btn btn-primary" id="capture-btn">Ambil Gambar!</button>

  <div class="center">
  </div>
  <div id="pick-image">
    <label>Video is not supported. Pick an Image instead</label>
    <input type="file" accept="image/*" id="image-picker">
  </div>
</div>

<script src="../../js/panel_imbasan_photo.js"></script>
</body>
</html>