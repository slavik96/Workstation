<?php
require_once ("_check.php");
require_once("_connect.php");
require_once("_function.php");

$loginMODUL=$_SESSION['loginMODUL'];

$error_flag=false;
$img=$error_name_abonent=$error_last_name_abonent=$error_phone=$error_adress="";

$name_abonent=isset($_POST['name_abonent'])?htmlspecialchars(trim(substr($_POST['name_abonent'],0,150))):""; 
$last_name_abonent=isset($_POST['last_name_abonent'])?htmlspecialchars(trim(substr($_POST['last_name_abonent'],0,150))):""; 

$tip_clienta=isset($_POST['id_tip_clienta'])?substr($_POST['id_tip_clienta'],0,10):"";
$phone=isset($_POST['phone'])?htmlspecialchars(trim(substr($_POST['phone'],0,100))):""; 
$adress=isset($_POST['adress'])?htmlspecialchars(trim(substr($_POST['adress'],0,150))):""; 


$dogovor=isset($_POST['dogovor'])?htmlspecialchars(trim(substr($_POST['dogovor'],0,30))):""; 
$data_dogovora=isset($_POST['data_dogovora'])?substr(trim($_POST['data_dogovora']),0,10):""; 


$data_add_abonent=date('Y-m-d');

$services=isset($_POST['services'])?substr($_POST['services'],0,10):"";
$r_upd=isset($_GET['r_upd'])?"?r_upd=".substr($_GET['r_upd'],0,10):'';

// Перевіряємо правильність запоненія полів форми
if(isset($_POST['name_abonent']) && $_POST['name_abonent']==''){
	$error_name_abonent='<p class="error">Поле не повино бути порожнім.</p>';
	$error_flag=true;
}

if(isset($_POST['last_name_abonent']) && $_POST['last_name_abonent']==''){
	$error_last_name_abonent='<p class="error">Поле не повино бути порожнім.</p>';
	$error_flag=true;
}



if(isset($_POST['phone']) && $_POST['phone']==''){
	$error_phone='<p class="error">Поле не повино бути порожнім.</p>';
	$error_flag=true;
}

if(isset($_POST['adress']) && $_POST['adress']==''){
	$error_adress='<p class="error">Поле не повино бути порожнім.</p>';
	$error_flag=true;
}

if(isset($_POST['dogovor']) && $_POST['dogovor']==''){
	$error_adress='<p class="error">Поле не повино бути порожнім.</p>';
	$error_flag=true;
}


