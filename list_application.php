<?php
require_once ("_check.php");
$loginMODUL=$_SESSION['loginMODUL'];



if(isset($_GET['idtypeofwork'])){

	$_SESSION['idtypeofwork']=$_GET['idtypeofwork'];

}
if(isset($_GET['idservices'])){

	$_SESSION['idservices']=$_GET['idservices'];

}
if(isset($_GET['notdone'])){

unset( $_SESSION['done'] ); 


	$_SESSION['notdone']=$_GET['notdone'];

}
if(isset($_GET['done'])){
	
	unset( $_SESSION['notdone'] ); 

	$_SESSION['done']=$_GET['done'];

}

if(isset($_POST['data_start']) && $_POST['data_start']!=''){
	
	$_SESSION['datastart']=$_POST['data_start'];

}

if(isset($_POST['data_finish']) && $_POST['data_finish']!=''){
	
	$_SESSION['datafinish']=$_POST['data_finish'];
	
}
if(isset($_POST['data_stop_start']) && $_POST['data_stop_start']!=''){
	
	$_SESSION['dataispolstart']=$_POST['data_stop_start'];

}
if(isset($_POST['data_stop_finish']) && $_POST['data_stop_finish']!=''){
	
	$_SESSION['dataispolfinish']=$_POST['data_stop_finish'];

}

if(isset($_POST['phone_seach']) && $_POST['phone_seach']!=''){
	
	$_SESSION['phone_seach']=$_POST['phone_seach'];

}
if(isset($_POST['adress_search']) && $_POST['adress_search']!=''){
	
	$_SESSION['adress_search']=$_POST['adress_search'];

}

if(isset($_POST['name_abonent_seach']) && $_POST['name_abonent_seach']!=''){
	
	$_SESSION['name_abonent_seach']=$_POST['name_abonent_seach'];

}


if(isset($_POST['last_name_abonent_seach']) && $_POST['last_name_abonent_seach']!=''){
	
	$_SESSION['last_name_abonent_seach']=$_POST['last_name_abonent_seach'];

}

if(isset($_POST['number_naryd']) && $_POST['number_naryd']!=''){
	
	$_SESSION['number_naryd']=$_POST['number_naryd'];

}

if(isset($_POST['dogovor']) && $_POST['dogovor']!=''){
	
	$_SESSION['dogovor']=$_POST['dogovor'];

}

if(isset($_POST['summa_seach']) && $_POST['summa_seach']!=''){
	
	$_SESSION['summa_seach']=$_POST['summa_seach'];

}

if(isset($_GET['clearsession'])){
	
unset( $_SESSION['idusluga'] ); 
unset( $_SESSION['idtypeofwork'] ); 
unset( $_SESSION['idservices'] ); 
unset( $_SESSION['notdone'] ); 
unset( $_SESSION['done'] ); 
unset( $_SESSION['datastart'] ); 
unset( $_SESSION['datafinish'] ); 
unset( $_SESSION['dataispolstart'] ); 
unset( $_SESSION['dataispolfinish'] ); 
unset( $_SESSION['phone_seach'] ); 
unset( $_SESSION['adress_search'] ); 
unset( $_SESSION['name_abonent_seach'] ); 
unset( $_SESSION['last_name_abonent_seach'] ); 
unset( $_SESSION['number_naryd'] ); 
unset( $_SESSION['dogovor'] ); 
unset( $_SESSION['summa_seach'] ); 
}
require_once ("_check.php");

require_once("_connect.php");
require_once("_function.php");

$onpage=10;
$page=page();
$begin=$page*$onpage-$onpage;
$server_url=$_SERVER['REQUEST_URI'];


$error_flag=false;
$img=$error_last_name_abonent=$error_phone=$error_adress=$error_data_stop="";


