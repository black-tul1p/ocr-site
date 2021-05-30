<?php
GLOBAL $fileDest;

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

	// Handle file upload to Uploads/ folder
	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileSize < 3000000) {
				$fileNameFinal = uniqid('', true).".".$fileActualExt;
				$fileDest = './Uploads/'.$fileNameFinal;
				if (move_uploaded_file($fileTmpName, $fileDest)) {
					header("Location: index.php?uploadsuccess");
					// echo "<img src='$fileDest'>";
					// echo "<br><br>";
				}
			} else {
				echo "Please upload a file smaller than 3MB."; 
			}
		} else {
			echo "There was an error uploading the image."; 
		}
	} else {
		echo "Uploaded file is not a png, jpg or jpeg image.";
	}
}

?>