

<?php start_block() ?>

<ul>
    <li>a</li>
    <li>b</li>
    <li>a</li>
    <li>b</li>
    <li>a</li>
    <li>b</li>
</ul>
<?php $sidebar = end_block(); ?>


<div class="caption">Users</div>
<div id="table">
	<div class="header-row row">
    <span class="cell primary">Identifier</span>
    <span class="cell">First Name</span>
     <span class="cell">Last Name</span>
    <span class="cell">Date of birth</span>
  </div>
<?php
		if(count($users))
		{
			foreach($users as $user)
			{
?>	
  <div class="row">
	<input type="radio" name="expand">
    <span class="cell primary" data-label="Identifier"><?php e($user->id); ?></span>
    <span class="cell" data-label="First Name"><?php e($user->first_name); ?></span>
     <span class="cell" data-label="Last Name"><?php e($user->last_name); ?></span>
     <span class="cell" data-label="Date of birth"><?php e($user->dob); ?></span>
  </div>

<?php } } ?>
</div>

