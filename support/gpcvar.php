<?
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(0);

function _addslashes($var){
  if (!(get_magic_quotes_gpc())) { 
    return addslashes($var);
  } else {
    return $var;
  }
}
	
  // GPC variables 
  if (!empty($_GET)) {
    for (reset($_GET); list($k, $v) = each($_GET); ) 
    $$k = _addslashes($v); 
  } else {
    for (reset($HTTP_GET_VARS); list($k, $v) = each($HTTP_GET_VARS); ) 
    $$k = _addslashes($v); 
  }
  
  if (!empty($_POST)) {
   for (reset($_POST); list($k, $v) = each($_POST); ) 
   $$k = _addslashes($v); 
  } else {
   if(isset($HTTP_POST_VARS)){
     for (reset($HTTP_POST_VARS); list($k, $v) = each($HTTP_POST_VARS); ) 
     $$k = _addslashes($v); 
   }
  }
  
  if (!empty($_COOKIE)) {
    for (reset($_COOKIE); list($k, $v) = each($_COOKIE); ) 
    $$k = _addslashes($v); 
  } else {
    for (reset($HTTP_COOKIE_VARS); list($k, $v) = each($HTTP_COOKIE_VARS); ) 
    $$k = _addslashes($v); 
  }
 
    if (!empty($_FILES)) {
        while (list($name, $value) = each($_FILES)) {
            $$name = _addslashes($value['tmp_name']);
        }
    } else if (!empty($HTTP_POST_FILES)) {
        while (list($name, $value) = each($HTTP_POST_FILES)) {
            $$name = _addslashes($value['tmp_name']);
        }
    }

    if (!empty($_SERVER) && isset($_SERVER['PHP_SELF'])) {
        $PHP_SELF = $_SERVER['PHP_SELF'];
    } else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['PHP_SELF'])) {
        $PHP_SELF = $HTTP_SERVER_VARS['PHP_SELF'];
    } 
?>
