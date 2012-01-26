<?php
/**
 * You may wish to edit these settings after the install script has created it
 *
 * DO NOT CHANGE ANY OF THE TEXT IN UPPER CASE ON THIS PAGE.
 * If you do, the program will not work. For example, do not
 * modify PHPST_INDEXPAGE, only change the value next to it, "index.php?"
 */

// This is the root page from which all of PHPST is run. Default it index.php?
define('PHPST_INDEXPAGE', "index.php?");

// If your tickets installation is in a subfolder of the script from which it
// will be running, set this constant to that path (e.g. 'pages/tickets/')
define('PHPST_PATH', '');

// Set this constant to the URL location of index.php
define('BASE_URL', 'http://thomasgbennett.com:/support/');

// The URL and the path to your upload directory
define('PHPST_UPLOAD_PATH', '/var/www/vhosts/thomasgbennett.com/httpdocs/support/upload/');
define('PHPST_UPLOAD_RELATIVE_PATH', 'http://thomasgbennett.com:/support/upload/');

// This is the address that will receive all email notifications if such are turned on
define('PHPST_MAIL_TO', 'thomas.g.bennett@gmail.com');

// This is the name that will appear on email notifications
define('PHPST_MAIL_NAME', '');

// This is the subject that will appear on email notifications
define('PHPST_MAIL_SUBJECT', 'Contact from Support Tickets');

// Choose your email method
// Sets the send method for all the mailings
// coming out of this app - Following are options
// If you are getting errors then try a different option
// - smtp - sends the mail via sockets through sockethost
// - sendmail - USES SENDMAIL TO SEND MAIL
// - mail - USES PHP INBUILT MAIL FUNCTION
// - qmail - USES QMAIL TO SEND THROUGH
define('PHPST_MAIL_SENDMETHOD', 'mail');

// If you chose SMTP, you will need to set these constants too
// email address to appear in from
define('PHPST_MAIL_SOCKETFROM', 'thomas.g.bennett@gmail.com');

// name to appear in from field
define('PHPST_MAIL_SOCKETFROMNAME', 'Admin');

// email address to reply to
define('PHPST_MAIL_SOCKETREPLY', 'thomas.g.bennett@gmail.com');

// name for reply email
define('PHPST_MAIL_SOCKETREPLYNAME', 'Admin');

// smtp host to send the emails via the smtp socket
// this may simply be localhost
define('PHPST_MAIL_SOCKETHOST', 'thomas.g.bennett@gmail.com');

// If you use smtp authentication:
// set this to true if your smtp server requires authentication
define('PHPST_MAIL_SMTPAUTH', 1);

// smtp username - usually the same as your mailbox
define('PHPST_MAIL_SMTPAUTHUSER', 'thomas.g.bennett@gmail.com');

// smtp password - usually the same as your mailbox
define('PHPST_MAIL_SMTPAUTHPASS', '');

// Database set up
define('DB_HOST', 'localhost');
define('DB_USER', 'phpst_7');
define('DB_PASS', 'ZL673lH_oh');
define('DB_TYPE', 'mysql');
define('DB_DATA', 'phpst_e');

// These are the names of the tables you will use for PHPST.
// If you modify these in order to merge the users tables,
// you will only need to modify the tables with phpmyadmin or a similar tool.
// PHPST doesn't have table names hard-coded in.

// You should always use a prefix to avoid table name conflicts
define('DB_PREFIX', 'pst_');

// The users table is likely to become common with an existing one.
// Enter its name here if needed. Otherwise enter the name of the new users table.
define('DB_PREFIX_USER', 'pst_users');

// If you are merging users tables, you may want to enter here the names of
// your existing fields that are compatible with the fields needed by PHPST
// Here is a data dictionary of what is needed (items in [] are optional):
//    ID : integer, [16], [unsigned], unique, PK, auto-increment
//    username: varchar, [64]
//    password: varchar, [64]
//    name: varchar, [64]
//    email: varchar, [128]
//    timestamp: int, [16], [unsigned]
//    admin: enum('Admin', 'Mod', 'Client'), Default Mod
//
// It is likely that you will need to add the Admin field to your existing users table.
// The other fields should already exist if you keep users data, so enter their names here.
// Otherwise you may leave these fields as they are, and a new table will be created.
define('DB_PREFIX_USER_ID', 'id');
define('DB_PREFIX_USER_USERNAME', 'username');
define('DB_PREFIX_USER_PASSWORD', 'password');
define('DB_PREFIX_USER_NAME', 'name');
define('DB_PREFIX_USER_EMAIL', 'email');
define('DB_PREFIX_USER_TIMESTAMP', 'timestamp');
define('DB_PREFIX_USER_ADMIN', 'admin');

// The following shouldn't need to be changed
define('DB_PREFIX_ANSWERS', DB_PREFIX . 'answers');
define('DB_PREFIX_TICKETS', DB_PREFIX . 'tickets');
define('DB_PREFIX_DEPARTMENTS', DB_PREFIX . 'departments');
define('DB_PREFIX_DEPARTMENTS_USERS', DB_PREFIX . 'department_users');
define('DB_PREFIX_OPTIONS', DB_PREFIX . 'options');
define('DB_PREFIX_HISTORYLOG', DB_PREFIX . 'history_log');
?>