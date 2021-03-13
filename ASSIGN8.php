<?php
include("ASSIGN8LIB.php");
$username = 'z1911688';
$password = '1998Dec20';
echo "<html><head><title>ASSIGNMENT8</title></head>";
echo "<body>";
echo " <form action=\"http://students.cs.niu.edu/~z1911688/ASSIGN8.php\" method=\"POST\">";
echo "SUPPLIERS DETAILS <br>";
try 
{ // if something goes wrong, an exception is thrown
		$dsn = "mysql:host=courses;dbname=z1911688";
		$pdo = new PDO($dsn, $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql ="SELECT * FROM S;";
		$rs = $pdo->query($sql);
		$result = $rs->fetchAll(PDO::FETCH_ASSOC);
		TablePrint($result);
		echo "PRODUCT DETAILS<br>";
		$sql ="SELECT * FROM P;";
		$rs = $pdo->query($sql);
		$result = $rs->fetchAll(PDO::FETCH_ASSOC);
		TablePrint($result);
		echo "ENTER A PRODUCT NUMBER FROM THE LIST FOR INFO <br>";
		echo "<input type=\"text\" name=\"0\"/> PRODUCT <br>";
		echo "<input type=\"submit\" value=\"submit\"/> <br>";
		if($_POST[0])
		{
			$prepared = $pdo->prepare('SELECT SNUM, QTY FROM SP WHERE PNUM = ?;');
			$prepared->execute(array($_POST[0]));				
			$check = $prepared->fetchColumn() ? 'True' : 'False';
			if($check == 'True')
			{
				$prepared = $pdo->prepare('SELECT SNUM, QTY FROM SP WHERE PNUM = ?;');
				$prepared->execute(array($_POST[0]));
				$prep = $prepared->fetchAll(PDO::FETCH_ASSOC);
				TablePrint($prep);
				$prepared = $pdo->prepare('SELECT PNUM, PNAME, COLOR, WEIGHT FROM P WHERE PNUM = ?;');
				$prepared->execute(array($_POST[0]));
				$prep = $prepared->fetchAll(PDO::FETCH_ASSOC);
				TablePrint($prep);
			}
			else
			{
				echo "PRODUCT NOT IN SET <br>";
			}
		}
		else
		{
			$_POST[0]='DEFAULT';
		}
