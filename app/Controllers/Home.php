<?php
namespace App\Controllers;

use System\Controller;

use App\Models\User;



class Home extends Controller
{
    
	public function index($name="")
	{
	    $data = array(
	        'title' =>'Home page',
	        'keywords' =>'carthage, framework, php'
	    );
	    
	    $this->template->render('home.index', $data);
	}
	
	public function test()
	{
	    $form = new \App\Forms\SampleForm();
	    $data = array(
	        'title' =>'Home page',
	        'keywords' =>'carthage, framework, php',
	        'form'=>$form
	    );
	    $this->template->render('home.formtest',$data);
	}
	
	public function salute($id, $name='zzz')
	{
	    echo '<br/>Id: '.$id;
	    echo '<br/>Name: '.$name;
	}

	public function get()
	{
	    
	    //$users = User::find_by_first_name('Imèn');
	    $users = User::findBySql('Select * from users where id=?',array(10));
	    $this->template->render('home.get',array('users'=>$users));
	    
	    
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
	
	public function login()
	{
		$form = new \System\Libs\UserManager\Forms\LoginForm();
		$this->request = $this->container->get('Request');
		
		if(($data = $this->request->getPost('login')) !== null)
	    {
	        if($form->setData($data)->validate())
	        {
				$userManager = $this->container->get('UserManager');
				if($userManager->logUserIn($data))
					echo 'Logged in';
				else
					echo 'Error logging';
	           
	        }
			else
			{
				 echo '<pre>';
	            print_r($form->getErrorFields());
			}
	        return;
	    }
		
		$this->template->render('home.login',array('form'=>$form));
	}
	
	public function find()
	{
		$users = User::find();//[], ['id='=>1]);//,'username='=>'anis','firstname='=>'Imèn']);
		//$users = User::findBySql('Select * from users where id=15');
		echo '<pre>';
		print_r($users);
	}


}
