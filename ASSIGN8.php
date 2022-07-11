<?php
include("ASSIGN8LIB.php");
$username = 'HIDDEN';
$password = 'HIDDEN';
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
		echo "<input type=\"reset\" value=\"reset\"/><br>";
		print_r($_POST[0]);
echo "</form>";
echo " <form action=\"http://students.cs.niu.edu/~z1911688/ASSIGN8.php\" method=\"POST\">";
	echo "ENTER A SUPPLIER TO SEE THEIR PRODUCTS <br>";
	echo "<input type=\"text\" name=\"1\"/> SUPPLIER <br>";
	echo "<input type=\"submit\" value=\"submit\"/> <br>";
		if($_POST[1])
		{
			$prepared = $pdo->prepare('SELECT PNUM, QTY FROM SP WHERE SNUM = ?;');
			$prepared->execute(array($_POST[1]));				
			$check = $prepared->fetchColumn() ? 'True' : 'False';
		if($check == 'True')
		{
			$prepared = $pdo->prepare('SELECT PNUM, QTY FROM SP WHERE SNUM = ?;');
			$prepared->execute(array($_POST[1]));
			$prep = $prepared->fetchAll(PDO::FETCH_ASSOC);
			TablePrint($prep);
			$prepared = $pdo->prepare('SELECT SNUM, SNAME, STATUS, CITY FROM S WHERE SNUM = ?;');
			$prepared->execute(array($_POST[1]));
			$prep = $prepared->fetchAll(PDO::FETCH_ASSOC);
			TablePrint($prep);
		}
		else
		{
			echo "SUPPLIER NOT IN SET <br>";
		}
	}
	else
	{
		$_POST[1]='DEFAULT';
	}
	echo "<input type=\"reset\" value=\"reset\"/><br>";
	print_r($_POST);	
echo "</form>";
echo " <form action=\"http://students.cs.niu.edu/~z1911688/ASSIGN8.php\" method=\"POST\">";
	echo "ENTER PRODUCT PURCHASE DETAILS <br>";
	echo "<input type=\"text\" name=\"2\"/> PRODUCT <br>";
	echo "<input type=\"text\" name=\"3\"/> SUPPLIER <br>";
	echo "<input type=\"text\" name=\"4\"/> AMOUNT <br>";
	echo "<input type=\"submit\" value=\"submit\"/> <br>";
		if(($_POST[2])&&($_POST[3])&&($_POST[4]))
		{
			$prepared = $pdo->prepare('SELECT PNUM FROM SP WHERE PNUM = ? AND SNUM = ? AND QTY >= ?;');
			$prepared->execute(array($_POST[2],$_POST[3],$_POST[4]));				
			$check = $prepared->fetchColumn() ? 'True' : 'False';
		if($check == 'True')
		{
			$n = $pdo->exec("Update SP SET QTY = QTY - $_POST[4];");
			$prepared = $pdo->prepare('SELECT SNUM, PNUM, QTY FROM SP WHERE PNUM = ? AND SNUM = ?;');
			$prepared->execute(array($_POST[2],$_POST[3]));				
			$prep = $prepared->fetchAll(PDO::FETCH_ASSOC);
			TablePrint($prep);
		}
		else
		{
			echo "PRODUCT NOT AVAILBlE FOR PURCHASE AT THIS QUANTITY <br>";
		}
	}
	else
	{
		$_POST[2] = 'DEFAULT';
		$_POST[3] = 'DEFAULT'; 
		$_POST[4] = 'DEFAULT';
	}
echo "</form>";
echo "</form>";
echo " <form action=\"http://students.cs.niu.edu/~z1911688/ASSIGN8.php\" method=\"POST\">";
	echo "ENTER PRODUCT PURCHASE DETAILS <br>";
	echo "<input type=\"text\" name=\"5\"/> PNUM <br>";
	echo "<input type=\"text\" name=\"6\"/> PNAME <br>";
	echo "<input type=\"text\" name=\"7\"/> COLOR <br>";
	echo "<input type=\"text\" name=\"8\"/> WEIGHT <br>";
	echo "<input type=\"submit\" value=\"submit\"/> <br>";
		if(($_POST[5])&&($_POST[6])&&($_POST[7])&&($_POST[8]))
		{
			$prepared = $pdo->prepare('SELECT PNUM FROM P WHERE PNUM = ?');
			$prepared->execute(array($_POST[5]));				
			$prep = $prepared->fetchAll(PDO::FETCH_ASSOC);			
			$check = $prepared->fetchColumn() ? 'True' : 'False';
			if(!$check)
			{
				$n = $pdo->exec("INSERT INTO P (PNUM, PNAME, COLOR, WEIGHT) VALUES('$_POST[5]', '$_POST[6]', '$_POST[7]','$_POST[8]');");
				$prepared = $pdo->prepare('SELECT PNUM, PNAME, COLOR, WEIGHT FROM P WHERE PNUM = ?');
				$prepared->execute(array($_POST[5]));				
				$prep = $prepared->fetchAll(PDO::FETCH_ASSOC);
				TablePrint($prep);
			}
			else
			{
				echo "PRODUCT NOT AVAILABLE FOR RE_ENTRY";
			}
		}
	else
	{
		echo "PRODUCT NOT AVAILBlE FOR ENTRY <br>";
		$_POST[5] = 'DEFAULT';
		$_POST[6] = 'DEFAULT'; 
		$_POST[7] = 'DEFAULT';
		$_POST[8] = 'DEFAULT';
	}
echo "</form>";
echo " <form action=\"http://students.cs.niu.edu/~z1911688/ASSIGN8.php\" method=\"POST\">";
	echo "ENTER PRODUCT PURCHASE DETAILS <br>";
	echo "<input type=\"text\" name=\"9\"/> SNUM <br>";
	echo "<input type=\"text\" name=\"10\"/> SNAME <br>";
	echo "<input type=\"text\" name=\"11\"/> STATUS <br>";
	echo "<input type=\"text\" name=\"12\"/> CITY <br>";
	echo "<input type=\"submit\" value=\"submit\"/> <br>";
		if(($_POST[9])&&($_POST[10])&&($_POST[11])&&($_POST[12]))
		{
			$prepared = $pdo->prepare('SELECT SNUM FROM S WHERE SNUM = ?');
			$prepared->execute(array($_POST[9]));				
			$prep = $prepared->fetchAll(PDO::FETCH_ASSOC);			
			$check = $prepared->fetchColumn() ? 'True' : 'False';
			if($check)
			{
				$n = $pdo->exec("INSERT INTO S (SNUM, SNAME, STATUS, CITY) VALUES('$_POST[9]', '$_POST[10]', '$_POST[11]','$_POST[12]');");
				$prepared = $pdo->prepare('SELECT SNUM, SNAME, STATUS, CITY FROM S WHERE SNUM = ?');
				$prepared->execute(array($_POST[9]));				
				$prep = $prepared->fetchAll(PDO::FETCH_ASSOC);
				TablePrint($prep);
			}
			else
			{
				echo "SUPPLIER NOT AVAILABLE FOR RE_ENTRY";
			}
		}
	else
	{
		echo "PRODUCT NOT AVAILBlE FOR ENTRY <br>";
		$_POST[9] = 'DEFAULT';
		$_POST[10] = 'DEFAULT'; 
		$_POST[11] = 'DEFAULT';
		$_POST[12] = 'DEFAULT';
	}
echo "</form>";
echo "</body>";
echo "</html>";
}
catch(PDOexception $e) 
{ // handle that exception
	echo "Connection to database failed: " . $e->getMessage();
}
?>
