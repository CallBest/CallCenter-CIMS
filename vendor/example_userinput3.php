<?php

require 'mpdf/vendor/autoload.php';

$mpdf = new mPDF();

$html ='<html>
<body>
	<div>'.$_POST['text'].'</div>
	<img src="' . "../uploads/" . $_POST['filename'] . '" />
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output();
?>