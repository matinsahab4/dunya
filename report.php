<?php 
    ob_start();
    session_start();
  if (!isset($_SESSION['scashier'])) {
    header('location: logout.php');
  }
  date_default_timezone_set('Asia/Kabul');  
 function fetch_data()  
 {  
      $output = '';  
    $date = date("d-m-Y",strtotime('+1 day'));
      $conn = mysqli_connect("localhost", "root", "", "dunya1");  
      $sql = "SELECT `h`.`hk-id`, `p`.`name`, `p`.`father-name`, `p`.`province`, `p`.`district`,
           `p`.`telephone`, `h`.`passenger-count`, `p`.`tazkera`, `h`.`room-id` 
           FROM `passenger-details` AS `p`, `house-keeping` AS `h`, `room-specs` 
           AS `r` WHERE `h`.`ex-date` ='$date' AND `p`.`passenger-id` = `h`.`passenger-id` 
           GROUP BY `h`.`hk-id`";  
      $result = mysqli_query($conn, $sql);
      $nn=1;  
      while($row = mysqli_fetch_array($result))  
      {
              $output .= '<tr>
                          <td style="text-align:center;">'.$nn.'</td>  
                          <td style="text-align:center;">'.$row["name"].'</td>  
                          <td style="text-align:center;">'.$row["father-name"].'</td>  
                          <td style="text-align:center;">'.$row["district"].'</td>  
                          <td style="text-align:center;">'.$row["telephone"].'</td>  
                          <td style="text-align:center;">'.$row["passenger-count"].'</td>  
                          <td style="text-align:center;">'.$row["tazkera"].'</td>  
                          <td style="text-align:center;">'.$row["room-id"].'</td>  
                     </tr>  
                          '; $nn++;
      }
      return $output;  
 }  
 if(isset($_POST["generate_pdf"]))  
 {  

    $date = date("d-m-Y",strtotime('+0 day'));
    $date2 = date("d-m-Y",strtotime('+0 day'));

      require_once('tcpdf/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Reporting hotel condition with passengers staying at $date");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('freeserif', '', 11);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= '  
      <h4 align="center">Reporting hotel condition with passengers staying at ' . $date2 . '</h4><br /> 
      <table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
                <th style="text-align:center;" width="5%">No</th>  
                <th style="text-align:center;" width="15%">Name</th>  
                <th style="text-align:center;" width="15%">F/Name</th>  
                <th style="text-align:center;" width="15%">Village</th>  
                <th style="text-align:center;" width="15%">Telephone</th>  
                <th style="text-align:center;" width="15%">Passengers</th>  
                <th style="text-align:center;" width="12%">Tazkera</th>  
                <th style="text-align:center;" width="10%">Room ID</th>  
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('file.pdf', 'I');  
 } 
 ?>
 <!DOCTYPE html>  
 <html>  
  <?php     $date = date("d-m-Y",strtotime('+0 day'));
 ?>
      <head>
           <title>Reporting hotel condition with passengers staying at <?php echo $date; ?> </title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />            
      </head>  
      <body>  
           <br />
           <div class="container">  
                <h4 align="center">Reporting hotel condition with passengers staying at <?php echo $date; ?> </h4><br />  
                <div class="table-responsive">  
                  <div class="col-md-12" align="right">
                     </div>
                     <br/>
                     <br/>
                     <table class="table table-bordered">  
                          <tr>  
                               <th style="text-align: center;" width="5%">No</th>  
                               <th style="text-align: center;" width="5%">Name</th>  
                               <th style="text-align: center;" width="5%">F/Name</th>  
                               <th style="text-align: center;" width="5%">Village</th>  
                               <th style="text-align: center;" width="5%">Telephone</th>  
                               <th style="text-align: center;" width="2%">Passengers</th>  
                               <th style="text-align: center;" width="10%">Tazkera</th>  
                               <th style="text-align: center;" width="5%">Room ID</th>  
                          </tr>  
                     <?php  
                     echo fetch_data();  
                     ?>  
                     </table> 
                     <form method="post">  
                          <input type="submit" name="generate_pdf" class="btn btn-success" value="Generate PDF" />  
                     </form>   
                </div>  
           </div>  
      </body>  
</html>