<html>
<head>
    <title>Smarty testing from subfolder</title>
</head>
<body>

{ include file="index.tpl" }

<a href="{asset file='datas/contrat.pdf'}">Contrat</a>
{css file='assets/css/app.css'}
{js file='assets/js/jquery-2.1.3.js'}

<a href="{uri callback='testing' action='smartytest' p1='eat'}">Users</a>

{translate default="hello"}{$word}{/translate}<br/>
{translate}eat{/translate}<br/>
Mon nom est {$name}.

{show_flash item='flash'}
    <br/>Session Flash messages
    {foreach $flash as $type => $value}
        <br/>{$type}<br/>
        {$value}
    {/foreach}

{/show_flash}

<br/><br/>
Second call
<br/><br/>

{show_flash item='flash'}
    <br/>Session Flash messages
{foreach $flash as $type => $value}
    <br/>{$type}<br/>
    {$value}
{/foreach}

{/show_flash}

</body>
</html>