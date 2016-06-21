<?php

// require composer autoload
require 'mpdf/vendor/autoload.php';

$mpdf = new mPDF(); // Create new mPDF Document

// Beginning Buffer to save PHP variables and HTML tags

ob_start();

$day = date('d');
$year = date('Y');
$month = date('F');

echo "Hello World
<br><br>
Today is $month $day, $year
<hr>
";

$html = ob_get_contents();

ob_end_clean();

// Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);

$mpdf->WriteHTML(utf8_encode($html));

$content = $mpdf->Output('', 'S');

$fh = fopen("rcbc/$leadid-client name.pdf", "w");
if($fh==false)
    die("unable to create file");
fputs ($fh, $content);
fclose ($fh);

?>