<?php
require_once 'export_lead.php';

if(isset($_POST['lids'])){
	$export = new ExportLead();
	$export->exportToCSV($_POST['lids']);
}

if(isset($_POST['lead'])){
	$export = new ExportLead();
	$export->getLeadCSV();
}	

if(isset($_POST['partner'])){
	$export = new ExportLead();
	$export->getPartnerCSV();
}	
?>