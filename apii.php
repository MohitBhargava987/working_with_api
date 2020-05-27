<?php
	$request_method = $_SERVER['REQUEST_METHOD'];

	$response = array();

	switch($request_method)
	{
		case "GET":
			response(doGet());
		break;
		
		case "POST":
			response(doPost());
		break;
		
		case "DELETE":
			response(doDelete());
		break;
		
		case "PUT":
			response(doPut());
		break;	

	}

	function doGet()
	{

		if(@$_GET['id'])
		{
			@$id = $_GET['id'];
			$where = "WHERE `id` =".$id;
		}
		else
		{
			$id = 0;
			$where = "";
		}
		
		$dbconnect = mysqli_connect("localhost","root","","customers");
		$query = mysqli_query($dbconnect, "SELECT * FROM customers ".$where);
		while($data = mysqli_fetch_assoc($query))
		{
			$response[] = array("customer_id"=>$data['id'],"customer_name"=>$data['customer_name']);
		}
		return $response;

	}

	function doPost()
	{
		if($_POST)
		{
			$dbconnect = mysqli_connect("localhost","root","","customers");
			$query = mysqli_query($dbconnect, "INSERT INTO customers (customer_name , email) VALUES 
				('".$_POST['customer_name']."','".$_POST['email']."')");



			if($query == true)
			{
				$response = array("message" => "Post Success");
			}			
			else
			{
				$response = array("message" => "Post Failed");
			}
		}

		
		return $response;
	}

	function doDelete()
	{
		if($_GET['id'])
		{
			$dbconnect = mysqli_connect("localhost","root","","customers");
			$query = mysqli_query($dbconnect, "DELETE FROM customers WHERE id = '".$_GET['id']."'");

			


			if($query == true)
			{
				$response = array("message" => "Deletion Success");
			}			
			else
			{
				$response = array("message" => "Deletion Failed");
			}
		}

		
		return $response; 
	}

	function doPut()
	{

		parse_str(file_get_contents('php://input'),$_PUT);
		print_r($_PUT);

		if($_PUT)
		{
			$dbconnect = mysqli_connect("localhost","root","","customers");
			$query = mysqli_query($dbconnect, "UPDATE customers SET 
				customer_name = '".$_PUT['customer_name']."' ,
				email = '".$_PUT['email']."' 
				WHERE id = '".$_GET['id']."'
				");

			



			if($query == true)
			{
				$response = array("message" => "Post Success");
			}			
			else
			{
				$response = array("message" => "Post Failed");
			}
		}
		return $response;
	}			

	//output

	function response($response)
	{
		echo json_encode(array("Status" => "225" , "   data"=>$response));
	}
?>