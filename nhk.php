<?php
  ob_start();
	session_start();
	// if (!isset($_SESSION['sadmin']) || (!isset($_SESSION['scashier']))) {
	// 	header('location: logout.php');
	// }
	if(!((!isset($_SESSION['sadmin'])) || (!isset($_SESSION['scashier'])))){
		header('location: logout.php');
	}
	require('conn.php');
	include('cashiertop.php');
  $command2 = "SELECT `r`.`room-id`, `r`.`beds`, `r`.`bathroom`, `r`.`room-price`, `s`.`room-status` FROM `room-specs` AS `r`, `status` AS `s` WHERE `s`.`room-status` = '1' AND `r`.`room-id` = `s`.`room-id` GROUP BY `r`.`room-id`";
  $query2 = mysqli_query($con, $command2);
          $date =  date('d-m-Y H:i');
          $newDate = date("d-m-Y H:i", strtotime('+0 minute'));
          $newDate2 = date("d-m-Y",strtotime('+1 day'));
	if (isset($_POST['passenger-id'])) {
    $addby = $_SESSION['scashier'];
    $full = '1';
		$pid = $_POST['passenger-id'];
		$rid = $_POST['room-id'];
    $full = $_POST['fullroom'];
		$type = $_POST['type'];
    $pcount = $_POST['passenger-count'];
    $date = $_POST['date'];
    $exdate = $_POST['exdate'];
		$command = "INSERT INTO `house-keeping`(`add-by`, `passenger-id`, `room-id`, `type`, `passenger-count`, `date`, `ex-date`) VALUES ('$addby', '$pid', '$rid', '$type', '$pcount','$date', '$exdate')";
		$query = mysqli_query($con,$command);
      if ($query) {
        $command93 = "UPDATE `status` SET `room-status` = '0' WHERE `room-id` = '$rid'";
        $query93 = mysqli_query($con, $command93);
        header('location: nhk.php?new=Inserted');
      } else{header('location: nhk.php?new=Try Again');}
    }
 ?>
 <!-- ***************************************** FORM FOR INSERTING NEW NHK **************************** -->
 <!-- SUGGISTION AAAAAAAAAAAADDDDDDDDDDDDDDDDDDD AAAAAAAAAAA  VVVVVVVVVVVIIIIIIIIIIIPPPPPPPPPP GGGGGGGGGGUUUEEESTTTT -->
