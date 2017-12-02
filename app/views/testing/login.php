<?php $this->set_layout('templates/basic/main');?>
<?php $this->start_block('sidebar'); ?>

This is a side bar from login !!!!<br/>

<?php $this->start_block('sidebarsub'); ?>

<?php $this->end_block(); ?>

<?php $this->end_block(); ?>

<?php $this->start_block('contents'); ?>

    <br/>Login Form<br/>

<?= $this->t('Register','default val') ?>
    <br/>
    <br/>

    <div class="one-half column">

        <?= $this->open('form') ?>
        <?= $this->show_all();?>
                <?= $this->label('username'); ?>
                <?= $this->show('username', 'u-full-width'); ?>

                <?= $this->label('pwd'); ?>
                <?= $this->show('pwd', 'u-full-width'); ?>

                <?= $this->show('submit', 'green'); ?>
        <?= $this->close(); ?>

    </div>

<?php $this->end_block(); ?>

<?php $this->start_block('sidebarsub'); ?>

<?php $this->end_block(); ?>