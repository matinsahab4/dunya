<?php 
		ob_start();
		session_start();
	if (!isset($_SESSION['scashier'])) {
		header('location: logout.php');
	}
	require('conn.php');
	include('cashiertop.php');
	$scommand = "SELECT * FROM `status` ORDER BY `room-id` ASC";
	$squery = mysqli_query($con, $scommand);
	if (isset($_POST['lai'])) {
		foreach ($_POST as $key => $value) {
		$command = "UPDATE `status` SET `room-status` = '1' WHERE `room-id` = $key";
		$query = mysqli_query($con,$command);
		}
		header('location: roomstatus.php?upd=Status Updated');
	}

?>
	<!-- // ********************************************* ROOM DISPLAY - SECTION *********************************** -->
<!DOCTYPE html>
<html>
<head>
<link href="vendor/bootstrap/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="vendor/bootstrap/js/bootstrap4-toggle.min.js"></script>
</head>
<body>
<form action="roomstatus.php" method="post">
<div class="container" style="margin-top: 50px">
<?php if (isset($_GET['updatedmanualy'])) { ?>
<h4 style="color: red; margin-bottom: 10px;">Updated Manuly</h4>
<?php } ?>
<?php if (isset($_GET['upd'])) { ?>
<h4 style="color: red; margin-bottom: 10px;"><?php echo $_GET['upd']; ?></h4>
<?php } ?>
<table class="table table-borderless table-dark" style="text-align: center;">
	<?php if (mysqli_num_rows($squery) > 0) { ?>
  <thead >
    <tr>
      <th style="text-align: center;" scope="col">Room ID</th>
      <th style="text-align: center;" scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
  	<input type="hidden" name="lai">
	<?php while ($row = mysqli_fetch_assoc($squery)) {
	?>
      <tr>
        <td><?php echo '<h4>' . $row['room-id'] . '</br>' ; ?></td>
        <td><?php if($row['room-status'] == '1'){
        	// CODE HERE
        	echo "<input name='" . $row["room-id"] . "' type='checkbox' checked data-toggle='toggle' data-on='Ready' data-off='Full'
        	data-onstyle='success' data-offstyle='danger' data-size='sx' <br>
        	";
        }

         elseif($row['room-status'] == '0'){
      		// CODE HERE
        	echo "<input name='" . $row["room-id"] . "' type='checkbox' unchecked data-toggle='toggle' data-on='Ready' data-off='Full'
        	data-onstyle='success' data-offstyle='danger' data-size='sx'<br>
        	";

      	}}?>
      	
      </td>
  	<?php } ?>
      </tr>
  </tbody>
</table>
<input type="submit" style="margin-bottom: 30px;" class="btn btn-info">
</form>
<h4 style="margin-bottom: 10px; color: gray;">Click Ready All to make all rooms ready.</h4>
<h4><a href="roomstatus.php?updatestatus" style="margin-bottom: 20px;" class="btn btn-info">Ready All</a></h4>
</div>
<center><h4 style="color: gray; margin-bottom: 10px;">All the rooms will make themselves ready if this page loads at or before 10 in the morning.</h4></center>
</body>
</html>
<!-- ******************************************* UPDATE STATUS ******************************* -->
<?php
	if (isset($_GET['updatestatus'])) {
		$command = "UPDATE `status` SET `room-status` = 1";
		$query68 = mysqli_query($con, $command);
		if ($query68) {
			header('location: roomstatus.php?updatedmanualy');
		}
	}
?>
<!-- ********** HERE IS THE CODE TO REFRESH AUTOMATICALLY THE ROOM STATUS BASED ON DATE TO EMPTY ************ -->
<?php
	// $time = '';
	// $time = date('H:i');
	// if ($time <= '10:00') {
	// 	$command6 = "SELECT COUNT(`room-id`) AS `home`, SUM(`room-status`) AS `bro` FROM `status`";
	// 	$query6 = mysqli_query($con, $command6);
	// 	$fetch6 = mysqli_fetch_assoc($query6);
	// 		if ($fetch6['bro'] >= 0) {
	// 	$command14 = "UPDATE `status` SET `room-status` = '1'";
	// 	$query14 = mysqli_query($con,$command14);
	// 		}
	// }
	ob_flush();
?> 
