<!DOCTYPE html>
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
			<div class="main-title teal-bg"><br><center>
				<!-- <img src="./Images/logo.png" alt="Digit OCR logo"> -->
				<a href="./">Digit Recognizer</a>
			</center><br></div>
		</header>

		<br><br><br><br><br>

		<!-- Flexbox -->

			<!-- Form for URL submission and refresh button -->
			<div class="info-card" style="flex-basis: 40em; flex-grow: 1; flex-shrink: 1;" id="image-holder"><br>
				<!-- URL upload form -->
				<form id="upload">
					<input type="text" value="" id="image-url" placeholder="Enter URL to image..." style="margin: 5px; width: 8.5vw;">
					<input type="button" id="btn" class="click-button" value="SELECT" onclick="loadLink();">

					<!-- <font style="opacity: 35%; font-size: 0.55em; font-family: sans-serif; font-weight: bold;"> OR&nbsp; </font> -->
					<br><p class="bg-text">OR</p>

<!-- 
					<input type="file" id="uploaded-img" hidden="hidden">
					<button type="button" id="click-button" class="click-button">CHOOSE A FILE</button>
					<span id="upload-text">No file selected.</span><br>
 -->
				</form>
				<!-- Image upload button -->
				<form action="upload.php" method='POST' enctype="multipart/form-data">
					<input type="file" name="file" style="width: 180px"><button type="submit" name="submit">UPLOAD</button>
				</form>

				<!-- Analyze image button -->
				<form action="run-ocr.php" method="POST">
					<br>
					<input type="submit" id="run-button" value="IDENTIFY!">
					<br><br>
				</form>
			</div>

			<!-- Script for loading image -->
			<div>
				<script type="text/javascript">
					// Displays image from link
					var parentElement = document.getElementById('image-holder');
					var firstChild = parentElement.childNodes[0];

					function loadLink() {
						var old_img = document.getElementById("loaded-link");
						var line_br = document.getElementById("loaded-br");
						if (old_img != null && line_br != null) {
							old_img.parentNode.removeChild(old_img)
							line_br.parentNode.removeChild(line_br)
						}

						var val = document.getElementById('image-url').value,
						src = val,

						img = document.createElement('img');
						img.id = "loaded-link";
						img.src = src;
						img.style.width = '20em';
						img.alt = "Image loaded from URL";

						line_break = document.createElement("br");
						line_break.id = "loaded-br"
						parentElement.insertBefore(line_break, firstChild);
						parentElement.insertBefore(img, firstChild);
					};
				</script>
			</div>
	</body>
</html>