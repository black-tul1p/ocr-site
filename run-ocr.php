<?php
	include 'upload.php';
	if (isset($fileDest)) {
	// if (true) {
		echo shell_exec("python ./OCR/digit_detect.py ".$fileDest);
		// echo shell_exec("python ./OCR/digit_detect.py ./Uploads/image_3.png 2>&1");
	} else {
		header("Location: index.php?noimage");
	}
?>