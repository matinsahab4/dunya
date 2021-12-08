<?php 

		$q = '$q';
		$t = '$query';
		for ($w=1; $w < 14; $w++) { 
			$o.$w = "UPDATE `stock` SET ,`count`=(`count`- '$q$w') 
			WHERE `id` = (SELECT `id` FROM `drug` WHERE `name` = '$d$w');"
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
