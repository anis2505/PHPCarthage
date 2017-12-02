<?php $this->setlayout('basic.main') ?>
<?php $this->startblock('contents') ?>

<?php
	$this->form->open();
	$this->form->show_all();
	$this->form->close();
?>
<a href="<?= $this->asset('datas/contrat.pdf') ?>">Contrat</a>
<?= $this->css('assets/calendar/css/calendar.css') ?>
<br/>
<?php /*include_controller('Users','findall',array('anis'))*/ ?>
<br/>
<div style='width: 100%;'>
<?= \System\Helpers\CalendarHelper::draw_calendar(8, 2017) ?>
</div>
<?php $this->endblock() ?>