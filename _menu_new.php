<ul style="line-height: 35px;">
	<li><a href="add_application.php">Додати заяву</a></li>
	<li><a href="list_application.php">Список заяв</a></li>
	<li><a href="abonent.php">Додати абонента</a></li>
	<li><a href="update_pwd.php">Змінити пароль</a></li>
	<?php
	if(isset($_SESSION['rightsMODUL']) && $_SESSION['rightsMODUL']==11 && ($_SESSION['loginMODUL']=="svyatoslav" || $_SESSION['loginMODUL']=="paramey")){
	?>
	<li><a href="seller.php">Працівники</a></li>
	<li><a href="services.php">Послуги</a></li>
	<li><a href="type_of_work.php">Види робіт</a></li>
	
	<?php
	}
	?>
	
</ul>

<ul>
	<li><a href="index.php?register=1" style="color:#ff0000;">&#8658; Вихід</a></li>
</ul>

