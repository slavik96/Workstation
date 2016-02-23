<?php
session_start();

if(isset($_POST['btopen'])){
require_once("_connect.php");
	$login=addslashes(stripslashes(substr($_POST['login'],0,50)));
	$pwd=md5($_POST['pwd']);
	$rez=mysql_query("SELECT * FROM tb_seller  WHERE (login=\"$login\" AND pwd=\"$pwd\") LIMIT 1");
	$countrow=mysql_num_rows($rez);
	if($countrow>0){
		$row=mysql_fetch_array($rez);
		$_SESSION['rightsMODUL']=$row['rights'];
		$_SESSION['iduserMODUL']=$row['id_seller'];
		$_SESSION['loginMODUL']=$row['login'];
		header("Location: hi.php");		
	}else{
		$msg=' Ошибка авторизации.';
		header("Location: index.php?msg=$msg");	
	}
	@mysql_free_result($rez);
	@mysql_close();
	
}else if(isset($_GET['register'])){
	session_unset('rightsMODUL');
	session_unset('iduserMODUL');
	header("Location: index.php");
}else{
$msg=isset($_GET['msg'])?"<p class='error'><img src='img/icon/ico_error.gif' />".$_GET['msg']."</p>":"";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1251">
<title>Модуль обліку замовлень клієнтів сервісного центру</title>
<link rel="stylesheet" type="text/css" href="css.css" />
</head>

<body style="background-color:#FFFFFF">

<form method="post" action="index.php" style="margin-top:200px;">
<table width="300" height="150" border="0" cellspacing="0" cellpadding="2" align="center" >
  <tr>
    <td colspan="2" align="center" valign="bottom"><h2>Модуль обліку замовлень клієнтів сервісного центру</h2><?= $msg;?></td>
  </tr>
  <tr>
    <td width="60" align="right">Логін:</td>
    <td><input type="text" name="login" class="txt" style="width:200px;"  /></td>
  </tr>
  <tr>
    <td width="60" align="right">Пароль:</td>
    <td><input type="password" name="pwd" class="txt" style="width:200px;" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="btopen" value="Війти" class="but" /></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}
?>