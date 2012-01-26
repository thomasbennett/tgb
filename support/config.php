<?
/*
	osTicket, Open Source Support Ticket System
	http://www.osticket.com

	Copyright (C) 2003 osTicket

	Released under the GNU General Public License
*/
define("ADMIN", 1);
require("gpcvar.php");
//link to forum
$help_link = "<a href='http://www.osticket.com/forums/index.php' target='_new'>osTicket Help</a>";
//page titles
$titles = array("viewticket"=>"View Ticket", "admin_login"=>"Administrative Login", "user_login"=>"Login", "main"=>"", "pref"=>"Preferences", "mail"=>"Mail Messages", "cat"=>"Categories", "rep"=>"Representatives", "user_group"=>"User Groups", "banlist"=>"Ban List", "my"=>"My Account");

/*----------------------------EDITABLE-------------------------------------------------------------
 We recommend that you use install script to install osTicket.
 If you prefer manual install please do the following.
 Create a db and upload osTicket.sql
 set $homepath_dir to  http://www.your-domain.com/directory/to/osticket/admin.php
 set $rootpath_dir to the install dir of osticket /www/username/public_html/osticket or /www/htdocs/osticket
 set MYSQL host,databse,user,pass and $db_type to mysql.

 For more detailed instructions....check online guide at http://wwww.osticket.com
 Feel free to email us at support@osticket.com

 Good luck.
*/


$installed=TRUE;
if($installed!=TRUE){
 Header("Location: setup.php");
}

if(file_exists('setup.php')){
die("<div align=center><b>Fatal Error:</b> Please remove setup.php for security reasons.</div><p/>");
}
/*the path to osticket homepage */
$homepath_dir='http://thomasgbennett.com:/support';
/*The Title */
$osticket_title='Thomas G. Bennett, Inc.';
/*The root path to osticket install directory */
$rootpath_dir='/var/www/vhosts/thomasgbennett.com/httpdocs/support/';
/*The full path to your include directory relative to $rootpath_dir, no trailing slash */
$include_dir =$rootpath_dir .'include';
if (!file_exists($include_dir)) {
    die("<b>Fatal Error:</b> Include directory does not exist.<br>$help_link");
}
/*Configure your MySQL Settings */
$db_type = 'mysql_options.php';
$db_host = 'localhost:3306';
$db_name = 'osticket_5';
$db_user = 'osticket_5';
$db_pass = '_4I7Vz0Mpv';

/*-----------------------------------------------------------------------------------------------
DO NOT EDIT ANYTHING BELOW (unless you know what you are doing).
Monkey around at your own risk.
------------------------------------------------------------------------------------------------*/
@mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name);

if (mysql_error()) {
    die("<b>Fatal Error:</b> Could not connect to database.<br>" . mysql_error() . "<br>$help_link");
}

//get configuration from database
$config = @mysql_fetch_array(mysql_query("SELECT * FROM ticket_config"));
if (!$config[answer_method]) {
    die("<b>Fatal Error:</b> Could not retrieve configuration from database.<br>" . mysql_error() . "<br>$help_link");
}

//set timezone to server time if not defined
$config[timezone] = ($config[timezone] == "") ? date("Z") / 3600: $config[timezone];

//determine what PHP page to display
if (!$_SESSION[user][type]) {
    $page = strstr($PHP_SELF, "admin") ? "admin.php": "view.php";
}
else {
    if ($_SESSION[user][type] == "admin") {
        $page = "admin.php";
    }
    else {
        $page = "view.php";
    }
}

//verify a valid login
if (($_SESSION[user][type] or login("admin", $_POST[login_user], md5($_POST[login_pass])) or login("client", $_POST[login_email], $_POST[login_ticket])) and $a !== "logout") {
    $login = true;
}

//make php3 compatible
if (!$_POST) {
    $_POST = $HTTP_POST_VARS;
}
if (!$_GET) {
    $_GET = $HTTP_GET_VARS;
}
if (!$_REQUEST) {
    foreach ($_POST as $item => $val) {
    	if (!$val) {
    		$_REQUEST[$item] = $_GET[$item];
    	}
    	else {
    	    $_REQUEST[$item] = $_POST[$item];
    	}
    }
}
if (!$_FILES) {
    $_FILES = $HTTP_POST_FILES;
}
?>
