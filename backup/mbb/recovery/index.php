<?php require('../helpers/functions.php') ?>
<?php $pageTitle = "Recovery" ?>
<?php ob_start() ?>


<div class="left">
    <img class="right" src="<?php echo DOMAIN ?>/images/recovery.jpg" alt="Recover YOUR money!" />
    <h1>Check Recovery</h1>
    <p>Is your business wasting valuable time attempting to collect returned checks? Medical &amp; Business Bureau can help solve your collection dilemma. Our reputable staff is committed to providing your business with the best possible service while maintaining the highest standards of the Fair Debt Collection Practice Act (FDCPA).</p>
    <p>Our clients receive full face value of all returned checks collected. Returned check fees are paid by the check writer, at no cost to the client. If not paid in full within 45 days of submission to Medical &amp; Business Bureau, returned checks are reported to a national credit bureau which can effect the debtor's ability to get credit or to be eligible for refinancing of any kind.</p>
    <p>A legal copy of the check itself must be submitted to Medical &amp; Business Bureau to start collection efforts. Any information obtained about the debtor should be included. Every client receives an Account Acknowledgement of all returned checks submitted to Medical &amp; Business Bureau.</p>

    <h1>Judgment Recovery</h1>
    <p>Have you been awarded a legal judgment that you have not successfully collected? The majority of the time, obtaining a legal judgment is the easy part. Collecting the judgment can be the real challenge. Medical & Business Bureau can manage the entire legal process for you. With the supervision of our legal team, our agency will conduct a thorough investigation into the defendant's assets to determine the most successful means of collecting your money. Medical & Business Bureau will pinpoint accessible assets that can be used to satisfy your judgment. These assets include banking accounts, employment wages that are eligible for garnishment, and any real or personal property owned by the defendant.</p>
    <p>When submitting a legal judgment for collections include a copy of the judgment and any information obtained about the debtor.</p>
</div>

<?php $pageContents = ob_get_clean() ?>
<?php require('../template.php') ?>
