<?php
	if(!@mysql_connect('localhost','svyatoslav','chanel')){
		echo "Сталася помилка при з'єднані з базою данних";
		exit;
		//1
	}
	mysql_select_db('bd_modul');
?>
