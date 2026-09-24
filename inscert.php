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

<html>
<head>

<script>
	function printF(){
	window.print();
	}
</script>

</head>
</html>

<style>
  .cert{
	text-align:center;
	border:1px solid #545454;
	padding:0px 5px 0 5px
  }
</style>

<div class="content-wrapper">
    <section class="content-header">
	<a onclick="printF()"  title="Print" style="cursor:pointer">
      <div style="font-size:22px">
        Installation Certificate &nbsp; &nbsp;<i class="fa fa-print"></i>&nbsp;&nbsp; 
		<i style="font-size:13px">(<x style="color:red">Print Settings: Letter Size with 90% Scale</x>)</i>
      </div></a>
      <hr>
    </section>

<!-- Main content -->
    <section class="content container-fluid">
        <div class="box" style="width:784px;height:1024px;margin-top:10px">
			<img src="img/certificate.png" height="1024" width="784"/>
			<?php
				
				$id = $_GET['id'];
				$query = $pdo->prepare("SELECT * FROM tbl_invoice WHERE invoice_id=$id");
				$query->execute();
				$row = $query->fetch(PDO::FETCH_OBJ);
                if(!$row) { die("Invalid ID"); }
				require('getvalue.php');
				
				echo"		
					<div style='text-align:center;width:150px;border:1px solid #bbb;border-radius:4px;font-size:14px;position:absolute;left:45%;top:19%;'>
						Rollout ID: <b style='color:red'>"; $cont = $id; printf("%04d", $cont); echo"</b>
					</div>";
					
				echo"
					<div style='text-align:center;width:150px;border:1px solid #bbb;border-radius:4px;font-size:14px;position:absolute;left:45%;top:28.3%;'>
						Installer: <b style='color:red'>$team</b>
					</div>
					
					<div style='position:absolute;left:17%;top:23%;'>
						<table>
						  <tbody>	
							<tr>
								<th width='130' class='cert'>SITE TYPE</th>
								<th width='120' class='cert'>BARANGAY</th>
								<th width='120' class='cert'>CITY/MUN</th>
								<th class='cert'>HEIGHT</th>
								<th class='cert'>POWER</th>
								<th width='108' class='cert'>AP UPLINK</th>
							</tr>
								<td class='cert'>$sitetype</td>
								<td class='cert'>$bar</td>
								<td class='cert'>$mun</td>
								<td class='cert'>$height</td>
								<td class='cert'>$power</td>
								<td class='cert'>$link</td>
						 </tbody>
						</table>
					</div>
				";

				$select = $pdo->prepare("SELECT * FROM tbl_invoice_detail WHERE invoice_id=$id");
				$select->execute();
				$i=1;
				echo"
				<div style='position:absolute;left:17%;top:31%;'>
					<table>
						<tr>
							<th width='33' class='cert'>NO</th>
							<th width='96' class='cert'>ITEM CODE</th>
							<th width='200' class='cert'>DEVICE NAME</th>
							<th width='55' class='cert'>QTY</th>
							<th width='60' class='cert'>UNIT</th>
							<th width='148' class='cert'>SN-MAC ADDRESS</th>
						</tr>";
							
					while($item = $select->fetch(PDO::FETCH_OBJ)){

					$mac  = $item->serial_mac;
					$str  = str_replace(':', '', $mac);

					$itemcode	= $item->product_code;
					$itemname	= $item->product_name;
					$itemdesc	= $item->description;
					$quantity	= $item->qty;
					$itemunit	= $item->product_unit;
					$serialmac	= $str;

					echo"
						<tr>
							<td class='cert'>$i</td>
							<td class='cert'>$itemcode</td>
							<td class='cert'>$itemname</td>
							<td class='cert'>$quantity</td>
							<td class='cert'>$itemunit</td>
							<td class='cert'>$serialmac</td>
						</tr>";
					$i++;
					}
					
				echo"
					</table>
				</div>
				
				<div style='font-size:15px;position:absolute;left:30%;top:66.7%;'><b>$leader</b></div>
				<div style='font-size:15px;position:absolute;left:76%;top:66.7%;'><b>$contact</b></div>
				<div style='text-transform:uppercase;font-size:15px;position:absolute;left:30%;top:70.4%;'><b>$contper</b></div>
				<div style='font-size:15px;position:absolute;left:76%;top:70.4%;'><b>$contnum</b></div>

				";
			?>
        </div>
    </section>
</div>