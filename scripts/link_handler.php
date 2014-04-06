<?php
if(isset($_POST['add'])){
	require_once 'link_lead.php';
	$link = new LinkLead();
	$link->linkLeads($_POST['main'], $_POST['link']);
}
else if(isset($_POST['delete'])){
	require_once 'link_lead.php';
	$link = new LinkLead();
	$link->deleteLink($_POST['main'], $_POST['link']);
}

?>