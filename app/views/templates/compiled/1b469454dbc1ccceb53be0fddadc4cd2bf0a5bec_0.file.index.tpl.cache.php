<?php /* Smarty version 3.1.27, created on 2015-08-08 12:56:58
         compiled from "/home/anis/public_html/myblog/app/Views/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:106241971055c5ee8ae04e64_45798164%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b469454dbc1ccceb53be0fddadc4cd2bf0a5bec' => 
    array (
      0 => '/home/anis/public_html/myblog/app/Views/index.tpl',
      1 => 1438987931,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '106241971055c5ee8ae04e64_45798164',
  'variables' => 
  array (
    'word' => 0,
    'name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55c5ee8ae3c1c7_17362267',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55c5ee8ae3c1c7_17362267')) {
function content_55c5ee8ae3c1c7_17362267 ($_smarty_tpl) {
if (!is_callable('smarty_block_translate')) require_once '/home/anis/public_html/myblog/darwin/Libs/Template/plugins/block.translate.php';

$_smarty_tpl->properties['nocache_hash'] = '106241971055c5ee8ae04e64_45798164';
?>
<html>
<head>
    <title>Test Smarty</title>
</head>
<body>
The index page
<?php $_smarty_tpl->smarty->_tag_stack[] = array('translate', array()); $_block_repeat=true; echo smarty_block_translate(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();
echo $_smarty_tpl->tpl_vars['word']->value;
$_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_translate(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<br/>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('translate', array()); $_block_repeat=true; echo smarty_block_translate(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
eat<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_translate(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<br/>
Mon nom est <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
.
<hr/>
<br/>
</body>
</html><?php }
}
?>