// Якщо всі поля заповнені коректно додаємо заявку
if(isset($_POST['tip_clienta']) && $error_flag==false && $r_upd==""){
	mysql_query("INSERT INTO 
					tb_abonent ( name_abonent, last_name_abonent, id_tip_clienta, phone, adress, dogovor, data_dogovora, data_add_abonent, id_services )
				VALUES 
					(\"$name_abonent\", \"$last_name_abonent\", \"$tip_clienta\", \"$phone\", \"$adress\", \"$dogovor\", \"$data_dogovora\", \"$data_add_abonent\",\"$services\")");
	$id=mysql_insert_id();
	
	
	
		$name_abonent=$last_name_abonent=$tip_clienta=$phone=$adress=$dogovor=$data_dogovora=$data_add_abonent=$services="";
}

// Видаляємо абонента повністю

if(isset($_GET['del'])){
	$iddel=$_GET['del'];
	mysql_query("DELETE FROM tb_abonent WHERE id_abonent=$iddel");
	$del_ok=true;
	@mysql_free_result();
}




// ОБИРАЄМО абонента для редагування
if(isset($_GET['id_abonent'])){
	$id=substr($_GET['id_abonent'],0,10);
	$query=mysql_query('
		SELECT 
			tb_abonent.*
		FROM 
			tb_abonent
		WHERE
			tb_abonent.id_abonent='.$id.'
		LIMIT 
			1
');
	
	$r=mysql_fetch_array($query);
	
	$abonent=$r['id_abonent'];

	$name_abonent=$r['name_abonent'];
	$last_name_abonent=$r['last_name_abonent'];
	$tip_clienta=$r['id_tip_clienta'];
	$phone=$r['phone'];
	$adress=$r['adress'];
	$dogovor=$r['dogovor'];
	$data_dogovora=$r['data_dogovora'];
	$data_add_abonent=$r['data_add_abonent'];
	$services=$r['id_services'];
	$r_upd="?r_upd=".$r['id_abonent'];
	
}

//Вносимо зміни в заявку
if(isset($_POST['tip_clienta']) && $error_flag==false && $r_upd!=""){

	$r_upd=substr($_GET['r_upd'],0,10);

	mysql_query
	("UPDATE 
				tb_abonent
				 SET
					name_abonent=\"$name_abonent\", 
					last_name_abonent=\"$last_name_abonent\", 
					id_tip_clienta=\"$tip_clienta\", 
					phone=\"$phone\", 
					adress=\"$adress\", 
					dogovor=\"$dogovor\",
					data_dogovora=\"$data_dogovora\",
					data_add_abonent=\"$data_add_abonent\",
					id_services=\"$services\"
				 WHERE
				 	tb_abonent.id_abonent=".$r_upd."
				 LIMIT
				 	1
				 ");
	$name_abonent=$last_name_abonent=$tip_clienta=$phone=$adress=$dogovor=$data_dogovora=$data_add_abonent=$services="";
	$id=true;

	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"  />
<title>Додання абонента</title>
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
		<h1 style="color:#009966">Додати Абонента:</h1>
		<?php
		if(isset($id) || isset($del_ok)){
			echo "<div id_abonent='msg_ok'>Действие выполнено вдало.</div>";
		}
		?>
		<form method="post" action="abonent.php<?= $r_upd;?>" enctype="multipart/form-data" name="forma">
			
			
			<p class="pclass">Ім'я абонента:</p>
			<input type="text" name="name_abonent" value="<?= stripslashes($name_abonent);?>" pattern "[А-яа-я]" class="txt_important" maxlength="150" />
			<?= $error_name_abonent;?>
			
			<p class="pclass">Прізвище абонента:</p>
			<input type="text" name="last_name_abonent" value="<?= stripslashes($last_name_abonent);?>" class="txt_important" maxlength="150" />
			<?= $error_last_name_abonent;?>
			
			
			<p class="pclass">Тип абонента:</p>
			<select name="tip_clienta" class="selclass_important">
				<option value="1" <?= $tip_clienta==1?" selected='selected'":"";?>>Фізичне обличча</option>
				<option value="2" <?= $tip_clienta==2?" selected='selected'":"";?>>Юридичне обличча</option>
			</select>
			
			
			<p class="pclass">Телефон:</p>
			<input type="text" name="phone" value="<?= stripslashes($phone);?>" class="txt_important" maxlength="100" />
			<?= $error_phone;?>

					
			
			
			<p class="pclass">Адреса абонента:</p>
			<input type="text" name="adress" value="<?= stripslashes($adress);?>" class="txt_important" maxlength="150" />
			<?= $error_adress;?>

			

			<p class="pclass">Номер договіру:</p>
				<input type="text" name="dogovor" value="<?= stripslashes($dogovor);?>" class="txt" maxlength="30" />

			<p class="pclass">Дата договіру:</p>
			<input type="text" name="data_dogovora" class="txt" style="width: 70px;" id="textbox-id-finish" value="<?= $data_dogovora!=''?$data_dogovora:'';?>" maxlength="10" />
			
			<p class="pclass">Дата додання абонента:</p>
			<input type="text" name="data_add_abonent" class="txt" style="width: 70px;" id="textbox-id-finish" value="<?= $data_add_abonent!=''?$data_add_abonent:'';?>" maxlength="10" />
			
			
				<p class="pclass">Послуга:</p>
			<select name="services" class="selclass_important">
				<?php
				$list=getlist("tb_services","id_services","name_services","","name_services",isset($services)?"$services":"");
				echo $list;
				?>
			</select>
			
			
			
			<br /><br />
			<input type="submit" value="Зберегти" class="but" />
		</form>
		
		<div align="left" style="margin-left: 295px;">
		<a href="abonent.php?listseller=1">Вивести усіх абонентів  </a> <a href="abonent.php">Сховати</a>
		</div>
	<?php
	}
	if(isset($_GET['listseller'])){
	?>
		<table width="100%" border="0" cellspacing="5" cellpadding="5" style="font-size:9pt;">
		  <tr>
		  	<th>Ім'я абонента</th>
			<th>Прізвище абонента</th>
			<th>Телефон</th>
		  	<th>Адрес</th>
			<th>Договор</th>
			<th>Дата додання договіру</th>
			<th>Дата додання абонента</th>
			<th>Послуга</th>
			<th>Тип клієнта</th>

				<th width="30">Edit</th>
			<th width="30">DEL</th>
		  </tr>
			<?php
			$query=mysql_query("
				SELECT 
					tb_abonent.*, 
					tb_abonent.id_abonent as id_abonent, 
					tb_services.* 
				FROM 
					tb_abonent 
					left join tb_services on tb_abonent.id_services=tb_services.id_services 
				WHERE
					1
				ORDER BY
					tb_abonent.id_abonent desc
				
			");
			
		$row=mysql_num_rows($query);
			if($query){
				while ($r=mysql_fetch_array($query)){
			?>			
				  <tr>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['name_abonent'];?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['last_name_abonent'];?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['phone'];?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['adress'];?></td>
					<td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['dogovor'];?></td>
					<td align="right" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= dmy($r['data_dogovora']);?></td>
					<td align="right" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= dmy($r['data_add_abonent']);?></td>
                    <td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?= $r['name_services'];?></td>
					    
					  <td align="left" valign="top" style="border-bottom:1px solid #CCCCCC;"><?php 
					  if ( $r['id_tip_clienta']==1  )
echo "Фізичне обличча";
else
echo "Юридичне  обличча";
	  ?>
	  </td>
		
			
			</select>
					<?php
					
					if((isset($_SESSION['rightsMODUL']) && $_SESSION['rightsMODUL']==11) || (isset($_SESSION['rightsMODUL']) && $_SESSION['iduserMODUL']==$r['id_seller'])){
					?>
					
				<td align="center" style="border-bottom:1px solid #CCCCCC;">
							<a href="abonent.php?id_abonent=<?= $r['id_abonent'];?>"><img src="img/icon/page_edit.png" title="Редагувати" border="0" /></a>
						</td>
					
					
						<td align="center" valign="top">						
							<a onclick="return confirmSubmit()" href="abonent.php?del=<?= $r['id_abonent'];?>" title="Видалити"><img src="img/icon/delete.gif" border="0" /></a>
						</td>

					<?php
					}else{
					?>
						<td colspan="2" align="center" style="border-bottom:1px solid #CCCCCC;"><span style="color: #999999;">Користувачеві обмежені права доступу</span></td>
					<?php
					}
					?>

				  </tr>
	<?php		
				}
			}
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
