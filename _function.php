<?php
	//---------------------------------------------------------------------------------------
	//      { }
	// $namebd -  
	// $value -  ,    value   <option>
	// $namepole -  ,       
	//---------------------------------------------------------------------------------------
function getlist($namebd,$value,$namepole,$where='where 1',$sort=1,$checked=""){
	$list='';
	$rez=mysql_query('select * from '.$namebd.' '.$where.' order by '.$sort);
	if($rez){
		while ($row=mysql_fetch_array($rez)){
			$selected=$row["$value"]==$checked?" selected='selected'":'';
			$list=$list.'<option value="'.$row["$value"].'"'.$selected.'>'.$row["$namepole"].'</option>';	
		}
		@mysql_free_result($rez);
	}
	return $list;
}



		function getlistname($namebd,$value,$namepole,$name1,$where='where 1',$sort=1,$checked=""){
$list='';
$rez=mysql_query('select * from '.$namebd.' '.$where.' order by '.$sort);
if($rez){
while ($row=mysql_fetch_array($rez)){
$selected=$row["$value"]==$checked?" selected='selected'":'';
$list=$list.'<option value="'.$row["$value"].','.$row['id_services'].'"'.$selected.'>'.$row["$namepole"]." ".$row["$name1"].'</option>';	
}
@mysql_free_result($rez); 
}
return $list;
}
	
	
	
	
	
	
	
	
	
	
	
	//---------------------------------------------------------------------------------------
	//      timestamp
	//---------------------------------------------------------------------------------------
function mktime_timestamp($d){
	$ddmmyy=explode('-',substr($d,0,10));
	$his=explode(':',substr($d,11));
	$mktime_data_add=mktime($his[0],$his[1],$his[2],$ddmmyy[1],$ddmmyy[2],$ddmmyy[0]);
	return $mktime_data_add;
}
	//---------------------------------------------------------------------------------------
	//      DD.MM.YYYY 
	//---------------------------------------------------------------------------------------
function dmy($d){
	$ddmmyy=explode('-',$d);

	$ddmmyy=$ddmmyy[2].'-'.$ddmmyy[1].'-'.$ddmmyy[0];

	return $ddmmyy;
}

	//---------------------------------------------------------------------------------------
	//      DD.MM.YYYY
	//---------------------------------------------------------------------------------------
function ddmmyyyy($d){
	$ddmmyyyy=explode('-',substr($d,0,10));
	$ddmmyyyy=$ddmmyyyy[2].'.'.$ddmmyyyy[1].'.'.$ddmmyyyy[0];
	return $ddmmyyyy;
}

// вывод страниц на сайте, задействованы две функции page() and navigation()
function page(){
    if(empty($_GET['page']) || $_GET['page'] < 0){
	$page=1;
    }else{
	if(!is_numeric($_GET['page'])) die ("Неправильный формат номера страницы!");
	$page=$_GET['page'];
    }
    return $page;
}


function navigation_new($onpage,$page,$t,$uslov,$get=''){
    $return=null;
    $count=mysql_query("select count(*) from ".$t.$uslov);
    $count=mysql_fetch_array($count);
    $count=$count[0];
	$pages=intval(($count - 1)/$onpage) + 1;
	$get=$get==''?'':$get;
    if($page!=1)
		$prev=" <a href=\"?page=".($page-1).$get."\" style='margin-right:50px; font-size: 10pt;'>Предыдущая</a>";
    if($page==1)
		$prev="<span style='margin-right:50px; font-size: 10pt;'>Предыдущая</span>";
    if($page!=$pages)
		$next="<a href=\"?page=".($page+1).$get."\" style='margin-left:50px; font-size: 10pt;'>Следующая</a> ";
    if($page==$pages)
		$next="<span style='margin-left:50px; font-size: 10pt;'>Следующая</span> ";

	if($page - 4 > 0) $page4left = '&nbsp;&nbsp;<a href= ?page='. ($page - 4).$get .'>'. ($page - 4) .'</a>&nbsp;&nbsp;'; else $page4left='';  
	if($page - 3 > 0) $page3left = '&nbsp;&nbsp;<a href= ?page='. ($page - 3).$get .'>'. ($page - 3) .'</a>&nbsp;&nbsp;'; else $page3left=''; 
	if($page - 2 > 0) $page2left = '&nbsp;&nbsp;<a href= ?page='. ($page - 2).$get .'>'. ($page - 2) .'</a>&nbsp;&nbsp;'; else $page2left=''; 
	if($page - 1 > 0) $page1left = '&nbsp;&nbsp;<a href= ?page='. ($page - 1).$get .'>'. ($page - 1) .'</a>&nbsp;&nbsp;'; else $page1left=''; 
	if($page + 4 <= $pages) $page4right = '&nbsp;&nbsp;<a href= ?page='. ($page + 4).$get .'>'. ($page + 4) .'</a>&nbsp;&nbsp;'; else $page4right='';
	if($page + 3 <= $pages) $page3right = '&nbsp;&nbsp;<a href= ?page='. ($page + 3).$get .'>'. ($page + 3) .'</a>&nbsp;&nbsp;'; else $page3right='';  
	if($page + 2 <= $pages) $page2right = '&nbsp;&nbsp;<a href= ?page='. ($page + 2).$get .'>'. ($page + 2) .'</a>&nbsp;&nbsp;'; else $page2right='';  
	if($page + 1 <= $pages) $page1right = '&nbsp;&nbsp;<a href= ?page='. ($page + 1).$get .'>'. ($page + 1) .'</a>&nbsp;&nbsp;'; else $page1right=''; 

	if($page>5) $tochkileft="..."; else $tochkileft="";
	if($page<$pages-4) $tochkiright="..."; else $tochkiright="";
	
	    return "<a href=' ?page=1".$get ."'>1</a> &nbsp;&nbsp;&nbsp;&nbsp; ".$prev.$tochkileft.$page4left.$page3left.$page2left.$page1left."<span style='color: #9bca08;'>&nbsp;&nbsp;".$page."&nbsp;&nbsp;</span>".$page1right.$page2right.$page3right.$page4right.$tochkiright.$next." &nbsp;&nbsp;&nbsp;&nbsp; <a href=' ?page=".$pages.$get ."'>".$pages."</a>";
		
}

function search($namebd,$value,$namepole,$where='where 1',$sort=1,$checked=""){
	$list='';
	$rez=mysql_query('select * from '.$namebd.' '.$where.' order by '.$sort);
	if($rez){
		while ($row=mysql_fetch_array($rez)){
			
			$list=$list.'<option value="list_application.php?idservices='.$row["$value"].'">'.$row["$namepole"].'</option>';
		
		}
		@mysql_free_result($rez);
	}
	return $list;
}
function search_type_of_work($namebd,$value,$namepole,$where='where 1',$sort=1,$checked=""){
	$list='';
	$rez=mysql_query('select * from '.$namebd.' '.$where.' order by '.$sort);
	if($rez){
		while ($row=mysql_fetch_array($rez)){
			
			$list=$list.'<option value="list_application.php?idtypeofwork='.$row["$value"].'">'.$row["$namepole"].'</option>';
		
		}
		@mysql_free_result($rez);
	}
	return $list;
}

?>