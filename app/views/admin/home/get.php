<?php
<?php $this->setlayout('bootstrap.main') ?>

<?php $this->startblock('contents') ?>
<?php var_dump($users); ?>
<table class='table'>
	<thead>
		<td>ID</td>
		<td>FirstName</td>
		<td>LastName</td>
		<td>DOB</td>
	</thead>
	<tbody>
	<?php foreach($users as $user){ ?>
	<tr>
	<td><?= $user['id'] ?></td>
	<td><?= $user['first_name'] ?></td>
	<td><?= $user['last_name'] ?></td>
	<td><?= $user['dob'] ?></td>
	
	</tr>
	<?php } ?>
	</tbody>
	
</table>

<?php $this->endblock() ?>
