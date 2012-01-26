<?php ob_start() ?>
<?php include('connection.php'); ?>

<div id="featured-articles"> 
    <div class="entry-wrap">
        <div class="entry">
            <h1>Hello.</h1>
            <p>Thanks for checking out my site. I make websites, Facebook applications, lead and manage web research and am just here to help you.</p>
            <p>Check out some of the stuff I've done and browse around as you like.</p>

            <div class="divider"></div>
            
            <?php /*
            <h2>Uncle Jim</h2>
            <img src="/images/jim.jpg" alt="Uncle Jim" />
            <p>Jim Mayer of Jimmy Buffett's Coral Reefer Band just got a new blog. You're gonna want to check out this one!</p>
            */ ?>

            <h2>Kimber America</h2>
            <img src="/images/solo.jpg" alt="Kimber America" />
            <p>This little bad boy was released at shot show this year.</p>
            <div class="divider"></div>

            <h2>Crowdflower API</h2>
            <img src="/images/crowdflower.png" alt="Crowdflower" />
            <p>With this connection my client can now shoot a link and track his employee's time online.</p>
            <div class="divider"></div>

            <h2>Dailys</h2>
            <img src="/images/dailys-home.png" alt="Daily's" />
            <p>Middle TN's convenience store and Nashville-based dairy company, Purity are giving away more free stuff.</p>

            <div class="divider"></div>

            <h2>BWD, Ltd.</h2>
            <img src="/images/bn9.jpg" alt="Beijing Noodle No. 9" />
            <p>You might recognize this from a TV commercial or two. Or just from a night in Vegas.</p>
        </div>
    </div>
</div>

<?php 

include('sidebar-recent.php');

$contents = ob_get_clean();
require('template.php');

?>