$seller=isset($_POST['seller'])?substr($_POST['seller'],0,10):"";
$abonent=isset($_POST['id_abonent'])?substr($_POST['id_abonent'],0,10):"";
$name_abonent_seach=isset($_POST['name_abonent_seach'])?htmlspecialchars(trim(substr($_POST['name_abonent_seach'],0,30))):""; 
$last_name_abonent_seach=isset($_POST['last_name_abonent_seach'])?htmlspecialchars(trim(substr($_POST['last_name_abonent_seach'],0,30))):""; 
$adreass_seach=isset($_POST['adreass_seach'])?htmlspecialchars(trim(substr($_POST['adreass_seach'],0,30))):""; 
$phone_seach=isset($_POST['phone_seach'])?htmlspecialchars(trim(substr($_POST['phone_seach'],0,30))):""; 

$abonent=isset($_POST['abonent'])?substr($_POST['abonent'],0,10):"";
$type_of_work=isset($_POST['type_of_work'])?substr($_POST['type_of_work'],0,10):"";
$comment=isset($_POST['comment'])?htmlspecialchars(trim($_POST['comment'])):""; 
$data_add=date('Y-m-d');
$computer=gethostbyaddr($_SERVER['REMOTE_ADDR']);
$summa=isset($_POST['summa'])?str_replace(",", ".", substr(trim($_POST['summa']),0,10)):""; 

$r_upd=isset($_GET['r_upd'])?"?r_upd=".substr($_GET['r_upd'],0,10):'';

$data_stop=isset($_POST['data_stop'])?substr(trim($_POST['data_stop']),0,10):""; 
$data_dogovora=isset($_POST['data_dogovora'])?substr(trim($_POST['data_dogovora']),0,10):""; 
$dogovor=isset($_POST['dogovor'])?htmlspecialchars(trim(substr($_POST['dogovor'],0,30))):""; 

$data_start=isset($_POST['data_start'])?substr(trim($_POST['data_start']),0,10):isset($_SESSION['datastart'])?$_SESSION['datastart']:""; 
$data_finish=isset($_POST['data_finish'])?substr(trim($_POST['data_finish']),0,10):isset($_SESSION['datafinish'])?$_SESSION['datafinish']:""; 

$data_stop_start=isset($_POST['data_stop_start'])?substr(trim($_POST['data_stop_start']),0,10):isset($_SESSION['dataispolstart'])?$_SESSION['dataispolstart']:""; 
$data_stop_finish=isset($_POST['data_stop_finish'])?substr(trim($_POST['data_stop_finish']),0,10):isset($_SESSION['dataispolfinish'])?$_SESSION['dataispolfinish']:""; 


$number_naryd=isset($_POST['number_naryd'])?substr(trim($_POST['number_naryd']),0,10):isset($_SESSION['number_naryd'])?$_SESSION['number_naryd']:""; 





//Перевіряємо правильність зміни заяви

if(isset($_POST['data_stop']) && ($_POST['data_stop']=='' || $_POST['data_stop']=='0000-00-00' || $_POST['data_stop']<$d_add)){
	if($_POST['data_stop']<$d_add)
		$error_data_stop='<p class="error">Дата не може бути менша дати подання заяви.</p>';
	if($_POST['data_stop']=='0000-00-00')
		$error_data_stop='<p class="error">Дата не може бути нулевою.</p>';
	if($_POST['data_stop']=='')
		$error_data_stop='<p class="error">Поле не може бути порожнім.</p>';
	
	$error_flag=true;
}

