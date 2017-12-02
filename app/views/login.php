
    <div class="one-half column">
    <?php $form->open()?>
        <fieldset>
            <?php $form->show_label('username'); ?>
            <?php $form->show('username', 'u-full-width'); ?>
        </fieldset>
        <fieldset>
            <?php $form->show_label('pwd'); ?>
            <?php $form->show('pwd', 'u-full-width'); ?>
        </fieldset>
        <fieldset>
            <?php $form->show('submit', 'green'); ?>
        </fieldset>
    <?php $form->close(); ?>
    </div>