<?php ob_start() ?>

<div id="featured-articles">
    <?php include('summary-loop.php') ?>
</div>

<?php include('sidebar-recent.php') ?>

<?php $contents = ob_get_clean() ?>
<?php require('template.php') ?>
