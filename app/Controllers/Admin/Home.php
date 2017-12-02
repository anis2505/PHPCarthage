<?php
namespace App\Controllers\Admin;

use System\Controller;

use App\Models\User;



class Home extends Controller
{
    
	public function index($name='')
	{
	    $this->input = $this->container->get('Request');
	    $this->session = $this->container->get('Session');
		$id = $this->input->getQuery('id');
		$lang = $this->session->get('lang');
		$this->template->render('admin.home.index',array('name'=>$name.'ANIIIS', 'lang'=>$lang,'title' =>'Home page',
	        'keywords' =>'carthage, framework, php'));
	}
	
	public function test()
	{
	    $form = new \App\Forms\SampleForm();
	    
	    $this->template->render('home.formtest',array('form'=>$form));
	}
	
	public function login()
	{
	    //echo "hello world";
	    $form = new \App\Forms\SampleForm();
	    /*$this->request = $this->container->get('Request');
	    
	    if(($data = $this->request->getPost('form')) !== null)
	    {
	        if(! $form->setData($data)->validate())
	        {
	            echo '<pre>';
	            var_dump($form->getErrorFields());
	        }
	        
	        //print_r($data);
	    }
	    else
	    {
	        $this->template->render('admin.home.login',array('form'=>$form));
	    }*/
	    $this->template->render('admin.home.login',array('form'=>$form));
	    //var_dump($form);
	    
	    
	    
	}
	
	public function create()
	{
	    echo "Hello world";
	    $form = new \App\Forms\UserForm();
	    $this->request = $this->container->get('Request');
	    
	    if(($data = $this->request->getPost('form')) !== null)
	    {
	        if(! $form->setData($data)->validate())
	        {
	            echo '<pre>';
	            print_r($form->getErrorFields());
	        }
	        
	        //print_r($data);
	    }
	}
	
	public function salute($id, $name='zzz')
	{
	    echo '<br/>Id: '.$id;
	    echo '<br/>Name: '.$name;
	}

	public function get()
	{
	    
	    //$users = User::find_by_first_name('Imèn');
	    $users = User::find('all');//_by_sql('Select * from users where id=?',array(10000));
	    echo "<pre>";
	    var_dump($users[0]);
	    //$this->template->render('admin.home.get',array('users'=>$users));
	    
	    
	    /*
		//echo "Private method will never be called<br/>";
		
		$user = User::find(1);// new User();
		echo '<br/>Firstname: '.$user->first_name;
		echo '<br/>Lastname: '.$user->last_name;
		echo '<br/>DOB: '.$user->dob.'<br/>';
		
		$user->first_name = 'Imèn';
		$user->last_name = "M'rad";
		$user->dob = date("Y-m-d",strtotime('1988-12-09'));
		$user->save();
		//$user->update_attributes(array('first_name'=>'Imèn','last_name'=>"M'rad",'dob'=>date("Y-m-d",strtotime('1988-12-09'))));
		
		*/
	}


}