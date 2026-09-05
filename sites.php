<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['username']==""){
        header('location:index.php');
    }else{
        if($_SESSION['role']=="Admin"){
          include_once'inc/header_all.php';
        }else{
            include_once'inc/header_all_operator.php';
        }
    }

    $id = $_GET['id'];
	
    $delete_query = "DELETE tbl_invoice , tbl_invoice_detail FROM tbl_invoice INNER JOIN tbl_invoice_detail ON tbl_invoice.invoice_id = tbl_invoice_detail.invoice_id WHERE tbl_invoice.invoice_id=$id";
    $delete = $pdo->prepare($delete_query);
    if($delete->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "Rollout was Removed", "info", {
            button: "Continue",
                });
            });
            </script>';
    }
?>

<html>
<head>
<meta http-equiv="refresh" content="60">
</head>
</html>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sites
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Site List</h3>
            </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myOrder">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Site Type</th>
                                <th>Location</th>
                                <th>Address</th>
                                <th>Installer</th>
                                <th>Height</th>
								<th>Powering</th>
                                <th>Linked AP</th>
								<th>Contact Person</th>
								<th>Contact Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
							$purpose="New Site Installation";
                            $select = $pdo->prepare("SELECT * FROM tbl_invoice inv WHERE inv.purpose='".$purpose."' ORDER BY invoice_id DESC");
                            $select->execute();
							
							include_once'getvalue.php';
                            
							while($row=$select->fetch(PDO::FETCH_OBJ)){
							
							require('getvalue.php');
							
							echo"
                                <tr>
                                <td>".$no++."</td>
                                <td>$sitetype</td>
								<td>$coor</td>
                                <td>$bar, $mun</td>
                                <td>$team</td>
                                <td>$height</td>
                                <td>$power</td>
								<td>$link</td>
								<td>$contper</td>
								<td>$contnum</td>
                                </tr>
								";
								} 
							?> 
							
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </section>
  </div>

<script>
  $(document).ready( function () {
      $('#myOrder').DataTable();
  } );
</script>

<?php include_once'inc/footer_all.php'; ?>