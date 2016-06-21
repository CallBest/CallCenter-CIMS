<?php

if (isset($_REQUEST['leadid'])) {
  $leadid = $_REQUEST['leadid'];

  //create AppForm using mpdf
  require_once('../../vendor/mpdf/vendor/autoload.php');
  $mpdf = new mPDF(); // Create new mPDF Document

  ob_start();
  include("MBAppForm.php");
  $html = ob_get_contents();
  ob_end_clean();
  // Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
  $mpdf->WriteHTML(utf8_encode($html));
  $content = $mpdf->Output('', 'S');
  $fh = fopen("appform/rcbc/$leadid-client name.pdf", "w");
  if($fh==false)
      die("unable to create file");
  fputs ($fh, $content);
  fclose ($fh);
  
}

?>