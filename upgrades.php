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
        Site Upgrades
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Upgrade List</h3>
                <a href="create_rollout.php" class="btn btn-success btn-sm pull-right">Add Upgrade</a>
            </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myOrder">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Encoder</th>
                                <th>Date</th>
                                <th>Installer</th>
                                <th>Rollout Site</th>
                                <th>Site Type</th>
								<th>Contact Person</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
							$purpose="Site Upgrade";
                            $select = $pdo->prepare("SELECT * FROM tbl_invoice inv WHERE inv.purpose='".$purpose."' ORDER BY invoice_id DESC");
                            $select->execute();
							
							include_once'getvalue.php';
                            
							while($row=$select->fetch(PDO::FETCH_OBJ)){
							
							require('getvalue.php');
							
							echo"
                                <tr>
                                <td>".$no++."</td>
                                <td class='text-uppercase'>$operator</td>
                                <td>$date</td>
                                <td>$leader</td>
                                <td>$bar, $mun</td>
                                <td>$sitetype</td>
								<td>$contper</td>
                                <td>";
                         
								if($_SESSION['role']=="Admin"){ 
									echo"<a href='rollout.php?id=".$row->invoice_id."' onclick=\"return confirm('Delete Rollout?')\" class='btn btn-danger btn-sm' title='Delete'><i class='fa fa-trash'></i></a>&nbsp;";
								} 
									echo"<a href='misc/receipt.php?id=$id' target='_blank' class='btn btn-info btn-sm' title='Print Receipt'><i class='fa fa-print'></i></a>&nbsp;";
									echo"<a href='inscert.php?id=$id' class='btn btn-success btn-sm' title='Print Certificate'><i class='fa fa-print'></i></a>";
								echo"
                                </td>
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