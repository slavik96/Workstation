<?php
require_once ("_check.php");
require_once("_connect.php");
require_once("_function.php");

$pwd=isset($_POST['pwd'])?$_POST['pwd']:""; 
$pwd=$pwd!=""?md5($pwd):"";

// змінюємо пароль
if(isset($_POST['pwd']) && $pwd!=""){

	mysql_query("UPDATE 
					tb_seller 
				 SET
					pwd='".$pwd."'
				 WHERE
				 	tb_seller.id=".$_SESSION['iduserMODUL']."
				 LIMIT
				 	1
				 ");

		 
	$pwd="";
	$id=true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Зміна паролю</title>
<link href="css.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="js/js.js"></script>
</head>

<body style="background-color:#FFFFFF;">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="295" align="left" valign="top"><?php require_once("_menu_new.php");?></td>
    <td valign="top">
		<h1 style="color:#009966">Зміна паролю:</h1>
		<?php
		if(isset($id) || isset($del_ok)){
			echo "<div id='msg_ok'>Действие выполнено успешно.</div>";
		}
		?>
		<form method="post" action="update_pwd.php">
			
			<p class="pclass">Пароль:</p>
			<input type="text" name="pwd" value="" class="txt" maxlength="10" />

			<br /><br />
			<input type="submit" value="Зберегти" />
		</form>		
<?php
	@mysql_free_result();
	@mysql_close();
?>

	</td>
  </tr>
</table>
</body>
</html>
