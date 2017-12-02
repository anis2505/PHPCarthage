<?php
$template ="default";
$title = 'New post';
$keywords = 'new, post, add';
?>

<?php
	$form->open('uk-form');
	echo '<div class="form-group">';
    $form->show_label('title');
	$form->show('title','form-control');
    echo '</div>';
    echo '<div class="form-group">';
	$form->show_label('body');
	$form->show('body','form-control');
    echo '</div>';
    echo '<div class="form-group">';
	$form->show_label('published');
	$form->show('published','form-control');
    echo '</div>';
    echo '<div class="form-group">';
	$form->show('submit','btn btn-primary');
	echo '</div>';
	//$form->showAll();
	$form->close();
?>