<?php if (isset($_GET['new'])) {
  echo $_GET['new'];
?>
<form class="container" method="post" style="margin-top: 20px;">
 <h5 style="color: orange;">Causion: The page will be refreshed in 5 minutes.</h5>
 <h1 style="color: red; margin-bottom: 30px;">New Guest</h1>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="">Passenger ID</label>
      <input type="number" class="form-control" name="passenger-id" required>
    </div>
    <div class="form-group col-md-4">
      <label for="">Room ID</label>
      <select id="inputState" name="room-id" class="form-control" >
        <?php if (mysqli_num_rows($query2) >= 1) {
                  $fetch2 = mysqli_fetch_assoc($query2);
            do {
              echo '
              <option value="' .
               $fetch2['room-id'] .
                '">' .
                 $fetch2['room-id'] .
                  '   |  ' .
                $fetch2['beds'] .
                 ' Beds - ' .
                 $fetch2['bathroom'].
                 ' Washroom - ' .
                 $fetch2['room-price'].
                 'Afg' .
                '</option>';
              /** HERE I HAVE ECHOED ROOM INFORMATION FOR JUST MAKING IT EASIER TO CASHIER **/
            } while ($fetch2 = mysqli_fetch_assoc($query2));
        } elseif(mysqli_num_rows($query2) <= 0){echo '<option value="fullroom">No Room Is Empty</option>';} 

        ?>
      </select>
    </div>
  <div class="form-group col-md-4">
      <label for="inputState">Type</label>
      <select id="inputState" name="type" class="form-control">
            <option value="1">Singles</option>
            <option value="2">Family</option>
      </select>
    </div>
	<div class="form-group col-md-4">
      <label for="inputState">Guests</label>
      <select id="inputState" name="passenger-count" class="form-control">
            <option value="1">1 Guest</option>
            <option value="2">2 Guests</option>
            <option value="3">3 Guests</option>
            <option value="4">4 Guests</option>
            <option value="5">5 Guests</option>
            <option value="6">6 Guests</option>
            <option value="7">7 Guests</option>
            <option value="8">8 Guests</option>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="">Entery Date</label>
      <input type="datetime" class="form-control" name="date" value="<?php echo $newDate;?>" readonly>
    </div>
    <div class="form-group col-md-4">
      <label for="">Expiry Date</label>
      <input type="datetime" class="form-control" name="exdate" value="<?php echo $newDate2;?>" readonly>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Welcome In</button>
</form>
 <!-- **** SEARCHING FORM **** -->
<?php
  if (isset($_POST['name'])) {
    $d = $_POST['name'];
    $command = "SELECT * FROM `passenger-details`
    WHERE `passenger-id` LIKE '%$d%'
    OR `tazkera` LIKE '%$d%'
    OR `name` LIKE '%$d%'";
    $query = mysqli_query($con, $command);
  }
 ?>
 <form class="container" method="post" style="margin-top: 20px;">
 <h1 style="color: red; margin-bottom: 30px;">Search For Passenger<?php if (isset($_POST['name'])) { echo ' - ' . mysqli_num_rows($query) . 'Result Found' . '<span class="glyphicon glyphicon-chevron-down"></span>'; }?></h1>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="">ID - Name - Tazkera</label>
      <input type="text" class="form-control" name="name" id="" required="">
      <input type="hidden" name="cool">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Search</button>
</form>

<!-- **** SEARCH RESULTS DISPLAIED IN TABLE ***** -->

<div class="container" style="margin-top: 50px">
<table class="table table-borderless table-dark">
<?php } ?>
  <?php if (isset($_POST['cool'])) {?>
        <?php if (mysqli_num_rows($query) > 0) {$y =1; ?>
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Father Name</th>
      <th scope="col">Gender</th>
      <th scope="col">Province</th>
      <th scope="col">District</th>
      <th scope="col">Village</th>
      <th scope="col">Telephone</th>
      <th scope="col">Tazkera</th>
      <th scope="col">Edit</th>
    </tr>
  </thead>
  <tbody>
    <?php  ?>
  <?php while ($row = mysqli_fetch_assoc($query)) {
   ?>
      <tr>
        <td><?php echo $row['passenger-id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['father-name']; ?></td>
        <td><?php echo $row['gender']; ?></td>
        <td><?php echo $row['province']; ?></td>
        <td><?php echo $row['district']; ?></td>
        <td><?php echo $row['village']; ?></td>
        <td><?php echo $row['telephone']; ?></td>
        <td><?php echo $row['tazkera']; ?></td>
      <td><a href="updatepassenger.php?id=<?php echo $row['passenger-id'];?>">Edit</a></td>
<?php $y++; ?>
  <?php }} ?>
      </tr>
  </tbody>
</table>
<p>note: I have enabled Edit in this page for comfort and the customer's old information might have been changed</p>
</div>
<?php }

// ******************************* EDIT HOUSE KEEPINGS OF TONIGHT **************************
if (isset($_GET['edit'])) {
      $date4 = date('d-m-Y', strtotime('+1 day'));
      $command4 = "SELECT `h`.`hk-id`, `h`.`passenger-id` AS `pid`, `h`.`room-id`, `h`.`type`, `h`.`passenger-count`, (SELECT `name` FROM `passenger-details` WHERE `passenger-id` = `pid`) AS `name` FROM `house-keeping` AS `h` WHERE `ex-date` = '$date4'";
      $query4 = mysqli_query($con,$command4);
?>
<div class="container" style="margin-top: 50px">
<h1 style="color: red; margin-bottom: 30px;">Edit House Keeping</h1>
<table class="table table-borderless table-dark">
  <thead>
    <tr style="text-align: center;">
      <th style="text-align: center;">Customer ID</th>
      <th style="text-align: center;">Room ID</th>
      <th style="text-align: center;">Type</th>
      <th style="text-align: center;">Customer Count</th>
      <th style="text-align: center;">Edit</th>
      <th style="text-align: center;">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($fetch4 = mysqli_fetch_assoc($query4)) { ?>
    <tr style="text-align: center;">
      <td style="text-align: center;"><?php echo $fetch4['name']; ?></td>
      <td style="text-align: center;"><?php echo $fetch4['room-id']; ?></td>
      <td style="text-align: center;"><?php echo $fetch4['type']; ?></td>
      <td style="text-align: center;"><?php echo $fetch4['passenger-count']; ?></td>
      <td><a href="nhk.php?eid=<?php echo $fetch4['hk-id'] ?>">Edit</a></td>
      <td><a href="nhk.php?did=<?php echo $fetch4['hk-id'] ?>">Delete</a></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
<center><h4 style="color: gray; margin-bottom: 10px;">You can only edit tonight's guests because of security!</h4></center>
</div>
<?php }
// *continued...
// *
// *
// **************************************** EDIT GUEST *****************************************
// *
// *
// *

if (isset($_GET['eid'])) {
  $id2 = $_GET['eid'];
  $command5 = "SELECT `passenger-id`, `room-id`, `type`, `passenger-count` FROM `house-keeping`
               WHERE `hk-id` = $id2";
  $query5 = mysqli_query($con,$command5);
  $fetch5 = mysqli_fetch_assoc($query5);
  $oww = $fetch5['room-id'];

  $command8 = "UPDATE `status` SET `room-status`='1' WHERE `room-id` = '$oww'";
  $query8 = mysqli_query($con,$command9);

  if (isset($_POST['pid'])) {
  $pid = $_POST['pid'];
  $rid = $_POST['rid'];
  $type = $_POST['type'];
  $guest = $_POST['guest'];
  $addby = $_SESSION['scashier'];
  $command = "UPDATE `house-keeping` SET `add-by`='$addby',`passenger-id`='$pid',`room-id`='$rid',`type`='$type',`passenger-count`='$guest' WHERE `hk-id` = '$eid'";
  $query = mysqli_query($con,$command);
    if ($query) {
      $command9 = "UPDATE `status` SET `room-status`='0' WHERE `room-id` = '$rid'";
      $query9 = mysqli_query($con,$command9);
        if ($query9) {
          header('location: nhk.php?all=House Keeping Edited');
        }
    }
  }
?>
<div class="container" style="margin-top: 50px">
<form class="container" method="post" action="nhk.php" style="margin-top: 20px;">
  <h1 style="color: red; margin-bottom: 30px;">Edit Guest</h1>
  <div class="form-row">
    <input type="hidden" value="<?php echo $id2; ?>" name="kali">
    <div class="form-group col-md-4">
      <label for="">Passenger ID</label>
      <input type="text" class="form-control" name="pid" value="<?php echo $fetch5['passenger-id']; ?>" id="">
    </div>
    <div class="form-group col-md-4">
      <label for="">Room ID</label>
      <input type="text" class="form-control" value="<?php echo $fetch5['room-id']; ?>" name="rid" id="">
    </div>
  <div class="form-group col-md-4">
      <label for="inputState">Type</label>
      <select id="inputState" name="type" class="form-control">
        <option selected value="<?php echo $fetch5['type']; ?>"><?php echo $fetch5['type']; ?></option>
        <option value="Singles">Singles</option>
        <option value="Family">Family</option>
      </select>
    </div>
  <div class="form-group col-md-4">
      <label for="inputState">Guests</label>
      <select id="inputState" name="guest" class="form-control">
        <option selected value="<?php echo $fetch5['passenger-count']; ?>"><?php echo $fetch5['passenger-count'] . ' Guests'; ?></option>
            <option value="1">1 Guest</option>
            <option value="2">2 Guests</option>
            <option value="3">3 Guests</option>
            <option value="4">4 Guests</option>
            <option value="5">5 Guests</option>
            <option value="6">6 Guests</option>
            <option value="7">7 Guests</option>
            <option value="8">8 Guests</option>
      </select>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Update Guest</button>
</form>
<center>
</div>
<?php 
  $command = "SELECT `r`.`room-id`,`r`.`room-floor`,`r`.`beds`,`r`.`bathroom`,`r`.`room-price` FROM `room-specs` AS `r`, `status` AS `s` WHERE `s`.`room-status` = '1' AND `r`.`room-id` = `s`.`room-id` GROUP BY `r`.`room-id`";
  $query = mysqli_query($con, $command);
?>
<div class="container" style="margin-top: 50px">
  <h3 style="margin-bottom: 10px;">Available Rooms</h3>
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
<?php }
// *continued...
// *
// *
// ********************** UPDATE HOUSE KEEPING OF TONIGHT ************************
// *
// *
// *
if (isset($_POST['kali'])) {
  $id6 = $_POST['kali'];
  $pid = $_POST['pid'];
  $rid = $_POST['rid'];
  $type = $_POST['type'];
  $guest = $_POST['guest'];
  $command11 = "UPDATE `status` SET `room-status`='0' WHERE `room-id` = '$rid'";
  $query11 = mysqli_query($con,$command11);
  $command12 = "UPDATE `house-keeping` SET `passenger-id`='$pid',`room-id`='$rid',`type`='$type',
               `passenger-count`='$guest' WHERE `hk-id`='$id6'";
  $query12 = mysqli_query($con, $command12);
  if ($query12) {
    header('location: nhk.php?edit');
  }
}
// *continued...
// *
// *
// ********************** DELETE HOUSE KEEPING OF TONIGHT ************************
// *
// *
// *
if (isset($_GET['did'])) {
  $did = $_GET['did'];
  $command = "DELETE FROM `house-keeping` WHERE `hk-id` = '$did'";
  $query = mysqli_query($con,$command);
  if ($query) {
      header('location: cashier.php?del=Successfully Deleted');
  }
}
  ob_flush(); 

?>