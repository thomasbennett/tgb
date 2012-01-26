<?php ob_start() ?>

<?php include('loop.php') ?>

<?php comments_template( '', true ); ?>

<?php $contents = ob_get_clean() ?>
<?php require('template.php') ?>
