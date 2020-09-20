<?php
	
	require_once __DIR__."/controllers/Customer.php";
	require_once __DIR__."/controllers/House.php";
	$Customer = new Customer;
	$House = new House;

	//add Method
	/*
		$Customer->add([
			"name" => "Jorge",
			"lastName" => "Mena",
			"address" => "Managua Nicaragua",
		]);
		$House->add([
			"address" => "elm street",
			"city" => "baltimore",
			"state" => "SSS",
		]);
	*/
	
	//getAll Method
	/* 
		$Customer->getAll();
		$House->getAll();
	*/

	//getOne Method
	/*
		$Customer->getOne(1, "id");
		$House->getOne(1, "id");
	*/
	
	//Update method
	/* 
		$Customer->update([
			"id" => 1,
			"name" => "Kenned Issac",
			"lastName" => "Mena Martinez",
			"address" => "Managua Nicaragua",
		]);
		
		$House->update([
			"id" => 1,
			"address" => "Managua",
			"city" => "Nicaragua",
			"state" => "Nicaragua",
		]);
	*/

	//Delete method
	/* 
		$Customer->delete(2, "id");
		$House->delete(2, "id");
	*/
?>
