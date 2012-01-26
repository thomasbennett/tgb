<?
session_start();

include("config.php");
include("class.ticket.php");

if ($_SESSION[user]) {
    include("$include_dir/header.php");
    include("$include_dir/search.php");
    include("$include_dir/footer.php");
}
?>
