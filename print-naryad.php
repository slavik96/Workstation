<?php
require_once ("_check.php");
require_once("_connect.php");
require_once("_function.php");

// выбираем заявку
if(isset($_GET['idapplication'])){
	$idapplication=substr($_GET['idapplication'],0,10);
	$query=mysql_query('
		SELECT 
			tb_centr_modul.*, tb_type_of_work.*, tb_seller.*, tb_abonent.*
		FROM 
			tb_centr_modul
			left join tb_seller on tb_centr_modul.id_seller=tb_seller.id_seller 
			left join tb_type_of_work on tb_centr_modul.id_type_of_work=tb_type_of_work.id_type_of_work
			left join tb_abonent on tb_centr_modul.id_abonent=tb_abonent.id_abonent 		

			WHERE
			tb_centr_modul.id='.$idapplication.'
		LIMIT 
			1
	');
	
	$r=mysql_fetch_array($query);
	
	$seller_select=$r['name_seller'];
	$name_abonent=$r['name_abonent'];
	$name_abonent=$r['last_name_abonent'];
	$phone=$r['phone'];
	$adress=$r['adress'];
	$comment=$r['comment'];
	$d_add=$r['data_add'];
	$data_stop=$r['data_stop'];
	$dogovor=$r['dogovor'];
	$data_dogovora=$r['data_dogovora'];
	$type_of_work_select=$r['name_type_of_work'];
	$name_services=$r['name_services'];
	$summa=$r['summa'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"  />
<title><?= $name_abonent." - ".$adress;?> - Чек</title>
<link href="css.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="js/js.js"></script>
</head>

<body style="background-color:#FFFFFF;">

<h1 align="center">Чек № <?= $_GET['idapplication']."/".date('d.m.Y')."/<span style='font-size: 10pt;'>SD - ".$sdesk."</span>";?></h1>
<h3 align="center"><?= $type_of_work_select;?></h3>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr align="left">
    <td width="200">Абонент:</td>
    <td><?= $name_abonent; $last_name_abonent;?></td>
  </tr>
  

  <tr align="left">
    <td width="200">Адресса абонента:</td>
    <td><?= $adress;?></td>
  </tr>
  <tr align="left">
    <td width="200">Договір:</td>
    <td> № <?=  $dogovor!=""?"<strong>".$dogovor."</strong>":"______________"; ?> від <?= $data_dogovora!="0000-00-00"?"<strong>".dmy($data_dogovora)." року</strong>":"\"____\"________________ 201__ г."; ?></td>
  </tr>
  <tr align="left">
    <td width="200">Контактні дані:</td>
    <td><?= $phone;?></td>
  </tr>
  <tr align="left">
    <td width="200">Відповідальний за заяву:</td>
    <td><?= $seller_select;?></td>
  </tr>
  <tr align="left">
    <td width="200">Коментарі:</td>
    <td><?= $comment;?></td>
  </tr>
    <td width="200">Ціна:</td>
  <td><?= $summa; ?></td>
  </tr>
</table>
<h2 align="center">Витрати матеріалів</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
  	<th width="50">№ п/п</th>
    <th>Назва матеріала</th>
    <th>Одиниці виміру</th>
	<th>Кількість</th>
  </tr>
  <tr>
    <th>1.</th>
	<th>&nbsp;</th>
    <th width="70">&nbsp;</th>
	<th width="70">&nbsp;</th>
  </tr>
  
  <tr>
    <th>2.</th>
    <th>&nbsp;</th>
    <th width="70">&nbsp;</th>
	<th width="70">&nbsp;</th>
  </tr>
  <tr>
    <th>3.</th>
    <th>&nbsp;</th>
    <th width="70">&nbsp;</th>
	<th width="70">&nbsp;</th>
  </tr>
  <tr>
    <th>4.</th>
    <th>&nbsp;</th>
    <th width="70">&nbsp;</th>
	<th width="70">&nbsp;</th>
  </tr>
  <tr>
    <th>5.</th>
    <th>&nbsp;</th>
    <th width="70">&nbsp;</th>
	<th width="70">&nbsp;</th>
  </tr>
  <tr>
    <th>6.</th>
    <th>&nbsp;</th>
    <th width="70">&nbsp;</th>
	<th width="70">&nbsp;</th>
  </tr>
  <tr>
    <th>7.</th>
    <th>&nbsp;</th>
    <th width="70">&nbsp;</th>
	<th width="70">&nbsp;</th>
  </tr>
</table>
<h2 align="center">Тех. Інформація</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="50">
  <tr align="left">
     <td>&nbsp;</td>
  </tr>
</table>
<h2 align="center">Виконання наряду</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr align="left">
    <td width="200">Наряд виконав (ФІО):</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="left">
    <td width="200">Дата виконання:</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="left">
    <td width="200">Підпис Абонента:</td>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