// Обираємо заявку для редагування
if(isset($_GET['idapplication'])){
	$idapplication=substr($_GET['idapplication'],0,10);
	$query=mysql_query('
		SELECT 
			tb_centr_modul.*
		FROM 
			tb_centr_modul
		WHERE
			tb_centr_modul.id='.$idapplication.'
		LIMIT 
			1
	');
	
	
	
	$r=mysql_fetch_array($query);
	
	$seller_select=$r['id_seller'];
	$abonent_select=$r['id_abonent'];
	$services_select=$r['id_services'];
	$abonent_select=$r['id_abonent'];
	$type_of_work_select=$r['id_type_of_work'];
	$comment=$r['comment'];
	$data_add=$r['data_add'];
	$data_stop=$r['data_stop'];
	$computer=gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$r_upd="?r_upd=".$r['id'];
	$summa=$r['summa'];
	
}

// Вносимо зміни в заяви
if(isset($_POST['abonent']) && $error_flag==false && $r_upd!=""){

	$r_upd=substr($_GET['r_upd'],0,10);
	
	mysql_query("UPDATE 
					tb_centr_modul 
				 SET
					id_seller=\"$seller\", 
			        id_abonent=\"$abonent\", 
					id_type_of_work=\"$type_of_work\",
					comment=\"$comment\",
					data_add=\"$data_add\",
					data_stop=\"$data_stop\",
					computer_edit=\"$loginMODUL\",
					summa =\"$summa\" 
				
				 WHERE
				 	tb_centr_modul.id=".$r_upd."
				 LIMIT
				 	1
				 ");
				  
			 
$seller=$abonent=$type_of_work=$comment=$data_add=$data_stop=$computer_edit=$summa="";	$id=true;
}

if(isset($_GET['vzad']) && $r_upd!=""){

	$r_upd=substr($_GET['r_upd'],0,10);

	mysql_query("UPDATE 
					tb_centr_modul 
				 SET
					data_stop=\"0000-00-00\",
					computer_edit=\"$loginMODUL\" 
				 WHERE
				 	tb_centr_modul.id=".$r_upd."
				 LIMIT
				 	1
				 ");
	$computer="";
	$id=true;
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"  />
<title>Вивести заяву</title>
<link href="css.css" rel="stylesheet" type="text/css" /> 
<link href="css/vlaCal-v2.1.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="js/js.js"></script>
<script language="javascript" type="text/javascript" src="js/mootools-1.2.1-core.js"></script>
<script language="javascript" type="text/javascript" src="js/vlaCal-v2.1.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">jQuery.noConflict();</script>
<script type="text/javascript">
	window.addEvent('domready', function() {
		new vlaDatePicker('textbox-id-start');
		new vlaDatePicker('textbox-id-finish');
		new vlaDatePicker('textbox-id-start-ispol');
		new vlaDatePicker('textbox-id-finish-ispol');
		new vlaCalendar('block-element-id');
	});
</script>
</head>

<body style="background-color:#FFFFFF;">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="240" align="left" valign="top"><?php require_once("_menu_new.php");?></td>
    <td valign="top">
		<?php
		if(isset($_GET['idapplication']) || $error_flag===true){
		?>
			<h1 style="color:#009966">Закрити заяву:</h1>
			<?php
			if(isset($id) || isset($del_ok)){
				echo "<div id='msg_ok'>Действие выполнено успешно.</div>";
			}
			?>
			<form method="post" action="list_application.php<?= $r_upd;?>" enctype="multipart/form-data" >
				<p class="pclass">Спеціаліст внесший заяву:</p>
				<select name="seller" class="selclass_important">
					<?php
					$list=getlist("tb_seller","id_seller","name_seller","","name_seller",isset($seller_select)?"$seller_select":"");
					echo $list;
					?>
				</select>
	
		<p class="pclass">Абонент:</p>
			<select name="abonent" class="selclass_important">
					<?php
				$list=getlistname("tb_abonent","id_abonent","last_name_abonent","name_abonent","","last_name_abonent",isset($abonent_select)?"$abonent_select":"");
				echo $list;
				?>
			</select>
	
			
			<p class="pclass">Вид робіт:</p>
			<select name="type_of_work" class="selclass_important" >
				<?php
				$list=getlist("tb_type_of_work","id_type_of_work","name_type_of_work","","name_type_of_work",isset($type_of_work_select)?"$type_of_work_select":"");
				echo $list;
				?>
			</select>
					
		
				<p class="pclass">Дата виконання:</p>
				<input type="hidden" name="d_add" value="<?= isset($d_add)?$d_add:'';?>" />
				<input type="text" name="data_stop" class="txt_important" style="width: 70px;" id="textbox-id-start" value="<?= $data_stop!=''?$data_stop:'';?>" maxlength="10" />
				<?= $error_data_stop;?>

				<p class="pclass">Комментарі (255 символів):</p>
				<textarea name="comment" class="areatext" style="width: 355px; height: 70px;"><?= stripslashes($comment);?></textarea>
			
				
				<p class="pclass">Сума до сплати:</p>
				<input type="text" name="summa" class="txt" style="width: 70px;" value="<?= $summa!=''?$summa:'';?>" maxlength="10" />
				<br /><br />
				<input type="submit" value="Сохранить" class="but" />
				<?php
					if(($_SESSION['loginMODUL']=='svyatoslav' OR $_SESSION['loginMODUL']=='paramej') && $r_upd!=''){
				?>
				
						&nbsp; &nbsp; &nbsp; &nbsp;<a href="list_application.php<?= $r_upd;?>&vzad=1" style="color:#FF0000; ">← Повернутися в початок </a>
				
				<?php					
					}
				?>
			</form>
		<?php
		}else{
		?>
		
		
		
		<h1 style="color:#009966">Список заяв:</h1>
		<?php
		if(isset($_SESSION['idtypeofwork']) || isset($_SESSION['idservices']) || isset($_SESSION['notdone']) || isset($_SESSION['done']) || isset($_SESSION['datastart']) || isset($_SESSION['datafinish']) || isset($_SESSION['dataispolstart']) || isset($_SESSION['dataispolfinish']) || isset($_SESSION['adress_search']) ||  isset($_SESSION['phone']) || isset($_SESSION['name_abonent_seach']) || isset($_SESSION['last_name_abonent_seach']) ||   isset($_SESSION['number_naryd']) || isset($_SESSION['dogovor'])|| isset($_SESSION['summa_seach']) ){
		?>
			<span><a href="list_application.php?clearsession=1" title="Сбросить фильтры" style="color:#FF0000;">Зняти фільтри</a></span> &nbsp;&nbsp;
			<span><a href="print_application.php" title="Распечатать заявки" style="color: #009933;" target="_blank">Роздрукувати заяви</a></span> &nbsp;&nbsp;
		<?php 
		}
		if(!isset($_SESSION['notdone'])){
		?>
			<span><a href="list_application.php?notdone=1" title="Только невиконані" style="color: #999999">Вивести тільки невиконані заяви</a></span> &nbsp;&nbsp;
		<?php
		}if(!isset($_SESSION['done'])){
		?>
			<span><a href="list_application.php?done=1" title="Только виконані" style="color: #999999">Вивести виконані заяви</a></span>
		<?php
		}
		?>
		<form method="post" action="list_application.php" enctype="multipart/form-data">
			
			
			<div style="float: left;">
			<p class="pclass">Дата заяви:</p>
				<input type="text" name="data_start" class="txt" style="width: 70px;" id="textbox-id-start" value="<?= $data_start!=''?$data_start:'';?>" maxlength="10" />
				- <input type="text" name="data_finish" class="txt" style="width: 70px;" id="textbox-id-finish" value="<?= $data_finish!=''?$data_finish:'';?>" maxlength="10" />
			</div>
			
			<div style="padding-left: 10px; float: left;">
			<p class="pclass">Дата виконання заяви:</p>
				<input type="text" name="data_stop_start" class="txt" style="width: 70px;" id="textbox-id-start-ispol" value="<?= $data_stop_start!=''?$data_stop_start:'';?>" maxlength="10" />
				- <input type="text" name="data_stop_finish" class="txt" style="width: 70px;" id="textbox-id-finish-ispol" value="<?= $data_stop_finish!=''?$data_stop_finish:'';?>" maxlength="10" />
			</div>
			
			<div style="padding-left: 10px; float: left;">
			<p class="pclass">Ім'я:</p>
			<input type="text" name="name_abonent_seach" class="txt" style="width: 70px;" value="<?= $name_abonent_seach!=''?$name_abonent_seach:'';?>" maxlength="150" />
			</div>
			
			<div style="padding-left: 10px; float: left;">
			<p class="pclass">Прізвище:</p>
			<input type="text" name="last_name_abonent_seach" class="txt" style="width: 70px;" value="<?= $last_name_abonent_seach!=''?$last_name_abonent_seach:'';?>" maxlength="150" />
			</div>
			
			<div style="padding-left: 10px; float: left;">
			<p class="pclass">Телефон:</p>
			<input type="text" name="phone_seach" class="txt" style="width: 70px;" value="<?= $phone_seach!=''?$phone_seach:'';?>" maxlength="150" />
			</div>
			
			<div style="padding-left: 10px; float: left;">
			<p class="pclass">Адрес:</p>
			<input type="text" name="adress_search" class="txt" style="width: 150px;" value="<?= $adress_search!=''?$adress_search:'';?>" maxlength="150" />
			</div>
			
			
			<div style="padding-left: 10px; float: left;">
			<p class="pclass">Договір:</p>
			<input type="text" name="dogovor" class="txt" style="width: 70px;" value="<?= $dogovor!=''?$dogovor:'';?>" maxlength="10" />
			</div>
			
			<div style="padding-left: 10px; float: left;">
			<p class="pclass">Ціна:</p>
			<input type="text" name="summa_seach" class="txt" style="width: 50px;" value="<?= $summa_seach!=''?$summa_seach:'';?>" maxlength="150" />
			</div>
		
			<div style="padding-left: 10px; float: left;">
			<p class="pclass">№ заяви:</p>
			<input type="text" name="number_naryd" class="txt" style="width: 50px;" value="<?= $number_naryd!=''?$number_naryd:'';?>" maxlength="150" />
			</div>
		
		
		
		
			<div style="padding: 29px 0 0 1100px;">
			<input type="submit" value="Пошук" class="but" />
			</div>

			<div class="clear"></div>
		</form>
		
		<table width="100%" border="0" cellspacing="5" cellpadding="5" style="font-size:9pt;">
		  <tr>
		  	<th>ID</th>
			<th>Договір</th>
			<th width="100">Ім'я</th>
		  	<th width="100">Прізвище</th>
			<th>Телефон</th>
			<th width="150">Адреса</th>
			<th width="80">Дата подання заявки</th>
			<th width="80">Дата виконання</th>
			<th>Послуги</th>
			<th>Вид робіт</th>
			<th width="80">Ціна</th>
			<th>Дод. інф.</th>
			<th>Друк чек</th>
			<th>Р</th>
			<th width="30">DEL</th>
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
					
					
					(isset($_SESSION['notdone'])?" AND tb_centr_modul.data_stop='0000-00-00'":"").
					(isset($_SESSION['done'])?" AND tb_centr_modul.data_stop!='0000-00-00'":"").
					(isset($_SESSION['datastart'])?" AND tb_centr_modul.data_add BETWEEN '".$_SESSION['datastart']."' AND '".$_SESSION['datafinish']."' ":"").
					(isset($_SESSION['dataispolstart'])?" AND tb_centr_modul.data_stop BETWEEN '".$_SESSION['dataispolstart']."' AND '".$_SESSION['dataispolfinish']."' ":"").
					(isset($_SESSION['phone_seach'])?" AND tb_abonent.phone LIKE '%".$_SESSION['phone_seach']."%' ":"").
					(isset($_SESSION['adress_search'])?" AND tb_abonent.adress LIKE '%".$_SESSION['adress_search']."%' ":"").
					(isset($_SESSION['name_abonent_seach'])?" AND tb_abonent.name_abonent LIKE '%".$_SESSION['name_abonent_seach']."%' ":"").
					(isset($_SESSION['last_name_abonent_seach'])?" AND tb_abonent.last_name_abonent LIKE '%".$_SESSION['last_name_abonent_seach']."%' ":"").
					(isset($_SESSION['number_naryd'])?" AND tb_centr_modul.id='".$_SESSION['number_naryd']."'":"").
					(isset($_SESSION['dogovor'])?" AND tb_abonent.dogovor LIKE '%".$_SESSION['dogovor']."%' ":"").
					(isset($_SESSION['summa_seach'])?" AND tb_centr_modul.summa LIKE '%".$_SESSION['summa_seach']."%' ":"")

					."
				ORDER BY
					tb_centr_modul.id desc
				LIMIT ".$begin.", ".$onpage
				
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
					<td align="right" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['data_stop']!="0000-00-00"?dmy($r['data_stop']):"<span style='color: red;'>Невиконана</span>";?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['name_services'];?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['name_type_of_work'];?></td>
				
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['summa'];?></td>	
									
									
									
					<td align="center" valign="top" style="border-bottom:1px solid #CCCCCC;">
					
						<span style='cursor:pointer; color: #0066CC;' onclick="showDopInfa('<?= $r['idapplication'];?>')">Показати</span>
					
					</td>
					
					<td align="center" valign="top" style="border-bottom:1px solid #CCCCCC;">
						<a href="print-naryad.php?idapplication=<?= $r['idapplication'];?>" title="Роздрукувати наряд" target="_blank">Наряд</a> <br />
						
						<?php
						if(($r['idservices']==1 || $r['idservices']==12 || $r['idservices']==2 || $r['idservices']==13 || $r['idservices']==10) && $r['idtypeofwork']==2){
						?>
							<a href="print-akt.php?idapplication=<?= $r['idapplication'];?>" title="Роздрукувати акт виконаних работ" target="_blank">Акт ВР</a><br />
							<a href="print-smeta.php?idapplication=<?= $r['idapplication'];?>" title="Роздрукувати смету" target="_blank">Смета</a>
						<?php
						}
						?>
					
					</td>

					<?php
					if((isset($_SESSION['rightsMODUL']) && $_SESSION['rightsMODUL']==11) || (isset($_SESSION['rightsMODUL']) && $_SESSION['iduserMODUL']==$r['id_seller'])){
					?>

						<td align="center" style="border-bottom:1px solid #CCCCCC;">
							<a href="list_application.php?idapplication=<?= $r['idapplication'];?>"><img src="img/icon/page_edit.png" title="Заява виконана" border="0" /></a>
						</td>
						<td align="center" style="border-bottom:1px solid #CCCCCC;">
							<?php
							if($_SESSION['loginMODUL']=='svyatoslav' OR $_SESSION['loginMODUL']=='paramej'){
							?>
							<a href="add_application.php?iddel=<?= $r['idapplication'];?>" onclick="return confirmSubmit()"><img src="img/icon/delete.gif" title="Видалити" border="0" /></a>
							<?php
							}
							?>
						</td>
					
					<?php
					}else{
					?>
						<td colspan="2" align="center" style="border-bottom:1px solid #CCCCCC;"><span style="color: #999999;">Нема прав</span></td>
					<?php
					}
					?>
					
				  </tr>
				  <tr>
					<td colspan="9"><span id="showDopInfa_<?= $r['idapplication'];?>"></span></td>
				  </tr>
	<?php		
				}
				if(isset($countrow) && $countrow==0){
					echo "<td colspan='9'><span style='color: red;'>Записи не знайдені</span></td>";
				}
			}
		}
	?>
		</table>
		
	<?php
	if(isset($countrow) && $countrow>9){
		$uslov=" WHERE tb_centr_modul.delete=''". 
					
					
					(isset($_SESSION['notdone'])?" AND tb_centr_modul.data_stop='0000-00-00'":"").
					(isset($_SESSION['done'])?" AND tb_centr_modul.data_stop!='0000-00-00'":"").
					(isset($_SESSION['datastart'])?" AND tb_centr_modul.data_add BETWEEN '".$_SESSION['datastart']."' AND '".$_SESSION['datafinish']."' ":"").
					(isset($_SESSION['dataispolstart'])?" AND tb_centr_modul.data_stop BETWEEN '".$_SESSION['dataispolstart']."' AND '".$_SESSION['dataispolfinish']."' ":"").
					(isset($_SESSION['phone_seach'])?" AND tb_abonent.phone LIKE '%".$_SESSION['phone_seach']."%' ":"").
					(isset($_SESSION['adress_search'])?" AND tb_abonent.adress LIKE '%".$_SESSION['adress_search']."%' ":"").
					(isset($_SESSION['name_abonent_seach'])?" AND tb_abonent.name_abonent LIKE '%".$_SESSION['name_abonent_seach']."%' ":"").
					(isset($_SESSION['last_name_abonent_seach'])?" AND tb_abonent.last_name_abonent LIKE '%".$_SESSION['last_name_abonent_seach']."%' ":"").
					(isset($_SESSION['number_naryd'])?" AND tb_centr_modul.id='".$_SESSION['number_naryd']."'":"").
					(isset($_SESSION['dogovor'])?" AND tb_abonent.dogovor LIKE '%".$_SESSION['dogovor']."%' ":"").
					(isset($_SESSION['summa_seach'])?" AND tb_centr_modul.summa LIKE '%".$_SESSION['summa_seach']."%' ":"");
					
		$issetpage = strrpos($_SERVER['REQUEST_URI'],'?page');
		if($issetpage===false){
			$position = strrpos($_SERVER['REQUEST_URI'],'?');
			$get = $position>0?"&".substr($_SERVER['REQUEST_URI'],$position+1):'';
		}else{
			$position = strpos($_SERVER['REQUEST_URI'],'&');
			$get=$position===false?'':substr($_SERVER['REQUEST_URI'],$position);
		}
		
		$navigation=navigation_new($onpage,$page,'tb_centr_modul',$uslov,$get);
		echo "<p align='center' style='font-size: 10pt; margin: 50px 0 80px 0;'>".$navigation."</p>";
		$query_count=mysql_query("
					SELECT 
					tb_centr_modul.*, 
					tb_centr_modul.id as idapplication, 
					tb_seller.*, 
					tb_abonent.*,
					tb_type_of_work.*,
					tb_type_of_work.id_type_of_work as idtypeofwork      
				FROM 
					tb_centr_modul 
					left join tb_seller on tb_centr_modul.id_seller=tb_seller.id_seller 
					left join tb_abonent on tb_centr_modul.id_abonent=tb_abonent.id_abonent 
					left join tb_type_of_work on tb_centr_modul.id_type_of_work=tb_type_of_work.id_type_of_work  
				WHERE
					tb_centr_modul.delete=''". 
					
					(isset($_SESSION['notdone'])?" AND tb_centr_modul.data_stop='0000-00-00'":"").
					(isset($_SESSION['done'])?" AND tb_centr_modul.data_stop!='0000-00-00'":"").
					(isset($_SESSION['datastart'])?" AND tb_centr_modul.data_add BETWEEN '".$_SESSION['datastart']."' AND '".$_SESSION['datafinish']."' ":"").
					(isset($_SESSION['dataispolstart'])?" AND tb_centr_modul.data_stop BETWEEN '".$_SESSION['dataispolstart']."' AND '".$_SESSION['dataispolfinish']."' ":"").
					(isset($_SESSION['phone_seach'])?" AND tb_abonent.phone LIKE '%".$_SESSION['phone_seach']."%' ":"").
					(isset($_SESSION['adress_search'])?" AND tb_abonent.adress LIKE '%".$_SESSION['adress_search']."%' ":"").
					(isset($_SESSION['name_abonent_seach'])?" AND tb_abonent.name_abonent LIKE '%".$_SESSION['name_abonent_seach']."%' ":"").
					(isset($_SESSION['last_name_abonent_seach'])?" AND tb_abonent.last_name_abonent LIKE '%".$_SESSION['last_name_abonent_seach']."%' ":"").
					(isset($_SESSION['number_naryd'])?" AND tb_centr_modul.id='".$_SESSION['number_naryd']."'":"").
					(isset($_SESSION['dogovor'])?" AND tb_abonent.dogovor LIKE '%".$_SESSION['dogovor']."%' ":"").
					(isset($_SESSION['summa_seach'])?" AND tb_centr_modul.summa LIKE '%".$_SESSION['summa_seach']."%' ":"")
					
					
					);
		$countrow=mysql_num_rows($query_count);
		echo "<p style='color: #999999'> Відібрано записів: ".$countrow."</p>";	
	}
@mysql_free_result();
@mysql_close();
?>

	</td>
  </tr>
</table>

</body>
</html>
















