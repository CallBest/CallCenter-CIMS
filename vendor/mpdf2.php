<?php

$html = '<html>
	<body>
		<div>Hello</div>
		<img src="../images/ewb-logo.png" />

		<form action="example_userinput3.php" method="post" enctype="multipart/form-data">
			<textarea style="display:none" name="text" id="text">This is a loooooonnnnnggg text.</textarea>
			<input type="hidden" name="filename" id="filename" value="../images/ewb-logo.png" />
			<input type="submit" name="submit" value="Create PDF file" />
		</form>
	</body>
</html>';

echo $html;

?>