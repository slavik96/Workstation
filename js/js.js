//      .
function confirmSubmit(){
	var otvet=confirm("Ви впевнені у своїх діях?");
  	return otvet;
}

function block_bg_menu(a){
	document.getElementById('menu_left_'+a).style.backgroundImage="url(/img/slice/bg_menu_left.png)";
	document.getElementById('menu_middle_'+a).style.backgroundColor="#a9acb1";
	document.getElementById('menu_right_'+a).style.backgroundImage="url(/img/slice/bg_menu_right.png)";
}

function none_bg_menu(a){
	document.getElementById('menu_left_'+a).style.backgroundImage='';
	document.getElementById('menu_middle_'+a).style.backgroundColor='';
	document.getElementById('menu_right_'+a).style.backgroundImage='';
}
// вибір даних по спискам.
function showDopInfa(w) {
	idapplication=w;
	jQuery("#showDopInfa_"+w).html('');
	jQuery("#showDopInfa_"+w).html('<img src="img/icon/loader.gif" />');
	jQuery("#showDopInfa_"+w).load("_list_dop_infa.php", { idapplication: idapplication});
}

function clickclose(w) {
	jQuery("#showDopInfa_"+w).html('');
}

function blockSdesk(){
	if(document.getElementById('idSdesk').value=='3' || document.getElementById('idSdesk').value=='14' || document.getElementById('idSdesk').value=='15' || document.getElementById('idSdesk').value=='13'){
		document.getElementById('divSdesk').style.display='block';
	}else{
		document.getElementById('divSdesk').style.display='none';
		document.forma.sdesk.value='';
	}
}