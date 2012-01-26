<?php 
/* 
* Template name: Store
*/
/*
<style>
  body { background: #fff !important; }
  .p-store { background: #333 !important; }
  .b-plan-items { display: none !important; }
  .p-box-mc { min-height: 275px; }
  .p-box-panel .p-box-title-area h2 { font-size: 22px !important; font-style: normal !important; }
  .b-plan-description { min-height: 60px; }
</style>
*/ 

get_header();

query_posts('pagename=store');

if(have_posts()):
  while(have_posts()):
  the_post();
    the_content();
    readfile("http://thomasgbennett.com:8880/store/catalog-widget/web-store.html"); 
  endwhile;
endif;

wp_reset_query();

get_footer();

?>
