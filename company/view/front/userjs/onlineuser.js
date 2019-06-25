// JavaScript Document
$(function(){
	var setting={
		url:'onlineuser.php',
		cache:false,
		success: function(res){
				$('.floatDqq').text("");
				eval("var data="+res); 
				if(data!=''){
					for(var i in data){
						var a;
						var nick_name=data[i].nick_name;
						if(data[i].state==1){
							$('.floatDqq').append('<li style="padding-left:0px;"><a href="client.php?receiver='+nick_name+'" target="_blank"><img src="view/front/userimage/amlogo.png" align="absmiddle"/>&nbsp;<font color="green" style="font-weight:bold;">'+nick_name+'</font></a></li>');
						}else{
							$('.floatDqq').append('<li style="padding-left:0px;"><a href="client.php?receiver='+nick_name+'"><img src="view/front/userimage/amlogo_down.png" align="absmiddle"/>&nbsp;<font color="#838281" style="font-weight:bold;">'+nick_name+'</font></a></li>');
						}
							
					}
				}
				window.setTimeout(function(){$.ajax(setting)},10000);
			}
	};
	$.ajax(setting);
});