<?php

if (($_FILES["file"]["type"] == "image/gif" || $_FILES["file"]["type"] == "image/jpeg") && $_FILES["file"]["size"] < 200000000) {
    // If the destination file already exists, it will be overwritten
    move_uploaded_file($_FILES["file"]["tmp_name"], "../uploads/" . $_FILES["file"]["name"]);
} else {
    echo "Invalid file";
}

$html = '<html>
	<body>
		<div>'.$_POST['text'].'</div>
		<img src="' ."../uploads/" . $_FILES["file"]["name"].'" />

		<form action="example_userinput3.php" method="post" enctype="multipart/form-data">
			<textarea style="display:none" name="text" id="text">'.$_POST['text'].'</textarea>
			<input type="hidden" name="filename" id="filename" value="'. $_FILES["file"]["name"].'" />
			<input type="submit" name="submit" value="Create PDF file" />
		</form>
	</body>
</html>';

echo $html;
?>