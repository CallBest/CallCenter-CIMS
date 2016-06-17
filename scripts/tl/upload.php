<?php
require_once('../../includes/dbase.php');
require_once('../../includes/settings.php');

$db = new dbconnection();
$db->dbconnect();

isset($_REQUEST['agent']) ? $agent = $_REQUEST['agent'] : exit;
isset($_REQUEST['leadid']) ? $leadid = $_REQUEST['leadid'] : exit;
$total = count($_FILES['upload']['name']);
// Loop through each file
for($i=0; $i<$total; $i++) {
  $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

  if ($tmpFilePath != ""){
    $filename = $leadid . ' - ' . $_FILES["upload"]['name'][$i];
    $newFilePath = "../../uploads/$filename";
    //Upload the file into the temp dir
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
      $db->query = "
        insert into ".TABLE_FILES."
        (leadid,filename,dateuploaded,agent)
        values
        ($leadid,'$filename',now(),$agent)
        ";
      $db->execute();
      echo 'File <a href="uploads/'.$filename.'" target="_blank">'.$filename.' uploaded.</a><br>';
    } else {
      echo 'Failed to upload file '.$filename;
    }
  }
}

?>