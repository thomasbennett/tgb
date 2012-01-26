<?php require('../helpers/functions.php') ?>
<?php $pageTitle = "Who We Are" ?>
<?php ob_start() ?>

<h1>Our History</h1>
<img src="<?php echo DOMAIN ?>/images/office.jpg" class="left" />
<p>Since 1955 Medical &amp; Business Bureau has been devoted to the economic interest of our clients, commercial and consumer. Our agency's team of professionals maintain current training and education to ensure our clients the best possible results. Operating with the state-of-the-art collection program and skip tracing tools, our agency is uniquely capable of helping your business minimize loses and locate debtors.</p>
<p>Medical &amp; Business Bureau complies fully with the federal Fair Debt Collection Practice Act (FDCPA) and with the Health Insurance Portability and Accountability Act (HIPAA). Our experience and training with medical collection makes it possible for our collection specialist to assist patients or responsible parties in the understanding of insurance payments, co-payments, and deductibles.</p>
<p>Our agency is committed to operating with integrity and honesty to achieve the highest percentage of collections possible for each and every client no matter the size of the debt.</p>

<?php $pageContents = ob_get_clean() ?>
<?php require('../template.php') ?>
