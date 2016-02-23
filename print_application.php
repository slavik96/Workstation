<?php
require_once ("_check.php");
require_once("_connect.php");
require_once("_function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"  />
<title>Роздрукувати заяви</title>
<link href="css.css" rel="stylesheet" type="text/css" /> 
<link href="css/vlaCal-v2.1.css" rel="stylesheet" type="text/css" /> 
</head>

<body style="background-color:#FFFFFF;">
		<table width="100%" border="0" cellspacing="5" cellpadding="5" style="font-size:9pt;">
		  <tr>
		  	<th width="20">ID</th>
			<th width="50">Договір</th>
			<th width="50">Ім'я</th>
		  	<th width="60">Прізвище</th>
			<th width="60">Телефон</th>
			<th width="60">Адреса</th>
			<th width="100">Дата подання заяви</th>
			<th width="100">Послуга</th>
			<th width="120">Вид робіт</th>
			<th width="20">Передбачувана ціна</th>
	
		  </tr>
			<?php
			$query=mysql_query("
				SELECT 
					tb_centr_modul.*, 
					tb_centr_modul.id as idapplication, 
					tb_seller.*, 
					tb_abonent.*,
					tb_services.*,
					tb_services.id_services as idservices, 
					tb_type_of_work.*,
					tb_type_of_work.id_type_of_work as idtypeofwork      
				FROM 
					tb_centr_modul 
					left join tb_seller on tb_centr_modul.id_seller=tb_seller.id_seller 
					left join tb_abonent on tb_centr_modul.id_abonent=tb_abonent.id_abonent 
					left join tb_type_of_work on tb_centr_modul.id_type_of_work=tb_type_of_work.id_type_of_work  
					left join tb_services on tb_centr_modul.id_services=tb_services.id_services

				WHERE
					tb_centr_modul.delete=''". 
					
					(isset($_SESSION['idtypeofwork'])?" AND tb_centr_modul.id_type_of_work=".$_SESSION['idtypeofwork']:"").
					(isset($_SESSION['idservices'])?" AND tb_centr_modul.id_services=".$_SESSION['idservices']:"").
					(isset($_SESSION['notdone'])?" AND tb_centr_modul.data_stop='0000-00-00'":"").
					(isset($_SESSION['done'])?" AND tb_centr_modul.data_stop!='0000-00-00'":"").
					(isset($_SESSION['datastart'])?" AND tb_centr_modul.data_add BETWEEN '".$_SESSION['datastart']."' AND '".$_SESSION['datafinish']."' ":"").
					(isset($_SESSION['dataispolstart'])?" AND tb_centr_modul.data_stop BETWEEN '".$_SESSION['dataispolstart']."' AND '".$_SESSION['dataispolfinish']."' ":"").
					(isset($_SESSION['adress_search'])?" AND tb_centr_modul.adress LIKE '%".$_SESSION['adress_search']."%' ":"").
					(isset($_SESSION['number_naryd'])?" AND tb_centr_modul.id='".$_SESSION['number_naryd']."'":"")
					."
				ORDER BY
					tb_centr_modul.id desc
				"			
			);
				
			$countrow=mysql_num_rows($query);
			if($query){
				
				while ($r=mysql_fetch_array($query)){
			?>			
				  <tr>
				  	<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['idapplication'];?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['dogovor'];?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['name_abonent'];?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['last_name_abonent'];?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['phone'];?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['adress'];?></td>
					
					<td align="right" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= dmy($r['data_add']);?></td>
					
						<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['name_services'];?></td>
								<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['name_type_of_work'];?></td>
									
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['summa'];?></td>	
									
				  </tr>
	<?php		
				}
			}
	?>
		</table>
<?php
		echo "<p style='color: #999999'>Взагалі відібрано записів: ".$countrow."</p>";
@mysql_free_result();
@mysql_close();
?>
</body>
</html>
