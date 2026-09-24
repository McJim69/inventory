<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']=="Admin"){
      include_once'inc/header_all.php';
    }else{
        include_once'inc/header_all_operator.php';
    }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
      <div class="row">
        <!-- get alert stock -->
        <?php
        $select = $pdo->prepare("SELECT count(product_code) as total FROM tbl_product WHERE stock <= min_stock");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $total1 = $row ? $row->total : 0;
        ?>
        <!-- get alert notification -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="background:#bbb">
            <span class="info-box-icon bg-aqua"><i class="fa fa-archive"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4><b style="color:#222d32">Out of Stock</b></h4></span>
              <?php if($total1){ ?>
              <div style="font-weight:bold;text-align:center;background:#fff;padding:3px;font-size:20px"><?php echo $total1;?></div>
              <?php }else{?>
              <div style="font-weight:bold;text-align:center;background:#fff;padding:3px;font-size:20px">None</div>
              <?php }?>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


        <!-- get total products-->
        <?php
        $select = $pdo->prepare("SELECT count(product_code) as t FROM tbl_product");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $total = $row ? $row->t : 0;
        ?>

        <!-- get total products notification -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="background:#bbb">
            <span class="info-box-icon bg-aqua"><i class="fa fa-calculator"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4><b style="color:#222d32">Total Items</b></h4></span>
              <div style="font-weight:bold;text-align:center;background:#fff;padding:3px;font-size:20px"><?php echo $total ?></div>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- get today transactions -->
        <?php
        $select = $pdo->prepare("SELECT count(invoice_id) as i FROM tbl_invoice WHERE order_date = CURDATE()");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $invoice = $row ? $row->i : 0;
        ?>
         <!-- get today transactions notification -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="background:#bbb">
            <span class="info-box-icon bg-aqua"><i class="fa fa-truck"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4><b style="color:#222d32">Rollout Today</b></h4></span>
              <div style="font-weight:bold;text-align:center;background:#fff;padding:3px;font-size:20px"><?php echo $invoice ?></div>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


        <!-- get today income -->
        <?php
        $select = $pdo->prepare("SELECT sum(qty) as total FROM tbl_invoice_detail WHERE order_date = CURDATE()");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $total = $row ? $row->total : 0;
        ?>
         <!-- get today income -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="background:#bbb">
            <span class="info-box-icon bg-aqua"><i class="fa fa-cubes"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><h4><b style="color:#222d32">Released Today</b></h4></span>
              <div style="font-weight:bold;text-align:center;background:#fff;padding:3px;font-size:20px"><?php echo number_format($total,0); ?></div>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

      </div>

      <div class="col-md-offset-1 col-md-10">
        <div class="box box-success">
          <div class="box-header with-border">
              <h3 class="box-title">Most Released Items</h3>
          </div>
          <div class="box-body">
            <div class="col-md-offset-1 col-md-10">
              <div style="overflow-x:auto;">
                  <table class="table table-striped" id="myBestProduct">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Code</th>
                              <th>Item</th>
                              <th>Quantity</th>
                              <th>Units</th>
                          </tr>

                      </thead>
                      <tbody>
                          <?php
						  //SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
                          $no = 1;
                          $select = $pdo->prepare("SELECT product_code,product_name,sum(qty) as q,product_unit FROM tbl_invoice_detail GROUP BY product_id ORDER BY sum(qty) DESC LIMIT 20");
                          $select->execute();
                          while($row=$select->fetch(PDO::FETCH_OBJ)){
                          ?>
                              <tr>
                              <td><?php echo $no++ ;?></td>
                              <td><?php echo $row->product_code; ?></td>
                              <td><?php echo $row->product_name; ?></td>
                              <td><?php echo $row->q; ?>
                              <td><?php echo $row->product_unit; ?></td>
                              </tr>

                        <?php
                          }
                        ?>
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
  $(document).ready( function () {
      $('#myBestProduct').DataTable();
  } );
  </script>

<?php include_once'inc/footer_all.php'; ?>