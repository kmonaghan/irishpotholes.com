<?php

?>
            <div id="push"></div>
            </div>
    </div>
    <div id="footer">
              <div class="container">
                <p class="muted credit">Built by <a href="http://karlmonaghan.com">Karl Monaghan</a>, <a href="http://www.linkedin.com/profile/view?id=4061341&trk=tab_pro">Barry O'Mahony</a> from an idea by <a href="https://twitter.com/AaronMcAllorum">Aaron McAllorum</a>.&nbsp;|&nbsp;<a href="http://www.karlmonaghan.com/contact">Get in touch</a>&nbsp;|&nbsp;<a href="/about.php">About</a>&nbsp;|&nbsp;<a href="https://github.com/kmonaghan/irishpotholes.com">Code</a>&nbsp;|&nbsp; <a href="https://twitter.com/IrishPotholes" class="twitter-follow-button" data-show-count="false">Follow @IrishPotholes</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if (!d.getElementById(id)) {js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></p>
        </div>
        </div>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="/js/bootstrap.js"></script>
<?php
    if (isset($js) && is_array($js)) {
        foreach ($js as $src) {
            echo "<script src='/js/{$src}.js?v=" . VERSION . "'></script>\n";
        }
    }
?>
    <script type="text/javascript">
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-5653857-13', 'irishpotholes.com');
            ga('send', 'pageview');
    </script>
  </body>
</html>
