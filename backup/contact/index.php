<?php ob_start() ?>

<div id="featured-articles">
    <div class="full-entry-wrap">
        <div class="entry">
            <h1>Get in touch!</h1>
            <p style="margin-bottom: 0px">P.O. Box 128042, Nashville, TN, 37212</p>
            <p style="margin-bottom: 0px"><a href="mailto:thomas.g.bennett@gmail.com">thomas.g.bennett@gmail.com</a></p>
            <p>615.812.9498</p>
        </div>
    </div>
</div>

<?php include('../sidebar-recent.php') ?>
<?php $contents = ob_get_clean() ?>
<?php require('../template.php') ?>
