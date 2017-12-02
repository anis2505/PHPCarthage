<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{block name='title'}{/block}</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <script type="text/javascript">
        /mobi/i.test(navigator.userAgent) && !location.hash && setTimeout(function () {
          if (!pageYOffset) window.scrollTo(0, 1);
        }, 1000);
    </script>

	<!-- CSS -->
    {css file='assets/css/base.css'}
	{css file='assets/css/amazium.css'}
    {css file='assets/css/form.css'}
	{css file='assets/css/layout.css'}

    <!-- Page specific CSS scripts -->
    {block name='css'}

    {/block}

	<!-- Favicons -->
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon.png">
</head>
<body>

<section class="row">
    <article class="grid_6">

{block name='body'}

{/block}

        </article>
</section>
<!-- Scripts -->
{js file='assets/js/jquery-1.8.0.min.js'}
{js file='assets/js/amazium.js'}
<!-- Page specific JS scripts -->
{block name='js'}

{/block}
</body>
</html>
