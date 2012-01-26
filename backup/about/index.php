<?php ob_start() ?>
<div id="featured-articles">
    <div class="full-entry-wrap">
        <div class="entry">
            <img src="/images/waycross.jpg" alt="Where I'm From" />
            <h1>A Look Through the Weeds</h1>
            <p>Growing up in a small town was a huge inspiration for me. As an avid chess enthusiast and a multi-instrumental musician, traveling the country was an expected part of my childhood. Discerning the world from my roots helped mold my desires to move away and pursue dreams bigger than my whereabouts. Subsequently, I moved to Nashville, Tennessee. Six years later, after being the first in my family to graduate college, interning for one of the biggest music producers alive, working with various record labels, and co-founding and selling a company, my journey has led me to work with many remarkable companies both personally and with my current employer, Iostudio.</p>
            <p>Personally, I've worked with BWA, Ltd., an architecture firm that designed most of the casinos in Las Vegas, including the MGM Grand and Paris. In addition to BWA, I've worked with one of the largest beer companies in America and Mexico as well as many regional businesses.</p>
            <p>With Iostudio I have worked on websites such as the National Guard, Daily's convenience stores, and have solely built the Barrett firearms website and the National Guard's MySpace page.</p>
        </div>
    </div>
</div>

<?php include('../sidebar-recent.php') ?>

<?php $contents = ob_get_clean() ?>
<?php require('../template.php') ?>
