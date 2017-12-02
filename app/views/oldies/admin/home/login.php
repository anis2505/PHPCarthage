<html>
<head>
<title>Login</title>


</head>

<body>
<h1>Login form</h1>
<?php
echo $this->e('Hello world:').'<br/>';
$form->setAction('http://localhost/~anis/tinyphp/admin/home/create');

$this->form_open($form);

$this->form_show_all();
$this->form_close();
?>
</body>


//var_dump($this->data['form']);
</html>


