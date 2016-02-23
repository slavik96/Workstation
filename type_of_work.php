<?php
require_once ("_check.php");
require_once("_connect.php");
require_once("_function.php");

$error_flag=false;
$error_name_type_of_work="";
$name_type_of_work=isset($_POST['name_type_of_work'])?htmlspecialchars(trim($_POST['name_type_of_work'])):""; 

$r_upd=isset($_GET['r_upd'])?substr($_GET['r_upd'],0,10):'';

// перевіряємо кожне поле на правильність заповнення

if(isset($_POST['name_type_of_work']) && $_POST['name_type_of_work']==''){
	$error_name_type_of_work='<p class="error"><img src="/img/icon/ico_error.gif" /> Поле не повино бути порожнім.</p>';
	$error_flag=true;
}

// додаємо послугу, за умови, що всі поля заповнені коректно
if(isset($_POST['name_type_of_work']) && $error_flag==false && $r_upd==""){
	
	mysql_query("INSERT INTO 
					tb_type_of_work (name_type_of_work)
				VALUES 
					(\"$name_type_of_work\")"
				);
	
	$id_type_of_work=mysql_insert_id();
	
	$name_type_of_work="";
}	

// Обираємо одну послугу для редагування
if(isset($_GET['idtype_of_work'])){

	$idtype_of_work=$_GET['idtype_of_work'];

	$query=mysql_query('
		SELECT 
			tb_type_of_work.*
		FROM 
			tb_type_of_work
		WHERE
			tb_type_of_work.id_type_of_work='.$idtype_of_work.' 
		LIMIT 
			1
		');

	$r=mysql_fetch_array($query);
	
	$name_type_of_work=$r['name_type_of_work'];
	$r_upd=$r['id_type_of_work'];
}

// вносимо зміни послуги
if(isset($_POST['name_type_of_work']) && $error_flag==false && $r_upd!=""){

	mysql_query("UPDATE 
					tb_type_of_work 
				 SET
					name_type_of_work=\"$name_type_of_work\"  
				 WHERE
				 	tb_type_of_work.id_type_of_work=".$r_upd."
				 LIMIT
				 	1
				 ");

		 
	$name_type_of_work="";
	$id=true;
}

// Видаляємо послугу повністю
if(isset($_GET['del'])){
	$id_type_of_workdel=$_GET['del'];
	mysql_query("DELETE FROM tb_type_of_work WHERE id_type_of_work=$id_type_of_workdel");
	$del_ok=true;
	@mysql_free_result();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Довідник видів робіт</title>
<link href="css.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="js/js.js"></script>
</head>

<body style="background-color:#FFFFFF;">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="295" align="left" valign="top"><?php require_once("_menu_new.php");?></td>
    <td valign="top">
		<h1 style="color:#009966">Додати вид роботи:</h1>
		<?php
		if(isset($id_type_of_work) || isset($del_ok)){
			echo "<div id_type_of_work='msg_ok'>Действие выполнено успешно.</div>";
		}
		?>
		<form method="post" action="type_of_work.php<?= $r_upd>0?'?r_upd='.$r_upd:'';?>">
			
			<p class="pclass">Найменування:</p>
			<input type="text" name="name_type_of_work" value="<?= stripslashes($name_type_of_work);?>" class="txt" maxlength="30" />

			<?= $error_name_type_of_work;?>

			<br /><br />
			<input type="submit" value="Зберегти" />
		</form>		
		
		<div align="left" style="margin-left: 295px;">
			<a href="type_of_work.php?listtype_of_work=1">Вивести види робіт</a> <a href="type_of_work.php">Сховати</a>
		</div>
		
		<?php
			if(isset($_GET['listtype_of_work'])){
		?>
				<table width="100%" border="0" cellspacing="0" cellpadding="5">
				  <tr>
				  	<th>ID</th>
					<th width="500">Вид робіт</th>
					<th>Редагувати</th>
					<th>Видалити</th>
				  </tr>
		<?php
				$query=mysql_query('
							SELECT 
								tb_type_of_work.*
							FROM 
								tb_type_of_work
							ORDER BY
								tb_type_of_work.name_type_of_work
							');
				$row=mysql_num_rows($query);
				$i=1;
				if($query){
					while ($r=mysql_fetch_array($query)){
		?>			
					  <tr <?= $i%2==0?'bgcolor="#E1E1E1"':'';?> >
						<td align="left" valign="top"><?= $r['id_type_of_work'];?></td>
						<td align="left" valign="top"><?= $r['name_type_of_work'];?></td>
						<td align="center" valign="top">
							<a href="type_of_work.php?idtype_of_work=<?= $r['id_type_of_work'];?>"><img src="img/icon/page_edit.png" title="Редагувати" border="0" /></a>
						</td>
						<td align="center" valign="top">						
							<a onclick="return confirmSubmit()" href="type_of_work.php?del=<?= $r['id_type_of_work'];?>" title="Видалити"><img src="img/icon/delete.gif" border="0" /></a>
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
