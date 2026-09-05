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

    if(isset($_POST['add_product'])){
        $code = $_POST['product_code'];
        $product = $_POST['product_name'];
        $category = $_POST['category'];
        $stock = $_POST['stock'];
        $min_stock = $_POST['min_stock'];
        $unit = $_POST['unit'];
        $desc = $_POST['description'];


        if(isset($_POST['product_code'])){
            $select = $pdo->prepare("SELECT product_code FROM tbl_product WHERE product_code='$code'");
            $select->execute();

            if($select->rowCount() > 0 ){
                echo'<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Product Code Registered", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';
            }elseif (strlen($code)>7 || strlen($code)<7) {
                    echo'<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Code Must be 7 Character Corresponding Rules", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';
            }else{
            $img = $_FILES['product_img']['name'];
            $img_tmp = $_FILES['product_img']['tmp_name'];
            $img_size = $_FILES['product_img']['size'];
            $img_ext = explode('.', $img);
            $img_ext = strtolower(end($img_ext));

        //	$img_new = uniqid().'.'. $img_ext;

            $img_new = $code.'.'. $img_ext;

            $store = "img/items/".$img_new;

            if($img_ext == 'jpg' || $img_ext == 'jpeg' || $img_ext == 'png' || $img_ext == 'gif'){
                if($img_size>= 1000000){
                    $error ='<script type="text/javascript">
                            jQuery(function validation(){
                            swal("Error", "File should be 1MB", "error", {
                            button: "Continue",
                                });
                            });
                            </script>';
                    echo $error;
                }else{
                    if(move_uploaded_file($img_tmp,$store)){
                        $product_img = $img_new;
                        if(!isset($error)){

                            $insert = $pdo->prepare("INSERT INTO tbl_product(product_code,product_name,product_category,stock,min_stock,product_unit,description,img)
                            values(:product_code,:product_name,:product_category,:stock,:min_stock,:unit,:desc,:img)");

                            $insert->bindParam(':product_code', $code);
                            $insert->bindParam(':product_name', $product);
                            $insert->bindParam(':product_category', $category);
                            $insert->bindParam(':stock', $stock);
                            $insert->bindParam(':min_stock', $min_stock);
                            $insert->bindParam(':unit', $unit);
                            $insert->bindParam(':desc', $desc);
                            $insert->bindParam(':img', $product_img);

                            if($insert->execute()){
                                echo'<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Success", "Item Saved Successfully!", "success", {
                                        button: "Continue",
                                            });
                                        });
                                        </script>';
                            }else{
                                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "There is an Error", "error", {
                                        button: "Continue",
                                            });
                                        });
                                        </script>';;
                            }

                        }else{
                            echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "There is an Error", "error", {
                                        button: "Continue",
                                            });
                                        });
                                        </script>';;;
                        }
                    }

                }
            }else{
                $error = '<script type="text/javascript">
                jQuery(function validation(){
                swal("Error", "Please Upload Image With Format : jpg, jpeg, png, gif", "error", {
                button: "Continue",
                    });
                });
                </script>';
                echo $error;

            }
            }
        }
    }

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Item
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Input New Item</h3>
            </div>
            <form action="" method="POST" name="form_product"
                enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Item Code</label>
                            <input type="text" class="form-control" name="product_code" placeholder="Example for Solar Panel: SOL-PNL">
                        </div>
                        <div class="form-group">
                            <label for="">Item Name</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Name of the Item or Product">
                        </div>
                        <div class="form-group">
                            <label for="">Category</label>
                            <select class="form-control" name="category" required>
								<option value="">Select Category</option>
                                <?php
                                $select = $pdo->prepare("SELECT * FROM tbl_category");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                    extract($row)
                                ?>
                                    <option><?php echo $row['cat_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Stock</label>
                            <input type="number" min="1" step="1" class="form-control" name="stock" placeholder="Total number of Item" required>
                        </div>
                        <div class="form-group">
                            <label for="">Minimal Stock</label><br>
                            <input type="number" min="1" step="1" class="form-control" name="min_stock" placeholder="Minimum number for re-stocking" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Unit</label>
                            <select class="form-control" name="unit" required>
							<option value="">Select Unit</option>
                                <?php
                                $select = $pdo->prepare("SELECT * FROM tbl_unit");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                    extract($row)
                                ?>
                                    <option><?php echo $row['nm_unit']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Item Description</label>
                            <textarea name="description" id="description" cols="30" rows="12" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Item Image</label><br>
                            <input type="file" class="input-group" name="product_img" onchange="readURL(this);" required> <br>
                            <img id="img_preview" src="img/select_image.jpg" alt="Preview" class="img-responsive" style="border:1px solid #d2d6de"/>
                        </div>
                    </div>
                </div>

                <div align="center" class="box-footer">
                    <button type="submit" class="btn btn-primary" name="add_product">Add Item</button> &nbsp;
                    <a href="items.php" class="btn btn-warning">Item List</a>
                </div>
            </form>
        </div>
    </section>
  </div>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result)
                .width(510)
                .height(286);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php include_once'inc/footer_all.php'; ?>