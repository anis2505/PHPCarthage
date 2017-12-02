<?php $this->set_layout('testing/login'); ?>
<?php $this->start_block('sidebarsub'); ?>

This is a sub side bar !!!!<br/>


<?php $this->end_block(); ?>

<?php $this->start_block('contents'); ?>

This is a sub form<br/>

<?= $this->t('Register','default val') ?>
    <br/>
    <br/>

    <div class="one-half column">

        <?= $this->open('form') ?>

        <?php //$this->show_all('u-full-width', true);?>
                <?= $this->label('username'); ?>
                <?= $this->show('username', 'u-full-width'); ?>

                <?= $this->label('pwd'); ?>
                <?= $this->show('pwd', 'u-full-width'); ?>

                <?= $this->show('submit', 'green'); ?>
        <?= $this->close(); ?>

    </div>

<?php $this->end_block(); ?>