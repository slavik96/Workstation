<?php


if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

	require_once("_connect.php");
	require_once("_function.php");
	$idapplication = $_REQUEST['idapplication'];
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
					tb_centr_modul.delete='' AND tb_centr_modul.id='".$idapplication."'
				LIMIT 
					1
				");
			$row=mysql_num_rows($query);
			if($query){
				while ($r=mysql_fetch_array($query)){
					$comment=$r['comment']!=''?$r['comment']:'<span style=\'color: red;\'>Відсутні</span>';
					$dogovor=$r['dogovor']!=''?$r['dogovor']:'<span style=\'color: red;\'>Інформація відсутня</span>';
					$data_dogovora=$r['data_dogovora']!='0000-00-00'?dmy($r['data_dogovora']):'<span style=\'color: red;\'>Інформація відсутня</span>';
					$computer_edit=$r['computer_edit']!=''?$r['computer_edit']:'<span style=\'color: red;\'>Інформація відсутня</span>';
					
					echo "<div style='border: 3px solid #ff7400; padding: 5px; width: 600px; position: relative;'>";
						echo "<img src=\"img/icon/close.png\" alt=\"Закрити\" style=\"position: absolute; top: -3px; left: 610px; cursor: pointer;\" title=\"Закрити\" onclick=\"clickclose('".$idapplication."')\" />";
						echo "<p><b>Коментарі:</b></p>";
						echo "<p>".$comment."</p>";
						echo "<p><b>Відповідальний за заяву:</b></p>";
						echo "<p>".$r['name_seller']."</p>";
						echo "<p><b>Номер договіру:</b></p>";
						echo "<p>".$dogovor."</p>";
						echo "<p><b>Дата договіру:</b></p>";
						echo "<p>".$data_dogovora."</p>";
						echo "<p><b>Комп'ютер з якого додали заяву:</b></p>";
						echo "<p>".$r['computer']."</p>";
						echo "<p><b>Комп'ютер з якого  заяву редагували:</b></p>";
						echo "<p>".$computer_edit."</p>";
					echo "</div>";
				}
			}
			@mysql_free_result();
			@mysql_close();
}else
    // обращение к файлу произошло не через AJAX-запрос
    //123
    echo "Ошибка запроса";
?> 
