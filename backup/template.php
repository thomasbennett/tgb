<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <title>TGB &raquo; I Make Websites <?php if(isset($pageTitle)) echo " &raquo; $pageTitle" ?></title>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

    <meta name="description" content="Howdy! I'm Thomas Bennett. I make websites and web applications to help make your life easier and give you a rock solid web presence." />
    <meta name="keywords" content="Thomas, Bennett, web, site, website, application, Facebook, graphic, design, front, end, development, developer, WordPress, Symfony, Zend, framework, Magento, e-commerce, ecommerce, Magento Commerce, store, CMS, content, management, system, build, Nashville, Tennessee, TN, middle TN, TOGA, Entertainment, iostudio" />
    <meta name="author" content="Thomas Bennett" />

    <link rel="stylesheet" type="text/css" href="/css/global.css" />
   
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-18232057-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
</head>

<body>
    <div id="wrapper">
        <div id="container">
            <div id="top">
                <a href="/"><div id="logo">TB</div></a>
                <div id="heading">
                    <h1><a href="/">Thomas Bennett</a></h1>
                    <h2 class="main">I make websites and stuff.</h2>
                </div>

                <ul id="navContainer" class="inline">
                    <li id="work"><a href="/work">Work I've Done</a></li>
                    <?php /*<li id="blog"><a href="/blog">Read My Blog</a></li> */?>
                    <li id="about"><a href="/about">Where I'm From</a></li>
                    <li id="contact"><a href="/contact">Contact Me</a></li>
                </ul>
            </div>

            <?php echo $contents ?>
            <div class="clear"></div>

            <div id="footer">
                <?php include('footer.php') ?>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/cycle.js"></script>
    <script type="text/javascript" src="/js/init.js"></script>
    
    <!--[if gte IE 7]>
        <link rel="stylesheet" type"text/css" href="/css/ie.css" />
    <![endif]-->
 
</body>

</html>
