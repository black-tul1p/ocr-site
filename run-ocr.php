<?php	
// Check for field with location data and run ML script
$imageExists = false;
$fileDest = "";

if (isset($_POST['image-path'])) {
	$imageExists = true;

	// Variable to hold path to image
	$fileDest = $_POST['image-path'];
}

//
// Update Source Code
//
	
// Main site source code
echo '<!DOCTYPE html>
		<link rel="stylesheet" type="text/css" href="./Styles/styles.css" />
		<html lang="en-US">
			<head>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Digit Recognizer</title>
			</head>
			<body>
				<!-- Title -->
				<header>
					<div class="main-title teal-bg">
						<br><center><a href="./">Digit Recognizer</a></center><br>
					</div>
				</header>

				<br>

				<!-- Flexbox -->

					<!-- Form for URL submission and refresh button -->
					<div class="info-card" style="flex-basis: 40em; flex-grow: 1; flex-shrink: 1;" id="image-holder"><br>
';

if ($imageExists) {
	echo "<img src='$fileDest' id='up-img' style='max-width: 28vw; max-height: 40vh;' alt='Uploaded image'><br id='loaded-br'>";
}

echo '					<!-- URL upload form -->
						<form action="download.php" id="upload" method="POST">
							<input type="text" name="image-url" value="" id="image-url" placeholder="Enter URL to image..." style="margin: 5px; width: 8.5vw;">
							<button type="submit" name="submit-link" id="btn" class="click-button">SELECT</button>
						</form>

						<p class="bg-text">OR</p>

						<!-- Image upload button -->
						<form action="upload.php" method="POST" enctype="multipart/form-data">
							<input type="file" name="file" style="width: 180px"><button type="submit" name="submit">UPLOAD</button>
						</form>

						<!-- Analyze image button -->
						<form action="run-ocr.php" method="POST">
							<br>
							<input type="submit" id="run-button" value="IDENTIFY!" onclick="loadImage();">
						</form>
';

if ($imageExists) {
	// Running the ML script on the image
	echo "<p>".shell_exec("python ./OCR/digit_detect.py ".$fileDest)."</p>";
} else {
	echo "<p class='bg-text'>No image was uploaded</p>";
}

// Main site source code
echo '<br>
	</body>
</html>';
?>