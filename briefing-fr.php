<?php
$filename = 'assets/medias/video/briefing-fr.mp4';
$expiry = 60 * 60 * 24 * 30; // 1 month cache

header("Cache-Control: max-age=$expiry");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + $expiry) . " GMT");
header("Content-Length: " . filesize($filename));
header("Content-Type: video/mp4");

readfile($filename);
?>