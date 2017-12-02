<?php /* Smarty version 3.1.27, created on 2015-08-09 01:47:00
         compiled from "/home/anis/public_html/myblog/app/Views/testing/smartytest.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:54533362555c6a304cd7b74_17082096%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0e777b163b7057e9b338e4f8145e9c29f937af3' => 
    array (
      0 => '/home/anis/public_html/myblog/app/Views/testing/smartytest.tpl',
      1 => 1439048954,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54533362555c6a304cd7b74_17082096',
  'variables' => 
  array (
    'word' => 0,
    'name' => 0,
    'flash' => 0,
    'type' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55c6a304e46bb0_21519262',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55c6a304e46bb0_21519262')) {
function content_55c6a304e46bb0_21519262 ($_smarty_tpl) {
if (!is_callable('smarty_function_asset')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.asset.php';
if (!is_callable('smarty_function_css')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.css.php';
if (!is_callable('smarty_function_js')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.js.php';
if (!is_callable('smarty_function_uri')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/function.uri.php';
if (!is_callable('smarty_block_translate')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/block.translate.php';
if (!is_callable('smarty_block_show_flash')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/block.show_flash.php';

$_smarty_tpl->properties['nocache_hash'] = '54533362555c6a304cd7b74_17082096';
?>
<html>
<head>
    <title>Smarty testing from subfolder</title>
</head>
<body>

{ include file="index.tpl" }

<a href="<?php echo smarty_function_asset(array('file'=>'datas/contrat.pdf'),$_smarty_tpl);?>
">Contrat</a>
<?php echo smarty_function_css(array('file'=>'assets/css/app.css'),$_smarty_tpl);?>

<?php echo smarty_function_js(array('file'=>'assets/js/jquery-2.1.3.js'),$_smarty_tpl);?>


<a href="<?php echo smarty_function_uri(array('callback'=>'testing','action'=>'smartytest','p1'=>'eat'),$_smarty_tpl);?>
">Users</a>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('translate', array('default'=>"hello")); $_block_repeat=true; echo smarty_block_translate(array('default'=>"hello"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();
echo $_smarty_tpl->tpl_vars['word']->value;
$_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_translate(array('default'=>"hello"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<br/>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('translate', array()); $_block_repeat=true; echo smarty_block_translate(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
eat<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_translate(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<br/>
Mon nom est <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
.

<?php $_smarty_tpl->smarty->_tag_stack[] = array('show_flash', array('item'=>'flash')); $_block_repeat=true; echo smarty_block_show_flash(array('item'=>'flash'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

    <br/>Session Flash messages
    <?php
$_from = $_smarty_tpl->tpl_vars['flash']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['value']->_loop = false;
$_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['type']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$foreach_value_Sav = $_smarty_tpl->tpl_vars['value'];
?>
        <br/><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
<br/>
        <?php echo $_smarty_tpl->tpl_vars['value']->value;?>

    <?php
$_smarty_tpl->tpl_vars['value'] = $foreach_value_Sav;
}
?>

<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_show_flash(array('item'=>'flash'), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


<br/><br/>
Second call
<br/><br/>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('show_flash', array('item'=>'flash')); $_block_repeat=true; echo smarty_block_show_flash(array('item'=>'flash'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

    <br/>Session Flash messages
<?php
$_from = $_smarty_tpl->tpl_vars['flash']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['value']->_loop = false;
$_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['type']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$foreach_value_Sav = $_smarty_tpl->tpl_vars['value'];
?>
    <br/><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
<br/>
    <?php echo $_smarty_tpl->tpl_vars['value']->value;?>

<?php
$_smarty_tpl->tpl_vars['value'] = $foreach_value_Sav;
}
?>

<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_show_flash(array('item'=>'flash'), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


</body>
</html><?php }
}
?>