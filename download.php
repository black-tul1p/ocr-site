<?php
// Retrieve image from URL
if (isset($_POST['image-url'])) {
	$uploaded = false;
	$noUrl = true;
	$notImage = false;

	// Get fileUrl
	$fileUrl = $_POST['image-url'];

	// Get file extension
	$fileExt = explode('.', $fileUrl);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg', 'jpeg', 'png');
	if (in_array($fileActualExt, $allowed)) {
		// Save file to Uploads/ folder
		$fileName = uniqid('', true).".".$fileActualExt;
		$fileDest = './Uploads/'.$fileName;
		if (strcmp($fileUrl, "") != 0) {
			$noUrl = false;
			$remoteImage = file_get_contents($fileUrl);
			if (file_put_contents($fileDest, $remoteImage) > 0) {
				$uploaded = true;
			}
		}
	} else {
		$noUrl = false;
		$notImage = true;
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
						<div class="info-card" style="flex-basis: 40em; flex-grow: 1; flex-shrink: 1;" id="image-holder"><br>';
	if ($uploaded) {
		echo "<img src='$fileDest' id='up-img' style='max-width: 28vw; max-height: 40vh;' alt='Uploaded image'><br id='loaded-br'>";
	}
	echo'
		<!-- URL upload form -->
		<form action="download.php" id="upload" method="POST">
			<input type="text" class="url-bar" name="image-url" value="" id="image-url" placeholder="Enter URL to image...">
			<button type="submit" name="submit-link" id="btn" class="click-button">SELECT</button>
		</form>

		<p class="bg-text">OR</p>

		<!-- Image upload button -->
		<form action="upload.php" method="POST" enctype="multipart/form-data">
			<input type="file" name="file" style="width: 180px"><button type="submit" name="submit">UPLOAD</button>
		</form>

		<!-- Analyze image button -->
		<form action="run-ocr.php" method="POST">
	';
	if ($uploaded) {
		echo "	<input type='hidden' value='$fileDest' id='image-path' name='image-path'>";
	}
	echo '	<br>
			<input type="submit" id="run-button" value="IDENTIFY!" onclick="loadImage();">
		</form>';
	if ($uploaded) {
		echo "<p class='bg-text'>Image loaded successfully</p>";
	} elseif ($noUrl) {
		echo "<p class='bg-text'>No URL was entered</p>";
	} elseif ($notImage) {
		echo "<p class='bg-text'>URL does not link to an image</p>";
	} else {
		echo "<p class='bg-text'>Image could not be loaded</p>";
	}
	echo '<br>
		</body>
	</html>';
}
?>