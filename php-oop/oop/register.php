<?php


require_once 'core/init.php';


if(Input::exist()){
	//var_dump(Token::check(Input::get('token')));

	if(Token::check(Input::get('token'))){
		$validate = new validate();
		$validation = $validate->check($_POST, array(

			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'users'

				),

			'password' => array(
				'required' => true,
				'min' => 6

				),
			'password_again' => array(
				'required' => true,
				'matches' => 'password'

				),
			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50

				)


			));

		if($validation->passed()){
			/*Session::flash('success', 'You registered successfully');
			header('Location: index.php'); */

			$user = new User();

			$salt = Hash::salt(32);


			try{

				$user->create(array(

					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'name' => Input::get('name'),
					'joined' => date('Y-m-d H:i:s'),
					'group' => 1

					));

				Session::flash('home', 'You registered successfully and can now log in !');
				//header('Location: index.php'); 
				Redirect::to(404);

			}catch(Exception $e){
				die($e->getMessage());

			}

		}else {

			foreach($validation->errors() as $error){

				echo $error, '<br>';
			}


		}

	}	//echo Input::get('username'); //$_POST['username'];
}

?>

<form action="" method="post">

	<div class="field">
	<label for="username">Username</label>
	<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
	</div>

	<div class="field">
	<label for="password">Insert password</label>
	<input type="password" name="password" id="password">
	</div>

	<div class="field">
	<label for="password_again">Insert password again</label>
	<input type="password" name="password_again" id="password_again">
	</div>

	<div class="field">
	<label for="name">Fullname</label>
	<input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>" >
	</div>
<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
<input type="submit" value="Register">

</form>