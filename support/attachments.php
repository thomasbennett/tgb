<?php
session_start();
include_once("class.ticket.php");
include_once("config.php");
$oslogin = login($_SESSION[user][type],$_SESSION[user][id],$_SESSION[user][pass]);
$filename =$config[attachment_dir].'/'.$_GET['file'];
$extension =substr($filename,-3);
if(!$oslogin){
echo "<html><title>$osticket_title</title><body>You do not have access to attachments...IP loged.</body></html>";
exit;
}
if(($filename=="") || !file_exists($filename)) 
{
  echo "<html><title>$osticket_title</title><body>ERROR:Missing or Invalid filename</body></html>";
  exit;
};
switch($extension)
{
  case "pdf": $ctype="application/pdf"; break;
  case "exe": $ctype="application/octet-stream"; break;
  case "zip": $ctype="application/zip"; break;
  case "doc": $ctype="application/msword"; break;
  case "xls": $ctype="application/vnd.ms-excel"; break;
  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
  case "gif": $ctype="image/gif"; break;
  case "png": $ctype="image/png"; break;
  case "jpg": $ctype="image/jpg"; break;
  default: $ctype="application/force-download";
}
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public"); 
header("Content-Type: $ctype");
$user_agent = strtolower ($_SERVER["HTTP_USER_AGENT"]);
if ((is_integer(strpos($user_agent,"msie"))) && (is_integer(strpos($user_agent,"win")))) 
{
  header( "Content-Disposition: filename=".basename($filename).";" );
} else {
  header( "Content-Disposition: attachment; filename=".basename($filename).";" );
}
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename));
readfile("$filename");
exit();
?>
    
