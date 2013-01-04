<!Doctype html>
<html lang="eng">
<head>
<link href="<?=base_url().'public/css/global.css';?>" type="text/css" rel="stylesheet" media="all">
<link href="<?=base_url().'public/css/g-buttons.css';?>" type="text/css" rel="stylesheet" media="all">
<style type="text/css">
<!--
/*Your style here*/
body{font:12px/1em 'Arial';margin:0;}
#right-nav{padding:9px;width:250px;min-height: 630px;background:rgb(22,81,142);color:#fff;}
#tme{font:bold 62px 'Arial';padding:0;margin: 0}
#dte{font:bold 22px 'Arial';padding:0;margin: 0;text-align: center}
#clock{height:100px;background: #fff;box-shadow: 0 0 5px gray;color: #000}
.inpt{width: 245px;height: 30px;border:1px solid gray;border-radius: 3px}
-->
</style>
<script type="text/javascript" src="<?=base_url()."public/js/jquery-1.8.1.js"?>"></script>
<script type="text/javascript">
var currenttime = "<?php echo date("F d, Y H:i:s", time())?>"; //PHP method of getting server date

///////////Stop editting here/////////////////////////////////

var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
var serverdate=new Date(currenttime);

function padlength(what){
var output=(what.toString().length==1)? "0"+what : what;
return output;
}

function displaytime(){
serverdate.setSeconds(serverdate.getSeconds()+1);
var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear();
var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds());
document.getElementById("dte").innerHTML=datestring;
document.getElementById("tme").innerHTML=timestring;

}
window.onload=function(){
setInterval("displaytime()", 1000);
}

//jquery section

$(document).ready(function(){
	$('#dtrloginbtn').click(function(){
		alert(1);
	});
});
</script>
</head>
<body>
<div class="container">
	<div class="wrapper">
		<div class="left">
			left
		</div>
		<div class="right" id="right-nav">
			<div id="clock">
			<h2 id="dte"></h2>
			<h1 id="tme"></h1>
			</div>
			<h1>Welcome</h1>
			<h3>Daily Time Record Login</h3>
			<p>Employee Number<br /><input type="text" name="empid" id="empid"  class="inpt"/></p>
			<p>Password <br /><input type="password" name="emppass" id="emppass" class="inpt"/></p>
			<p><a href="#" class="g-button" id="dtrloginbtn">Login</a></p>
		</div>

		<br class="clear" />
	</div>
</div>