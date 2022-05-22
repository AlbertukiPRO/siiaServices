<?php
include('../phpqrcode/qrlib.php');

// outputs image directly into browser, as PNG stream

QRcode::png($_GET['id'],"qr.png",QR_ECLEVEL_L,4);

