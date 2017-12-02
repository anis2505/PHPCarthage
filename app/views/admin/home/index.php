<?php $this->setlayout('bootstrap.main') ?>

<?php $this->startblock('contents') ?>

<div class="well">

<?php echo $this->_t('Register','default').'<br/>';?>
<?php echo _('Register').'<br/>';?>
<?php
    //echo gettext("Hello, %Anis, it is nice to see you today!");
    //printf(gettext("Hello, %s, it is nice to see you today!"),'Anis');
echo $this->lang.'<br/>';    
?>

<a href="<?= $this->hardroute('home','test'); ?>">Test</a>
<a href="<?= $this->route('salute',array('id'=>1)); ?>">Test</a>
    <h1>The Carthage PHP Framework</h1>
    <p>Simple modern PHP framework<br/>Inspired by the great PHP framworks "CodeIgniter, Symfony"
    </p>
</div>

<?php $this->endblock() ?>