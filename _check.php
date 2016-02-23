<?php
session_start();

if($_SESSION['rightsMODUL']=='' || $_SESSION['iduserMODUL']==''){
	header("Location: index.php");
}

/*
if(!session_is_registered("rightsMODUL") || !session_is_registered("iduserMODUL")){
	header("Location: index.php");
}
*/
?>