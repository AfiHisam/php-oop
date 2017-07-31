<?php

require_once 'core/init.php';


//echo Config::get('mysql/host'); //'127.0.0.1'

/*$user = DB::getInstance()->get('users',array('username','=','afi'));

if(!$user->count()){
	echo 'No User';
}
else {

	echo $user->first()->username;

----
	/*foreach ($user->results() as $user) {
		echo $user->username, '<br';
----


	}
-----
	$user = DB::getInstance()->insert('users',array(
		'username'=>'Adam',
		'password' => 'pass123',
		'salt' => 'salt'));
------

$user = DB::getInstance()->update('users',1,array(
		'password' => 'salt',
		'name' => 'salt'


		));

------		

		*/


require_once 'core/init.php';

if(Session::exists('home')){
	echo '<p>'.Session::flash('home').'<p>';
}

//echo Session::get(Config::get('session/session_name'));

$user = new User();

if($user->isLoggedIn()){
	//echo 'Logged In';
?>
	<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"> <?php echo escape($user->data()->username); ?> </a>!</p>

	<ul>
		<li><a href="logout.php">Log Out </a></li>
		<li><a href="update.php">Update Details </a></li>
		<li><a href="changepassword.php">Change Password</a></li>


	</ul>

<?php


	if($user->hasPermission('admin')){
		echo '<p> You are an admin </p>';

	}

}
else{

	echo '<p> You need to <a href="login.php">Log in</a> or <a href="register.php">register</a>';
}


?>