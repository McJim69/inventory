<?php
  include_once'db/connect_db.php';
  session_start();
  if($_SESSION['role']!=="Admin"){
    header('location:index.php');
  }


if(isset($_POST['btn_edit'])){
      $unit_name = $_POST['unit'];
      $update = $pdo->prepare("UPDATE tbl_unit SET nm_unit='$unit_name' WHERE kd_unit='".$_GET['id']."' ");
      $update->bindParam(':nm_unit', $unit_name);
      if($update->rowCount() > 0){
        echo'<script type="text/javascript">
        jQuery(function validation(){
        swal("Warning", "There has been Unit", "warning", {
        button: "Continue",
            });
        });
        </script>';
      }elseif($update->execute()){
        echo'<script type="text/javascript">
        jQuery(function validation(){
        swal("Success", "Unit Name Has Been Updated", "success", {
        button: "Continue",
            });
        });
        </script>';
      }
}


if($id=$_GET['id']){
    $select = $pdo->prepare("SELECT * FROM tbl_unit WHERE kd_unit = '".$_GET['id']."' ");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    $sat_name = $row->nm_unit;
}else{
    header('location:unit.php');
}


  include_once'inc/header_all.php';

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product Category
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
       <!-- Category Form-->
      <div class="col-md-4">
            <div class="box box-warning">
                <!-- /.box-header -->
                <!-- form start -->
                <form action="" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="category">Unit Name</label>
                      <input type="text" class="form-control" name="unit" placeholder="Input Unit"
                      value="<?php echo $sat_name; ?>" required>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                      <button type="submit" class="btn btn-primary" name="btn_edit">Update</button>
                      <a href="unit.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
            </div>
      </div>

      <div class="col-md-8">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Unit List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Unit Name</th>
                  </tr>
              </thead>
              <tbody>
              <?php
              $no = 1;
              $select = $pdo->prepare('SELECT * FROM tbl_unit');
              $select->execute();
              while($row=$select->fetch(PDO::FETCH_OBJ)){ ?>
                <tr>
                    <td><?php echo $no++    ;?></td>
                    <td><?php echo $row->nm_unit; ?></td>
                </tr>
              <?php
              }
              ?>

              </tbody>
          </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
    include_once'inc/footer_all.php';
?>
