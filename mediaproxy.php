<?php
header("Content-Type: application/octet-stream");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  passthru("/bin/bash -c \"curl ".escapeshellarg($_GET["url"])." |ffmpeg -i - -c:a copy  -f mp3 -\"");
}

