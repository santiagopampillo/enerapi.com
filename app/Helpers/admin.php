<?php
use Carbon\Carbon;

function hasAccess($permission){
	$roles = explode("|",$permission);
	if (in_array(\Auth::user()->rol->name,$roles) || \Auth::user()->rol->name=='Superadmin'){
		return true;
	}else{
		return false;
	}
}


?>