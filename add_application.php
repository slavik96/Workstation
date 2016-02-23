<?php
require_once ("_check.php");
require_once("_connect.php");
require_once("_function.php");

$loginMODUL=$_SESSION['loginMODUL'];

$error_flag=false;


$seller=isset($_POST['seller'])?substr($_POST['seller'],0,10):"";
$abonent=isset($_POST['abonent'])?substr($_POST['abonent'],0,10):"";
$array_abonent=explode(",",$abonent);
$abonent=$array_abonent[0];
$services=$array_abonent[1];

$type_of_work=isset($_POST['type_of_work'])?substr($_POST['type_of_work'],0,10):"";
$comment=isset($_POST['comment'])?htmlspecialchars(trim($_POST['comment'])):""; 
$data_add=isset($_POST['data_add'])?substr(trim($_POST['data_add']),0,10):""; 

$computer=gethostbyaddr($_SERVER['REMOTE_ADDR']);
$summa=isset($_POST['summa'])?str_replace(",", ".", substr(trim($_POST['summa']),0,10)):""; 

$r_upd=isset($_GET['r_upd'])?"?r_upd=".substr($_GET['r_upd'],0,10):'';



// Якщо всі поля заповнені коректно додаємо заявку
if(isset($_POST['abonent']) && $error_flag==false && $r_upd==""){
	mysql_query("INSERT INTO 
					tb_centr_modul (
					id_services, 
					id_seller, 
					id_abonent,
					id_type_of_work,
					comment,
					data_add, 
					computer, 
		
					summa
					)
				VALUES 
					(\"$services\", 
					\"$seller\", 
					\"$abonent\", 
					\"$type_of_work\", 
					\"$comment\",
					\"$data_add\", 					
					\"$loginMODUL\", 
					
					\"$summa\"
					)");
	
	$id=mysql_insert_id();
		
	$services=$seller=$abonent=$type_of_work=$comment=$data_add=$computer=$summa="";
}

// видаляємо заявку повністю
if(isset($_GET['iddel'])){
	$iddel=substr($_GET['iddel'],0,10);

	mysql_query("UPDATE tb_centr_modul SET tb_centr_modul.delete='1' WHERE id=$iddel");
	$del_ok=true;
	@mysql_free_result();
}

//вибираємо заявку для редагування
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
	
	$services=$r['id_services'];
	$seller_select=$r['id_seller'];
	$abonent_select=$r['id_abonent'];
	$type_of_work_select=$r['id_type_of_work'];
	$comment=$r['comment'];
	$data_add=$r['data_add'];
	$computer=$r['summa'];
	$r_upd="?r_upd=".$r['id'];
	$summa=$r['summa'];
}

//вносимо зміни в заявку
if(isset($_POST['tip_clienta']) && $error_flag==false && $r_upd!=""){

	$r_upd=substr($_GET['r_upd'],0,10);

	mysql_query("UPDATE 
					tb_centr_modul 
				 SET
					id_services=\"$services\",
					id_seller=\"$seller\", 
			        id_abonent=\"$abonent\", 
					id_type_of_work=\"$type_of_work\",
					comment=\"$comment\",
					data_add=\"$data_add\",
					computer_edit=\"$loginMODUL\",
					summa =\"$summa\" 
				 WHERE
				 	tb_centr_modul.id=".$r_upd."
				 LIMIT
				 	1
				 ");
	$services=$seller=$abonent=$type_of_work=$comment=$data_add=$computer_edit=$summa="";
	$id=true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"  />
<title>Додати заяву</title>
<link href="css.css" rel="stylesheet" type="text/css" /> 
<link href="css/vlaCal-v2.1.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="js/js.js"></script>
<script language="javascript" type="text/javascript" src="js/mootools-1.2.1-core.js"></script>
<script language="javascript" type="text/javascript" src="js/vlaCal-v2.1.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">jQuery.noConflict();</script>
<script type="text/javascript">
	window.addEvent('domready', function() {
		new vlaDatePicker('textbox-id-finish');
		new vlaCalendar('block-element-id');
	});
</script>
</head>

<body style="background-color:#FFFFFF;">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" align="left" valign="top"><?php require_once("_menu_new.php");?></td>
    <td valign="top">
	<?php
	if(!isset($_GET['list_application'])){
	?>
		<h1 style="color:#009966">Додати заяву:</h1>
		<?php
		if(isset($id) || isset($del_ok)){
			echo "<div id='msg_ok'>Дія виконана вдало.</div>";
		}
		?>
		<form method="post" action="add_application.php<?= $r_upd;?>" enctype="multipart/form-data" name="forma">
			
			<p class="pclass">Працівник створивший заяву:</p>
			<select name="seller" class="selclass_important">
				<?php
				if($r_upd!=''){
					$select=$seller_select;
				}else{
					$select=isset($_SESSION['iduserMODUL'])?$_SESSION['iduserMODUL']:'';
				}
				
				$list=getlist("tb_seller","id_seller","name_seller","","name_seller",$select);
				echo $list;
				?>
			</select>
			
			<p class="pclass">Абонент:</p>
			<select name="abonent" class="selclass_important">
				<?php
				if($r_upd!=''){
					$select=$abonent;
				}else{
					$select=isset($_SESSION['iduserMODUL'])?$_SESSION['iduserMODUL']:'';
				}
				
				$list=getlistname("tb_abonent","id_abonent","last_name_abonent","name_abonent","","last_name_abonent",$select);
				
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
			
		
			
			
		
			<p class="pclass">Комментарі (255 символів):</p>
			<textarea name="comment" class="areatext" style="width: 355px; height: 70px;"><?= stripslashes($comment);?></textarea>
			
			
		
			<p class="pclass">Ціна за попередніми розрахунками:</p>
			<input type="text" name="summa" class="txt" style="width: 70px;" value="<?= $summa!=''?$summa:'';?>" maxlength="10" />
				

			
			
			<br /><br />
			<input type="submit" value="Зберегти" class="but" />
		</form>

	<?php		
	
		@mysql_free_result();
	}
	@mysql_close();
	?>
		</table>
	</td>
  </tr>
</table>

</body>
</html>
