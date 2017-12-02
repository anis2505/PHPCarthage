<?php $this->insert('templates.basic.header'); ?>
<h1>Main template</h1>
<?php $this->startblock('contents'); ?>
<?php $this->endblock(); ?>
<?php $this->startblock('sidebar1'); ?>
    <ul>
        <li>A</li>
        <li>B</li>
        <li><?php $this->startblock('sidebar'); ?><?php $this->endblock(); ?></li>
        <li>C</li>
        <li>D</li>
        <li>E</li>

    </ul>
<?php $this->endblock(); ?>
<?= $this->e("<br/>SubSideBar starting<br/>") ?>

<?= $this->e("<script type='text/javascript'>alert('Hello');</script>") ?>

<?php $this->startblock('sidebarsub'); ?>
bbbbb
<?php $this->endblock(); ?>
<br/>SubSideBar ending<br/>
<?php $this->insert('templates.basic.footer'); ?>
<br/><br/>