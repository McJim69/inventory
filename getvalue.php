<?php
	$leader="";
	if(($row->requestor)=='Team 00')$leader="MARK JHON H. DECIERDO";	
	if(($row->requestor)=='Team 01')$leader="DECON B. GENOVA";
	if(($row->requestor)=='Team 02')$leader="ARIEL LANCE C. LABADOR";
	if(($row->requestor)=='Team 03')$leader="AXLEVAN N. LORICO";
	if(($row->requestor)=='Team 04')$leader="JEFFERSON L. ROSAL";
	if(($row->requestor)=='Team 05')$leader="JUNREY B. SAMAN";	

	$contact="";
	if(($row->requestor)=='Team 00')$contact="09925762903";
	if(($row->requestor)=='Team 01')$contact="09386854397";
	if(($row->requestor)=='Team 02')$contact="09460775351";
	if(($row->requestor)=='Team 03')$contact="09508573175";
	if(($row->requestor)=='Team 04')$contact="09924145073";
	if(($row->requestor)=='Team 05')$contact="09097190574";	

	$sitetype="";
	if(($row->site_type)=='DCS')$sitetype="Data Center";
	if(($row->site_type)=='MBS')$sitetype="Base Station";	
	if(($row->site_type)=='BAP')$sitetype="Barangay Hall";	
	if(($row->site_type)=='REL')$sitetype="Barangay Relay";	
	if(($row->site_type)=='ELS')$sitetype="Elementary School";	
	if(($row->site_type)=='NHS')$sitetype="National High School";	
	if(($row->site_type)=='OTH')$sitetype="Other Public Places";	
	
	$id			= $row->invoice_id;
	$operator	= $row->operator_name;
	$purpose	= $row->purpose;
	$team		= $row->requestor;
	$date		= $row->order_date;
	$bar		= $row->barangay;
	$mun		= $row->city_mun;
	$contper	= $row->contact_per;
	$contnum	= $row->contact_num;
	$coor		= $row->grid_coor;
	$height		= $row->twr_height;
	$power		= $row->powering;
	$link		= $row->link_ap;

	$itemcode	= $item->product_code;
	$itemname	= $item->product_name;
	$quantity	= $item->qty;
	$unit		= $item->product_unit;
	$serial		= $item->serial_mac;
?>