<?php
	
	require_once __DIR__."/User.php";

	$user = new User;
	var_dump($user->getAll( ["name"] ));