$(function(){
	var setting={
		url:'getdata.php',
		type:'GET', 
		success: function(res){
				eval("var data="+res); 
				if(data!=""){
					var str='<table style="font-size:17px;" border=1>';
					var num=0;
					for(var o in data){
						num++;
						str=str+'<tr><td colspan="2" height="80"><strong>'+num+'、公司:'+data[o].kehumingcheng+'</strong></td></tr><tr><td><strong>发货单:'+data[o].fahuodanhao+'<strong></td><td><strong>日期:'+data[o].riqi+'<strong></td></tr>';
						for(var z in data[o].chanpin){
							str=str+'<tr><td>型号:<span style="color:#FF0000">'+data[o].chanpin[z].xinghao+'</span></td><td>批次:<span style="color:#FF0000">'+data[o].chanpin[z].pici+'</span></td></tr><tr><td>数量:<span style="color:#FF0000"">'+data[o].chanpin[z].shuliang+'</span>台</td><td>软件版本号:≥<span style="color:#FF0000">'+data[o].chanpin[z].banben+'</span></td></tr>';
						}
						
					}
					str=str+'</table>';
				}else{
					var str='<center><h4>暂无拿货记录提醒！<h4/></center>';
				}
				$('#record').html(str);
				window.setTimeout(function(){$.ajax(setting)},2000);
		}
	};
	$.ajax(setting);
      
});