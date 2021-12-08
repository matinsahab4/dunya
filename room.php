<?php 
		session_start();
    ob_start();
	if (!isset($_SESSION['sadmin'])) {
I have made some changes
    $rbath = $_POST['bathroom'];
		$rprice = $_POST['room-price'];
		$command = "INSERT INTO `room-specs` (`room-id`, `room-floor`, `beds`, `bathroom`, `room-price`) VALUES ('$rno', '$rfloor', '$rbed', '$rbath', '$rprice')";
		$query = mysqli_query($con,$command);
    $command2 = "INSERT INTO `status` (`room-id`, `room-status`) VALUES ('$rno', '1')";
    $query2 = mysqli_query($con,$command2);
      if ($query2) {
        header('location: admin.php?add=Room Added');
      } else {header('location: admin.php?notadd=Sth went wrong, Try again.');}
	}
	elseif (isset($_POST['errom-No'])) {
		$rno = $_POST['eroom-id'];
		$rfloor = $_POST['eroom-floor'];
		$rcapacity = $_POST['ebeds'];
    $rbed = $_POST['beds'];
    $rbath = $_POST['bathroom'];
		$rprice = $_POST['eroom-price'];
		$command = "UPDATE `room-specs` SET `room-id` = '$tt'  `room-floor`= '$rfloor',`beds`= '$rbed', `bathroom` = '$rbath', '$rprice',`room-price`= '$rprice' WHERE `room-id` = $rno";
		$query = mysqli_query($con, $command);
		if ($query) {
			echo "<p style='color:green;'>Successfully Updated</p>";			
		}
	}
// *****************   ADD ROOM - SECTION - FORM    **********************************
 if (isset($_GET['add'])) {
?>
 <form class="container" method="post" style="margin-top: 20px;">
 	<h1 style="color: red; margin-bottom: 30px;">Add Room</h1>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="">Room Number</label>
      <input type="text" class="form-control" name="room-id" id="">
    </div>
    <div class="form-group col-md-4">
      <label for="">Room Floor</label>
      <input type="text" class="form-control" name="room-floor" id="">
    </div>
    <div class="form-group col-md-4">
      <label for="">Beds</label>
      <select id="inputState" name="beds" class="form-control">
        <option selected>Choose...</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">Bathroom</label>
      <select id="inputState" name="bathroom" class="form-control">
        <option selected>Choose...</option>
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label >Room Price</label>
      <input type="text" class="form-control" name="room-price" >
    </div>
</div>
  <button type="submit" class="btn btn-primary">Register</button>
</form>
<?php }?>

<!-- ******************* FIND ROOM - SECTION   ***************************** -->

<?php
	if (isset($_GET['edit'])) {
                                                  
		?>	
 <!-- **** SEARCHING FORM **** -->
<form class="container" method="post" style="margin-top: 20px;">
 <h1 style="color: red; margin-bottom: 30px;">Find - Update - Delete Room</h1>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="">ID - Room Number - Room Price - Room Capacity</label>
      <input type="Number" class="form-control" name="name" id="" required="">
      <input type="hidden" name="cool">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Search</button>
</form>

<!-- **** SEARCH RESULTS DISPLAIED IN TABLE ***** -->

<div class="container" style="margin-top: 50px">
<table class="table table-borderless table-dark">

	<?php

	if (isset($_POST['cool']))	 {
		$d = $_POST['name'];
		$enst = "SELECT * FROM `room-specs`
		WHERE `room-id` LIKE '%$d%'
		OR `beds` LIKE '%$d%'
		OR `room-price` LIKE '%$d%' ORDER BY `room-id` DESC";
		$qw = mysqli_query($con, $enst);
		?>
  <thead>
    <tr>
      <th style="text-align: center;" scope="col">Room ID</th>
      <th style="text-align: center;" scope="col">Room Floor</th>
      <th style="text-align: center;" scope="col">Room Capacity</th>
      <th style="text-align: center;" scope="col">Room Price</th>
      <th style="text-align: center;" scope="col">Edit</th>
      <th style="text-align: center;" scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
		<?php if (mysqli_num_rows($qw) > 0) {$y =1;
			while ($row = mysqli_fetch_assoc($qw)) {
	 ?>
      <tr>
        <td style="text-align: center;"><?php echo $row['room-id']; ?></td>
        <td style="text-align: center;"><?php echo $row['room-floor']; ?></td>
        <td style="text-align: center;"><?php echo $row['beds']; ?></td>
        <td style="text-align: center;"><?php echo $row['room-price']; ?></td>
  		<td style="text-align: center;"><a href="room.php?id=<?php echo $row['room-id'];?>">Edit</a></td>
  		<td style="text-align: center;"><a href="room.php?did=<?php echo $row['room-id'];?>">Delete</a></td>
  	</tr>
 <?php }}}?>
<center><h4 style="color: gray; margin-bottom: 10px;">If guests are registered in a room (ex:34) You cannot delete room 34.</h4></center>
<?php } ?>

 <!-- ******************	EDIT ROOM - SECTION ******************************************** -->

