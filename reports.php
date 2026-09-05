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
?>
  <div class="content-wrapper">
    <section class="content container-fluid">
        <div class="box box-success">
          <form action="" method="POST" autocomplete="off">
            <div class="box-header with-border">
                <h3 class="box-title">From Date : <?php echo $_POST['date_1']?>
                </h3>
                <h3 class="box-title">To Date : <?php echo $_POST['date_2'] ?>
                </h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker_1" name="date_1" data-date-format="yyyy-mm-dd">
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker_2" name="date_2" data-date-format="yyyy-mm-dd">
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="date_filter" value="View" class="btn btn-success btn-sm">
                </div>
                <br>
              </div>
                  <?php
                    $select = $pdo->prepare("SELECT count(invoice_id) as invoice FROM tbl_invoice WHERE order_date BETWEEN :fromdate AND :todate");
                    $select->bindParam(':fromdate', $_POST['date_1']);
                    $select->bindParam(':todate', $_POST['date_2']);
                    $select->execute();
                    $row = $select->fetch(PDO::FETCH_OBJ);
                    $invoice = $row->invoice;
                  ?>

				  <?php
					$select = $pdo->prepare("SELECT sum(qty) as quantity FROM tbl_invoice_detail WHERE order_date BETWEEN :fromdate AND :todate");
					$select->bindParam(':fromdate', $_POST['date_1']);
					$select->bindParam(':todate', $_POST['date_2']);
					$select->execute();
                    $row = $select->fetch(PDO::FETCH_OBJ);
                    $items = $row->quantity;
				  ?>

              <div class="row">
                <div class="col-md-offset-2 col-md-4 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-truck"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Total Rollout</span>
                      <span class="info-box-number"><?php echo $invoice; ?></span>
                    </div>
                  </div>
                </div>
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-offset-1 col-md-5 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-desktop"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Item Released</span>
                      <span class="info-box-number"><?php echo number_format($items,0); ?></span>
                    </div>
                  </div>
                </div>
              </div>

              <div style="overflow-x:auto;">
                  <table class="table table-striped" id="mySalesReport">
                      <thead>
                          <tr>
                            <th>Encoder</th>
                            <th>Date</th>
                            <th>Installer</th>
                            <th>Team Leader</th>
							<th>Rollout Site</th>
                            <th>Site Type</th>
							<th>Contact Person</th>
							<th>CP Number</th>
                          </tr>
                      </thead>
                      <tbody>
					      
                            <?php
								$select = $pdo->prepare("SELECT * FROM tbl_invoice ti WHERE ti.order_date BETWEEN :fromdate AND :todate");                            
								$select->bindParam(':fromdate', $_POST['date_1']);
								$select->bindParam(':todate', $_POST['date_2']);
								$select->execute();
															
								while($row=$select->fetch(PDO::FETCH_OBJ)){					

								require('getvalue.php');								

								echo"<tr>
									<td class='text-uppercase'>$operator</td>
									<td>$date</td>
									<td>$team</td>
									<td>$leader</td>
									<td>$bar, $mun, ZDS</td>
									<td>$sitetype</td>
									<td>$contper</td>
									<td>$contnum</td>
									</tr>";
								}
                             ?>
						   </tr>
                      </tbody>
                  </table>
              </div>

              <div class="chart">
                  <canvas id="myBestSellItem" style="height:250px;">
                  </canvas>
              </div>

          </div>

          </form>
        </div>
    </section>
  </div>
  <script>
    $('#datepicker_1').datepicker({
      autoclose: true
    });
    $('#datepicker_2').datepicker({
      autoclose: true
    });

    $(document).ready( function () {
      $('#mySalesReport').DataTable();
    } );
  </script>

<?php include_once'inc/footer_all.php'; ?>