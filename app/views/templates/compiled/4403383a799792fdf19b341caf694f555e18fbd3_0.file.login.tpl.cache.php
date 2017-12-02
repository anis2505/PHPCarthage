<?php /* Smarty version 3.1.27, created on 2015-08-10 15:49:33
         compiled from "/home/anis/public_html/myblog/app/Views/testing/login.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:66520451355c8b9fdb3f084_72656668%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4403383a799792fdf19b341caf694f555e18fbd3' => 
    array (
      0 => '/home/anis/public_html/myblog/app/Views/testing/login.tpl',
      1 => 1439218041,
      2 => 'file',
    ),
    '4240c2569bbd6d1b052bbfd0a7270482e85369b9' => 
    array (
      0 => '/home/anis/public_html/myblog/app/Views/templates/layout.tpl',
      1 => 1439135457,
      2 => 'file',
    ),
    '08e03208100fae0ba5ec30935f7d124458849954' => 
    array (
      0 => '08e03208100fae0ba5ec30935f7d124458849954',
      1 => 0,
      2 => 'string',
    ),
    '0a5ad22db5063025797fe04faf1dbd3f0465517f' => 
    array (
      0 => '0a5ad22db5063025797fe04faf1dbd3f0465517f',
      1 => 0,
      2 => 'string',
    ),
    'cc63baee79ec1ca5ecf848f51dd4b5f7a5c54657' => 
    array (
      0 => 'cc63baee79ec1ca5ecf848f51dd4b5f7a5c54657',
      1 => 0,
      2 => 'string',
    ),
    'bd21a9ed8d4a2f3de07f22acf1ebabfa7e7bac7e' => 
    array (
      0 => 'bd21a9ed8d4a2f3de07f22acf1ebabfa7e7bac7e',
      1 => 0,
      2 => 'string',
    ),
  ),
  'nocache_hash' => '66520451355c8b9fdb3f084_72656668',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55c8b9fddb3987_91105988',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55c8b9fddb3987_91105988')) {
function content_55c8b9fddb3987_91105988 ($_smarty_tpl) {
if (!is_callable('smarty_function_css')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.css.php';
if (!is_callable('smarty_function_js')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.js.php';
if (!is_callable('smarty_function_asset')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.asset.php';
if (!is_callable('smarty_function_form_open')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.form_open.php';
if (!is_callable('smarty_function_form_show_label')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.form_show_label.php';
if (!is_callable('smarty_function_form_show')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.form_show.php';
if (!is_callable('smarty_function_form_end')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.form_end.php';

$_smarty_tpl->properties['nocache_hash'] = '66520451355c8b9fdb3f084_72656668';
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs -->
  <meta charset="utf-8">
  <title><?php
$_smarty_tpl->properties['nocache_hash'] = '66520451355c8b9fdb3f084_72656668';
?>

        Smarty testing from subfolder
    </title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS -->
    <?php echo smarty_function_css(array('file'=>'assets/css/normalize.css'),$_smarty_tpl);?>

    <?php echo smarty_function_css(array('file'=>'assets/css/skeleton.css'),$_smarty_tpl);?>

    <!-- Page specific CSS scripts -->
    <?php
$_smarty_tpl->properties['nocache_hash'] = '66520451355c8b9fdb3f084_72656668';
?>

    <?php echo smarty_function_css(array('file'=>'assets/css/ap1p.css'),$_smarty_tpl);?>



    <!-- Page specific JS scripts -->
    <?php
$_smarty_tpl->properties['nocache_hash'] = '66520451355c8b9fdb3f084_72656668';
?>

    <?php echo smarty_function_js(array('file'=>'assets/js1/jquery-2.1.3.js'),$_smarty_tpl);?>


  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?php echo smarty_function_asset(array('file'=>'assets/img/favicon.png'),$_smarty_tpl);?>
">

</head>
<body>

  <!-- Primary Page Layout -->
  <div class="container">
        <?php
$_smarty_tpl->properties['nocache_hash'] = '66520451355c8b9fdb3f084_72656668';
?>

    <div class="one-half column">
        <?php echo smarty_function_form_open(array('form'=>'form'),$_smarty_tpl);?>

        <fieldset>
            <?php echo smarty_function_form_show_label(array('field'=>'username'),$_smarty_tpl);?>

            <?php echo smarty_function_form_show(array('field'=>'username','class'=>'u-full-width'),$_smarty_tpl);?>

        </fieldset>
        <fieldset>
            <?php echo smarty_function_form_show_label(array('field'=>'pwd'),$_smarty_tpl);?>

            <?php echo smarty_function_form_show(array('field'=>'pwd','class'=>'u-full-width'),$_smarty_tpl);?>

        </fieldset>
        <fieldset>
            <?php echo smarty_function_form_show(array('field'=>'submit','class'=>'green'),$_smarty_tpl);?>

        </fieldset>
        <?php echo smarty_function_form_end(array('form'=>'form'),$_smarty_tpl);?>


    </div>

  </div>
<!-- End Document -->
</body>
</html>
<?php }
}
?>