<?php if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$command = "SELECT * FROM `room-specs` WHERE `room-id` = '$id'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	if (isset($_POST['eroom-id'])) {
		$rno = $_POST['eroom-id'];
		$rfloor = $_POST['eroom-floor'];
		$rpc = $_POST['ebeds'];
    $bath = $_POST['bathroom'];
		$rprice = $_POST['eroom-price'];
    $stdel = "DELETE FROM `status` WHERE `room-id` = '$id'";
    $stqry = mysqli_query($con,$stdel);
    if ($stqry) {
		$update = "UPDATE `room-specs` SET `room-id`='$rno',`room-floor`='$rfloor',`beds`='$rpc', 
    `bathroom`='$bath', `room-price`='$rprice' WHERE `room-id` = '$id'";
		$qupdate = mysqli_query($con, $update);
    if ($qupdate) {
      $stins = "INSERT INTO `status`(`room-id`, `room-status`) VALUES ('$rno','1')";
      $stinq = mysqli_query($con,$stins);
        if ($stinq) {
          header('location: admin.php?add=Room Edited');
        }
    }
    }
		if ($qupdate) {
			// **************************** THERE WAS A PROBLEM WITH HEADERS ALREADY SENT SO I WROTE THIS CODE ***********************
			if (headers_sent()) {
				die('
<div class="d-flex justify-content-center" style="margin-top: 100px;">
  <div class="card inline" style="width: 18rem;">
  <img class="card-img-top" src="images/room.jpg" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">Add Passenger</h5>
    <p class="card-text" ">Add a new passenger with all its data for it to be inserted as guest.</p>
    <a href="passenger.php" class="btn btn-primary d-flex justify-content-center" style="margin-top: 5px;">Add Passenger</a>
  </div>
</div>
  <div class="card inline" style="width: 18rem;">
  <img class="card-img-top" src="images/menu.jpg" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">House Keepings</h5>
    <p class="card-text">See all the guests we are wellcomming for the night.</p>
    <a href="nhk.php?all" class="btn btn-primary d-flex justify-content-center" style="margin-top: 5px;">All House Keepings</a>
  <center><h5 class="text-success" style="margin-top: 15px;">Successfully Edited</h5></center>
  </div>
</div>
  <div class="card inline" style="width: 18rem;">
  <img class="card-img-top" src="images/inventory.jpg" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">Room Status</h5>
    <p class="card-text">Have a look about all the room status wheater they are free or not.</p>
    <a href="roomstatus.php" class="btn btn-primary d-flex justify-content-center" style="margin-top: 5px;">Room Status</a>
  </div>
</div>
</div>
');
			}else{
				exit(header('location.php'));
			}
			header('location: index.php');
		}
	}
?>
 <form class="container" method="post" style="margin-top: 20px;">
 <h1 style="color: red; margin-bottom: 30px;">Update Room</h1>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="">Room Number</label>
      <input type="text" class="form-control" name="eroom-id" value="<?php echo $fetch['room-id']; ?>" readonly>
    </div>
    <div class="form-group col-md-4">
      <label for="">Room Floor</label>
      <input type="text" class="form-control" value="<?php echo $fetch['room-floor']; ?>" name="eroom-floor" id="">
    </div>
    <div class="form-group col-md-4">
      <label >Beds</label>
      <input type="text" class="form-control" value="<?php echo $fetch['beds']; ?>" name="ebeds">
    </div>
    <div class="form-group col-md-4">
      <label >Bathroom</label>
      <input type="text" class="form-control" value="<?php echo $fetch['bathroom']; ?>" name="bathroom">
    </div>
    <div class="form-group col-md-4">
      <label for="">Room Price</label>
      <input type="text" class="form-control" value="<?php echo $fetch['room-price']; ?>" name="eroom-price">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Update Room</button>
</form>
<center>
	<?php } ?>
<!-- ******************************* DISPLAY ALL ROOMS - SECTION ************************** -->
<?php  
if (isset($_GET['did'])) {
  $d = $_GET['did'];
  $command1 = "DELETE FROM `status` WHERE `room-id` = '$d'";
  $query1 = mysqli_query($con,$command1);
  if ($query1) {
  $command2 = "DELETE FROM `room-specs` WHERE `room-id` = '$d'";
  $query2 = mysqli_query($con,$command2);
    if ($query2) {
      header('location: room.php?all=Successfully Deleted');
    }
  }
}
?>
<?php 
	if (isset($_GET['all'])) {
	require('conn.php');
	if (isset($_GET['hid'])) {
	$c = $_GET['n'];
	$command = "SELECT * FROM `room-specs` LIMIT '$c'";
	$query = mysqli_query($con, $command);
	}
	if (!isset($_GET['hid'])) {
		# code...
	$command = "SELECT * FROM `room-specs`";
	$query = mysqli_query($con, $command);
	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>All Passengers</title>
 </head>
 <body>
<h3><?php echo $_GET['all']; ?></h3>
<div class="container" style="margin-top: 50px">
<table class="table table-borderless table-dark">
	<?php if (mysqli_num_rows($query) > 0) { ?>
  <thead>
    <tr>
      <th style="text-align: center;" scope="col">Room ID</th>
      <th style="text-align: center;" scope="col">Room Floor</th>
      <th style="text-align: center;" scope="col">Room Capacity</th>
      <th style="text-align: center;" scope="col">Washrooms</th>
      <th style="text-align: center;" scope="col">Room Price</th>
    </tr>
  </thead>
  <tbody>
	<?php while ($row = mysqli_fetch_assoc($query)) {
	 ?>
      <tr>
        <td style="text-align: center;"><?php echo $row['room-id']; ?></td>
        <td style="text-align: center;"><?php echo $row['room-floor']; ?></td>
        <td style="text-align: center;"><?php echo $row['beds']; ?></td>
        <td style="text-align: center;"><?php echo $row['bathroom']; ?></td>
        <td style="text-align: center;"><?php echo $row['room-price']; ?></td>
      </tr>
  <?php }} ?>
  </tbody>
</table>
</div>

 </body>
 </html>

	<?php } 
ob_flush();
?>
