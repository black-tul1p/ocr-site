<?php
// Check if image upload is being requested
if (isset($_POST['submit'])) {
	// Get file info
	$file = $_FILES['file'];
	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];

	// Get file extension
	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg', 'jpeg', 'png');
	
	// Flags for error/success messages
	$uploaded = false;
	$large = false;
	$error = false;
	$noFile = false;
	$formatError = false;

	// Handle file upload to Uploads/ folder
	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileSize < 3000000) {
				$fileNameFinal = uniqid('', true).".".$fileActualExt;
				$fileDest = './Uploads/'.$fileNameFinal;
				if (move_uploaded_file($fileTmpName, $fileDest)) {
					$uploaded = true;
				}
			} else {
				$large = true;
			}
		} else {
			$error = true;
		}
	} else if (strcmp($fileName, "") == 0){
		$noFile = true;
	} else {
		$formatError = true;
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
		echo "<img class='image' src='$fileDest' id='up-img' style='max-width: 28vw; max-height: 40vh;' alt='Uploaded image'><br id='loaded-br'>";
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
		echo "<p class='bg-text'>Image uploaded successfully</p>";
	} elseif ($large) {
		echo "<p class='bg-text'>Please upload a file smaller than 3MB</p>";
	} elseif ($error) {
		echo "<p class='bg-text'>There was an error uploading the image</p>";
	} elseif ($noFile) {
		echo "<p class='bg-text'>No image was selected</p>";
	} elseif ($formatError) {
		echo "<p class='bg-text'>Please upload a png, jpg or jpeg image</p>";
	}
	echo '<br>
			</div>
		</body>
	</html>';
}
?>