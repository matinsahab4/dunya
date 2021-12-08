<?php 

	if (isset($_POST['addtoprescription'])) {
		$d1 = $_POST['d1'];
		$d2 = $_POST['d2'];
		$d3 = $_POST['d3'];
		$d4 = $_POST['d4'];
		$d5 = $_POST['d5'];
		$d6 = $_POST['d6'];
		$d7 = $_POST['d7'];
		$d8 = $_POST['d8'];
		$d9 = $_POST['d9'];
		$d10 = $_POST['d10'];
		$d11 = $_POST['d11'];
		$d12 = $_POST['d12'];
		$d13 = $_POST['d13'];
		$q1 = $_POST['q1'];
		$q2 = $_POST['q2'];
		$q3 = $_POST['q3'];
		$q4 = $_POST['q4'];
		$q5 = $_POST['q5'];
		$q6 = $_POST['q6'];
		$q7 = $_POST['q7'];
		$q8 = $_POST['q8'];
		$q9 = $_POST['q9'];
		$q10 = $_POST['q10'];
		$q11 = $_POST['q11'];
		$q12 = $_POST['q12'];
		$q13 = $_POST['q13'];
		$date = date('m-d-Y');
		$o = '$command';
		$q = '$q';
		$t = '$query';
		for ($w=1; $w < 14; $w++) { 
			$o.$w = "UPDATE `stock` SET ,`count`=(`count`- '$q$w') 
			WHERE `id` = (SELECT `id` FROM `drug` WHERE `name` = '$d$w');"
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		