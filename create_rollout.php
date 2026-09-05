<?php
   include_once'db/connect_db.php';
   session_start();
   
   if($_SESSION['username']==""){
		include_once'inc/404.php';
	}else{
	
	if($_SESSION['role']=="Admin"){
		include_once'inc/header_all.php';
	}else{
		include_once'inc/header_all_operator.php';
		}
	}
    
	date_default_timezone_set('Asia/Manila');

    function fill_product($pdo){
      $output= '';

      $select = $pdo->prepare("SELECT * FROM tbl_product order by product_name");
      $select->execute();
      $result = $select->fetchAll();

      foreach($result as $row){
        $output.='<option value="'.$row['product_id'].'">'.$row["product_name"].'</option>';
      }

      return $output;
    }

	function jump($page){
	echo"<script>window.location='$page'</script>";
	}		  

    if(isset($_POST['save_order'])){
      $operator_name 	 = $_POST['operator_name'];
	  $city_mun      	 = $_POST['city_mun'];
	  $barangay      	 = $_POST['barangay'];
	  $grid_coor      	 = $_POST['grid_coor'];
      $purpose	     	 = $_POST['purpose'];
      $requestor     	 = $_POST['requestor'];
      $order_date    	 = date("Y-m-d",strtotime($_POST['orderdate']));
      $order_time    	 = date("H:i", strtotime($_POST['timeorder']));
	  $site_type      	 = $_POST['site_type'];
	  $twr_height      	 = $_POST['twr_height'];
	  $powering      	 = $_POST['powering'];
	  $link_ap      	 = $_POST['link_ap'];
	  $contact_per       = $_POST['contact_per'];
	  $contact_num       = $_POST['contact_num'];
	  
      $arr_product_id    = $_POST['productid'];
      $arr_product_name  = $_POST['productname'];
      $arr_product_code  = $_POST['productcode'];
      $arr_product_stock = $_POST['productstock'];
      $arr_product_qty   = $_POST['quantity'];
      $arr_product_unit  = $_POST['productunit'];
	  $arr_serial_mac    = $_POST['serial_mac'];

      if($arr_product_code == ""){
        echo '<script type="text/javascript">
              jQuery(function validation(){
              swal("Warning", "Please Add + Rollout Form", "warning", {
              button: "Continue",
                  });
              });
              </script>';
      }else{
        $insert = $pdo->prepare("INSERT INTO tbl_invoice(operator_name, city_mun, barangay, grid_coor, purpose, requestor, order_date, time_order, site_type, twr_height, powering, link_ap, contact_per, contact_num)
        values(:encoder, :citymun, :barangay, :gridcoor, :purpose, :requestor, :orderdate, :timeorder, :sitetype, :twrheight, :powering, :linkap, :contactper, :contactnum)");

        $insert->bindParam(':encoder', 	  $operator_name);
		$insert->bindParam(':citymun',    $city_mun);
		$insert->bindParam(':barangay',   $barangay);
		$insert->bindParam(':gridcoor',   $grid_coor);
		$insert->bindParam(':purpose',    $purpose);
        $insert->bindParam(':requestor',  $requestor);
        $insert->bindParam(':orderdate',  $order_date);
        $insert->bindParam(':timeorder',  $order_time);
		$insert->bindParam(':sitetype',   $site_type);		
		$insert->bindParam(':twrheight',  $twr_height);
		$insert->bindParam(':powering',   $powering);
		$insert->bindParam(':linkap',     $link_ap);
		$insert->bindParam(':contactper', $contact_per);
		$insert->bindParam(':contactnum', $contact_num);

        $insert->execute();

        $invoice_id = $pdo->lastInsertId();
        if($invoice_id!=null){
          for($i=0; $i<count($arr_product_id); $i++){

            $rem_qty = $arr_product_stock[$i] - $arr_product_qty[$i];

            if($rem_qty<0){
              echo '<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Input Buying Amount", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';
            }else{
              $update = $pdo->prepare("UPDATE tbl_product SET stock = '$rem_qty' WHERE product_id='".$arr_product_id[$i]."'");
              $update->execute();
            }

            $insert = $pdo->prepare("INSERT INTO tbl_invoice_detail(invoice_id, product_id, product_code, product_name, qty, product_unit, serial_mac, order_date)
	        values(:invid, :productid, :productcode, :productname, :qty, :productunit, :serialmac, :orderdate)");

            $insert->bindParam(':invid',  	   $invoice_id);
            $insert->bindParam(':productid',   $arr_product_id[$i]);
            $insert->bindParam(':productcode', $arr_product_code[$i]);
            $insert->bindParam(':productname', $arr_product_name[$i]);
            $insert->bindParam(':qty', 		   $arr_product_qty[$i]);
            $insert->bindParam(':productunit', $arr_product_unit[$i]);
            $insert->bindParam(':serialmac',   $arr_serial_mac[$i]);
            $insert->bindParam(':orderdate',   $order_date);

            $insert->execute();

          }
          echo"<script>location.href='rollout.php';</script>";
        }
      }
    }
?>

<div class="content-wrapper">
	<section class="content-header"><h1>Pull Out Request Form</h1><hr></section>
    <section class="content container-fluid">
        <div class="box box-success">
          <form action="" method="POST">
            <div class="box-body">
              <div class="col-md-2" style="display:none">
                <div class="form-group">
                  <label>Encoder Name</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="operator_name" value="<?php echo $_SESSION['username']; ?>" readonly>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Municipality</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-car"></i>
                    </div>
					<select class="form-control" name="city_mun" required onchange="jump('?&barangays=<?php echo $_GET["barangays"];?>&municipality='+this.value)">
						<option value="" selected="1">Municipality</option>
                        <?php					
							require("connect.php");
							$ex2=$conn->query("select city_mun from tbl_barangays where brgyname='".$_GET["barangays"]."' group by city_mun order by city_mun")or die(mysqli_error($conn));
							if($_GET["barangays"]=="" || $_GET["barangays"]=="Barangay")
							$ex2=$conn->query("select city_mun from tbl_barangays group by city_mun order by city_mun")or die(mysqli_error($conn));										
							while($rs2=mysqli_fetch_array($ex2)){
								echo "<option ";
							if($_GET["municipality"]===$rs2[0])
								echo "selected";
								echo">$rs2[0]</option>";
							}
                        ?>
					</select>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Barangay</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-motorcycle"></i>
                    </div>
					<select class="form-control" name="barangay" required onchange="jump(?municipality=<?php echo $_GET["municipality"];?>&barangays='+this.value')">
						<option value="" selected="1">Barangay</option>
						<?php										
							require("connect.php");
							$ex2=$conn->query("select brgyname from tbl_barangays where city_mun='".$_GET["municipality"]."' group by brgyname order by brgyname")or die(mysqli_error($conn));
							if($_GET["municipality"]=="" || $_GET["municipality"]=="Municipality")
							$ex2=$conn->query("select brgyname from tbl_barangays group by brgyname order by brgyname")or die(mysqli_error($conn));										
							while($rs2=mysqli_fetch_array($ex2)){
								echo "<option ";
							if($_GET["barangays"]===$rs2[0])
								echo "selected";
								echo">$rs2[0]</option>";
							}
						?>
					</select>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Site Longitude, Latitude</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-thumb-tack"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="grid_coor" placeholder="Grid Coodinates" required>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Installation Type</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-wrench"></i>
                    </div>
					<select class="form-control" name="purpose" required>
						<option value="">Select Type</option>
						<option value="New Site Installation">Site Upgrade</option>
						<option value="New Site Installation">New Installation</option>
						<option value="Repair & Maintenacne">Repair/Mainenance</option>
					</select>
                  </div>
                </div>
              </div>			  
              <div class="col-md-2">
                <div class="form-group">
                  <label>Requestor Team</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-users"></i>
                    </div>
					<select class="form-control" name="requestor" required>
						<option value="">Select Team</option>
						<option value="Team 00">Team 00-DECIERDO</option>
						<option value="Team 01">Team 01-GENOVA</option>
						<option value="Team 02">Team 02-LABADOR</option>
						<option value="Team 03">Team 03-LORICO</option>
						<option value="Team 04">Team 04-ROSAL</option>
						<option value="Team 05">Team 05-SAMAN</option>
					</select>
                  </div>
                </div>
              </div>	
              <div class="col-md-2">
                <div class="form-group">
                  <label>Rollout Date</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" data-date-format="yyyy-mm-dd"  required>
                  </div>
                </div>
              </div>
              <div class="col-md-2" style="display:none">
                <div class="form-group">
                  <label>Time Requested</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="timeorder" value="<?php echo date('H:i') ?>" readonly>
                  </div>
                </div>
              </div>			  
              <div class="col-md-2">
                <div class="form-group">
                  <label>Site Type</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-home"></i>
                    </div>
					<select class="form-control" name="site_type" required>
						<option value="">Site Type</option>
						<option value="MBS">Data Center</option>
						<option value="MBS">Base Station</option>
						<option value="BAP">Barangay Hall</option>
						<option value="REL">Barangay Relay</option>
						<option value="ELS">Elementary School</option>
						<option value="NHS">National High School</option>
						<option value="OTH">Other Public Places</option>
					</select>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Tower/Pole Height</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-tree"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="twr_height" placeholder="Installation Height (Meters)" required>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Powering</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-bolt"></i>
                    </div>
					<select class="form-control" name="powering" required>
						<option value="">Powering</option>
						<option value="Grid">Grid</option>
						<option value="Solar">Solar</option>
						<option value="Hybrid">Hybrid</option>
					</select>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>AP Link Site</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-wifi"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="link_ap" placeholder="Link AP Site/Location" required>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Contact Person</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="contact_per" placeholder="Caretaker or Brgy Officials" required>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Contact Number</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-phone"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="contact_num" placeholder="Cellphone Number" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-body">DEVICE
              <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-border" id="myOrder">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Name</th>
                          <th>Code</th>
                          <th>Stock</th>
						  <th>Quantity</th>
						  <th>Unit</th>
                          <th>Serial/MAC</th>
                          <th>
                            <button type="button" name="addOrder" class="btn btn-success btn-sm btn_addOrder" required><span>
                              <i class="fa fa-plus"></i>
                            </span></button>
                          </th>
                      </tr>

                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>

            <div class="box-footer" align="center">
              <input type="submit" name="save_order" value="Save Rollout" class="btn btn-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="rollout.php" class="btn btn-warning">Back to Rollout</a>
            </div>
          </form>
        </div>
    </section>
  </div>

  <script>
    $('#datepicker').datepicker({
      autoclose: true
    })

    $('.timepicker').timepicker({
      showInputs: false
    })

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })

    $(document).ready(function(){
      $(document).on('click','.btn_addOrder', function(){
        var html='';
        html+='<tr>';
        html+='<td><input type="hidden" class="form-control productname" name="productname[]" readonly></td>';
        html+='<td><select class="form-control productid" name="productid[]" style="width:200px;" required><option value="">Select Item</option><?php echo fill_product($pdo);?></select></td>';
        html+='<td><input type="text" class="form-control productcode" style="width:150px;" name="productcode[]" readonly></td>';
        html+='<td><input type="text" class="form-control productstock" style="width:150px;" name="productstock[]" readonly></td>';
        html+='<td><input type="number" min="1" max="50" class="form-control quantity_product" style="width:150px;" name="quantity[]" required></td>';
        html+='<td><input type="text" class="form-control productunit" style="width:150px;" name="productunit[]" readonly></td>';
        html+='<td><input type="text" class="form-control serial_mac" style="width:150px;" name="serial_mac[]" required></td>';
        html+='<td><button type="button" name="remove" class="btn btn-danger btn-sm btn-remove"><i class="fa fa-remove"></i></button></td>'

        $('#myOrder').append(html);

        $('.productid').on('change', function(e){
          var productid = this.value;
          var tr=$(this).parent().parent();
          $.ajax({
            url:"getproduct.php",
            method:"get",
            data:{id:productid},
            success:function(data){
              tr.find(".productcode").val(data["product_code"]);
              tr.find(".productname").val(data["product_name"]);
              tr.find(".productstock").val(data["stock"]);
              tr.find(".quantity_product").val(0);
              tr.find(".productunit").val(data["product_unit"]);
              tr.find(".serial_mac").val();
			 // calculate(0,0);
            }
          })
        })
      })

      $(document).on('click','.btn-remove', function(){
        $(this).closest('tr').remove();
        calculate(0,0);
      })

      $("#myOrder").delegate(".quantity_product","keyup change", function(){
        var quantity = $(this);
        var tr=$(this).parent().parent();
        if((quantity.val()-0)>(tr.find(".productstock").val()-0)){
          swal("Warning","Not Enough Stock","warning");
          quantity.val(1);
        }
      })

    });
  </script>

<?php include_once'inc/footer_all.php'; ?>