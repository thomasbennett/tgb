<?php require('../helpers/functions.php') ?>
<?php $pageTitle = "Case Studies" ?>
<?php ob_start() ?>

<h1>The Numbers Speak for Themselves</h1>
<img class="right" src="<?php echo DOMAIN ?>/images/numbers.jpg" />
<p>With accounts over a million dollars and accounts under a thousand, no job is too big or too small.</p>

<h1>Account:</h1>
<ul>
    <li>Total number of collectible bills: 9,208</li>
    <li>Total collectible sum: $752,044.88</li>
    <li>&nbsp;</li>
    <li>Average age of account: 340 days</li>
    <li>Total collected: <strong>$378,976.34</strong></li>
</ul>

<?php $pageContents = ob_get_clean() ?>
<?php require('../template.php') ?>
