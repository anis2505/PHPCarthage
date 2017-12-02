
<?php
    $title = 'List posts';
    $keywords = 'list, posts';
?>
<div class="page-header">
    <h1>posts</h1>
</div>
<!-- Standard button -->
<a href="<?= URI('posts','create'); ?>" style="margin-bottom: 10px" class="btn btn-primary pull-right">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>New post
</a>
<table id="table" class="table table-striped table-bordered">
	<thead>
    <tr>
        <th><input type="checkbox"></th>
        <th>Identifier</th>
        <th>Title</th>
        <th>Body</th>
        <th>Published</th>
        <th>Updated</th>
  </tr>
    </thead>
    <tbody>
<?php
		if(count($posts))
		{
			foreach($posts as $post)
			{
?>	
  <tr>
	<td><input type="checkbox"></td>
    <td><?php e($post->id); ?></td>
    <td><?php e($post->title); ?></td>
     <td><?php e($post->body); ?></td>
     <td><?php e($post->published); ?></td>
      <td><?php e($post->created_at); ?></td>
  </tr>

<?php
            }
        }
else
{
    echo"<tr><td colspan='6'><p class='text-info'>No posts available</p></td></tr>";
}
?>
    </tbody>
</table>

