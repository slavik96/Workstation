<?php
require_once ("_check.php");
require_once("_connect.php");
require_once("_function.php");

$error_flag=false;
$error_name_seller="";
$name_seller=isset($_POST['name_seller'])?htmlspecialchars(trim($_POST['name_seller'])):""; 
$login=isset($_POST['login'])?trim($_POST['login']):""; 
$pwd=isset($_POST['pwd'])?$_POST['pwd']:""; 
$pwd=$pwd!=""?md5($pwd):"";
$rights=isset($_POST['rights'])?substr($_POST['rights'],0,2):"";

$r_upd=isset($_GET['r_upd'])?substr($_GET['r_upd'],0,10):'';

// проверяем каждое поле на правильность заполнения

if(isset($_POST['name_seller']) && $_POST['name_seller']==''){
	$error_name_seller='<p class="error"><img src="/img/icon/ico_error.gif" /> Поле не должно быть пустым.</p>';
	$error_flag=true;
}

// добавляем услугу, при условии, что все поля заполнены корректно
if(isset($_POST['name_seller']) && $error_flag==false && $r_upd==""){
	
	mysql_query("INSERT INTO 
					tb_seller (name_seller, login, pwd, rights)
				VALUES 
					(\"$name_seller\", \"$login\", \"$pwd\", \"$rights\")"
				);
	$id_seller=mysql_insert_id();
	
	$name_seller=$pwd=$rights=$login="";
}	

// выбираем одну услугу для редактирования
if(isset($_GET['idseller'])){

	$idseller=$_GET['idseller'];

	$query=mysql_query('
		SELECT 
			tb_seller.*
		FROM 
			tb_seller
		WHERE
			tb_seller.id_seller='.$idseller.' 
		LIMIT 
			1
		');

	$r=mysql_fetch_array($query);
	
	$name_seller=$r['name_seller'];
	$login=$r['login'];
	$rights=$r['rights'];
	$r_upd=$r['id_seller'];
}

// вносим изменения в услугу
if(isset($_POST['name_seller']) && $error_flag==false && $r_upd!=""){

	mysql_query("UPDATE 
					tb_seller 
				 SET
					name_seller=\"$name_seller\",
					login=\"$login\",
					rights=\"$rights\"
					".
					($pwd!=""?", pwd='".$pwd."'":"")
					." 
				 WHERE
				 	tb_seller.id_seller=".$r_upd."
				 LIMIT
				 	1
				 ");

		 
	$name_seller=$rights=$pwd=$login="";
	$id_seller=true;
}

// удаляем услугу полностью
if(isset($_GET['del'])){
	$iddel=$_GET['del'];
	mysql_query("DELETE FROM tb_seller WHERE id_seller=$iddel");
	$del_ok=true;
	@mysql_free_result();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Додання працівника</title>
<link href="css.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="js/js.js"></script>
</head>

<body style="background-color:#FFFFFF;">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="295" align="left" valign="top"><?php require_once("_menu_new.php");?></td>
    <td valign="top">
		<h1 style="color:#009966">Додання працівника:</h1>
		<?php
		if(isset($id_seller) || isset($del_ok)){
			echo "<div id_seller='msg_ok'>Дія виконана вдало.</div>";
		}
		?>
		<form method="post" action="seller.php<?= $r_upd>0?'?r_upd='.$r_upd:'';?>">
			
			<p class="pclass">Прізвище:</p>
			<input type="text" name="name_seller" value="<?= stripslashes($name_seller);?>" class="txt" maxlength="150" />
			<?= $error_name_seller;?>

			<p class="pclass">Логін:</p>
			<input type="text" name="login" value="<?= stripslashes($login);?>" class="txt" maxlength="15" />

			<p class="pclass">Пароль:</p>
			<input type="text" name="pwd" value="<?= stripslashes($pwd);?>" class="txt" maxlength="10" />

			<p class="pclass">Права доступу:</p>
			<select name="rights" class="selclass_important">
				<option value="00" <?= $rights==00?" selected='selected'":"";?>>Обмежений доступ</option>
				<option value="11" <?= $rights==11?" selected='selected'":"";?>>Повний доступ</option>
			</select>
			

			<br /><br />
			<input type="submit" value="Сохранить" />
		</form>		
		
		<div align="left" style="margin-left: 295px;">
			<a href="seller.php?listseller=1">Вивести усіх працівників </a> <a href="seller.php">Сховати</a>
		</div>
		
		<?php
			if(isset($_GET['listseller'])){
		?>
				<table width="100%" border="0" cellspacing="0" cellpadding="5">
				  <tr>
					<th width="500">Прізвище</th>
					<th>Логін</th>
					<th>Права</th>
					<th>Редагувати</th>
					<th>Видалити</th>
				  </tr>
		<?php
				$query=mysql_query('
							SELECT 
								tb_seller.*
							FROM 
								tb_seller
							ORDER BY
								tb_seller.name_seller
							');
				$row=mysql_num_rows($query);
				$i=1;
				if($query){
					while ($r=mysql_fetch_array($query)){
		?>			
					  <tr <?= $i%2==0?'bgcolor="#E1E1E1"':'';?> >
						<td align="left" valign="top"><?= $r['name_seller'];?></td>
						<td align="left" valign="top"><?= $r['login'];?></td>
						<td align="center" valign="top"><?= $r['rights'];?></td>
						<td align="center" valign="top">
							<?php
							if($r['login']!="svyatoslav"){
							?>
								<a href="seller.php?idseller=<?= $r['id_seller'];?>"><img src="img/icon/page_edit.png" title="Редактировать" border="0" /></a>
							<?php
							}
							?>
						</td>
						<td align="center" valign="top">	
							<?php
							if($r['login']!="svyatoslav"){
							?>					
								<a onclick="return confirmSubmit()" href="seller.php?del=<?= $r['id_seller'];?>" title="Удалить"><img src="img/icon/delete.gif" border="0" /></a>
							<?php
							}
							?>
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
