<?php
require_once ("_check.php");
require_once("_connect.php");
require_once("_function.php");

$error_flag=false;
$error_name_services="";
$name_services=isset($_POST['name_services'])?htmlspecialchars(trim($_POST['name_services'])):""; 

$r_upd=isset($_GET['r_upd'])?substr($_GET['r_upd'],0,10):'';

// проверяем каждое поле на правильность заполнения

if(isset($_POST['name_services']) && $_POST['name_services']==''){
	$error_name_services='<p class="error"><img src="/img/icon/ico_error.gif" /> Поле не должно быть пустым.</p>';
	$error_flag=true;
}

// добавляем услугу, при условии, что все поля заполнены корректно
if(isset($_POST['name_services']) && $error_flag==false && $r_upd==""){
	
	mysql_query("INSERT INTO 
					tb_services (name_services)
				VALUES 
					(\"$name_services\")"
				);
	
	$idservices=mysql_insert_id();
	
	$name_services="";
}	

// выбираем одну услугу для редактирования
if(isset($_GET['idservices'])){

	$idservices=$_GET['idservices'];

	$query=mysql_query('
		SELECT 
			tb_services.*
		FROM 
			tb_services
		WHERE
			tb_services.id_services='.$idservices.' 
		LIMIT 
			1
		');

	$r=mysql_fetch_array($query);
	
	$name_services=$r['name_services'];
	$r_upd=$r['id_services'];
}

// вносим изменения в услугу
if(isset($_POST['name_services']) && $error_flag==false && $r_upd!=""){

	mysql_query("UPDATE 
					tb_services 
				 SET
					name_services=\"$name_services\"  
				 WHERE
				 	tb_services.id_services=".$r_upd."
				 LIMIT
				 	1
				 ");

		 
	$name_services="";
	$id=true;
}

// удаляем услугу полностью
if(isset($_GET['del'])){
	$iddel=$_GET['del'];
	mysql_query("DELETE FROM tb_services WHERE id_services=$iddel");
	$del_ok=true;
	@mysql_free_result();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Додати послугу</title>
<link href="css.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="js/js.js"></script>
</head>

<body style="background-color:#FFFFFF;">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="295" align="left" valign="top"><?php require_once("_menu_new.php");?></td>
    <td valign="top">
		<h1 style="color:#009966">Додання послуги</h1>
		<?php
		if(isset($id) || isset($del_ok)){
			echo "<div id_services='msg_ok'>Дія виконана вдало.</div>";
		}
		?>
		<form method="post" action="services.php<?= $r_upd>0?'?r_upd='.$r_upd:'';?>">
			
			<p class="pclass">Назва послуги:</p>
			<input type="text" name="name_services" value="<?= stripslashes($name_services);?>" class="txt" maxlength="150" />

			<?= $error_name_services;?>

			<br /><br />
			<input type="submit" value="Сохранить" />
		</form>		
		
		<div align="left" style="margin-left: 295px;">
			<a href="services.php?listservices=1">Вивести список послуг</a> <a href="services.php">Сховати</a>
		</div>
		
		<?php
			if(isset($_GET['listservices'])){
		?>
				<table width="100%" border="0" cellspacing="0" cellpadding="5">
				  <tr>
					<th>ID</th>
					<th width="500">Послуга</th>
					<th>Редагування</th>
					<th>Видалення</th>
				  </tr>
		<?php
				$query=mysql_query('
							SELECT 
								tb_services.*
							FROM 
								tb_services
							ORDER BY
								tb_services.name_services
							');
				$row=mysql_num_rows($query);
				$i=1;
				if($query){
					while ($r=mysql_fetch_array($query)){
		?>			
					  <tr <?= $i%2==0?'bgcolor="#E1E1E1"':'';?> >
						<td align="left" valign="top"><?= $r['id_services'];?></td>
						<td align="left" valign="top"><?= $r['name_services'];?></td>
						<td align="center" valign="top">
							<a href="services.php?idservices=<?= $r['id_services'];?>"><img src="img/icon/page_edit.png" title="Редагувати" border="0" /></a>
						</td>
						<td align="center" valign="top">						
							<a onclick="return confirmSubmit()" href="services.php?del=<?= $r['id_services'];?>" title="Видалити"><img src="img/icon/delete.gif" border="0" /></a>
						</td>
					  </tr>
		<?php		
					$i++;
					}
				}
				echo "</table>";				
			}
		@mysql_free_result();
		@mysql_close();
		?>

	</td>
  </tr>
</table>
</body>
</html>
