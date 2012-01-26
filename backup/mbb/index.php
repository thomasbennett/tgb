<?php require_once('helpers/functions.php') ?>
<?php ob_start() ?>

<div id="prev"></div>
<div id="next"></div>

<div id="cycler">
	<div id="slides">
	<?php // HOME SLIDE ?>
		<div class="slide">
            <div class="right">
                <img src="<?php echo DOMAIN ?>/images/istock.jpg" alt="istock photo" class="left" />

                <h1>Take a Closer Look</h1>
                <p>With over 50 years of debt collection experience, Medical &amp; Business Bureau is a leader in the collection industry.</p>
                <P>What can we do for you?</p>
                <a href="/about"><img src="<?php echo DOMAIN ?>/images/get-answers.png" /></a>
            </div>
		</div>

		<?php // OTHER SLIDES ?>
		<?php include('slides.php') ?>
	</div>
</div>

<ul id="pager" class="inline">
	<li style="margin-left: 25px"><a href="javascript:void(0)">Medical &amp; Business Bureau</a></li>
	<?php /*<li><a href="javascript:void(0)">Education You</a></li>
	<li><a href="javascript:void(0)">Why Choose Us?</a></li>
    */ ?>
	<li><a href="javascript:void(0)">Our Methods</a></li>
	<li><a href="javascript:void(0)">The Case Study</a></li>
</ul>

<?php $pageContents = ob_get_clean() ?>
<?php require ('template.php') ?>
