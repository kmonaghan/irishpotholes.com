<?php

?>
      <div id="push"></div>
    </div>

    <div id="footer">
      <div class="container-fluid">
        <p class="muted credit">Built by <a href="http://karlmonaghan.com">Karl Monaghan</a> from an idea by <a href="https://twitter.com/AaronMcAllorum">Aaron McAllorum</a>.&nbsp;|&nbsp;<a href="http://www.karlmonaghan.com/contact">Get in touch</a>&nbsp;|&nbsp;<a href="http://www.karlmonaghan.com/">About</a>&nbsp;|&nbsp;<a href="https://github.com/kmonaghan/irishpotholes.com">Code</a></p>
      </div>
    </div>
	<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="/js/bootstrap.js"></script>
<?php 
	if (isset($js) && is_array($js))
	{
		foreach ($js as $src)
		{
			echo "<script src='/js/{$src}.js'></script>\n";
		}
	}
?>
<script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-5653857-13', 'irishpotholes.com');
        ga('send', 'pageview');

</script>
  </body>
</html>
