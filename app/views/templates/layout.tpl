<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs -->
  <meta charset="utf-8">
  <title>{block name='title'}{/block}</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS -->
    {css file='assets/css/normalize.css'}
    {css file='assets/css/skeleton.css'}
    <!-- Page specific CSS scripts -->
    {block name='css'}

    {/block}

    <!-- Page specific JS scripts -->
    {block name='js'}

    {/block}
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{asset file='assets/img/favicon.png'}">

</head>
<body>

  <!-- Primary Page Layout -->
  <div class="container">
        {block name='body'}

        {/block}
  </div>
<!-- End Document -->
</body>
</html>
