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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Item</h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-body">
              <?php
                $id = $_GET['id'];

                $select = $pdo->prepare("SELECT * FROM tbl_product WHERE product_id=$id");
                $select->execute();
                while($row = $select->fetch(PDO::FETCH_OBJ)){ ?>
                <div class="col-md-6">
                  <ul class="list-group"><center><p class="list-group-item list-group-item-success">Item Detail</p></center>
                    <li class="list-group-item"><b>Item Code</b>        :<span class="label badge pull-right"><?php echo $row->product_code; ?></span></li>
                    <li class="list-group-item"><b>Item Name</b>    	:<span class="label label-info pull-right"><?php echo $row->product_name; ?></span></li>
                    <li class="list-group-item"><b>Item Category</b>	:<span class="label label-primary pull-right"><?php echo $row->product_category; ?></span></li>
                    <li class="list-group-item"><b>Stock</b>          	:<span class="label label-default pull-right"><?php echo $row->stock; ?></span></li>
                    <li class="list-group-item"><b>Minimal Stock</b>  	:<span class="label label-default pull-right"><?php echo $row->min_stock; ?></span></li>
                    <li class="list-group-item"><b>Unit</b>            	:<span class="label label-default pull-right"><?php echo $row->product_unit; ?></span></li>
                    <li class="list-group-item"><b>Description</b>     	:<span class="text pull-right"><?php echo $row->description ?></span></li>
                  </ul>
                </div>
                <div class="col-md-6" align="center" >
                  <ul class="list-group" style="border-radius:5px;border:1px solid #d2d6de">
                   <p class="list-group-item list-group-item-success">Item Image</p></center>
				   <?php
						if(file_exists("img/items/".$row->img."")){	
							echo"<img src='img/items/".$row->img."' alt='Item Image' class='img-responsive'>";
						}else{
							echo"<img src='img/select_image.jpg' alt='Item Image' class='img-responsive'>";
						}
					?>
                  </ul>
                </div>
              <?php
                }
              ?>
            </div>
            <div class="box-footer">
                <a href="items.php" class="btn btn-warning">Back</a>
            </div>

        </div>

    </section>
  </div>
<?php include_once'inc/footer_all.php'; ?>