// JavaScript Document
$(function(){
	
	//通过按钮
	$('#fukuan_chaxun').click(function(){
		var fukuan = echarts.init(document.getElementById('fukuan'));
		window.onresize = fukuan.resize;
		var month=$('#workplan_month_a').val();
		var url=$('#fukuanform').attr('name');
		fukuan.showLoading();
		$.ajax({
			url:url,
			type:'POST',
			data:{
				month:month
			},
			success: function(msg){
				fukuan.clear();
				if(msg.state!='error'){
					var tian=msg.data.tian;
					var count=msg.data.count;
					fukuan.hideLoading();
					//加载数据图表
					fukuan.setOption({
						tooltip: {},
						legend: {
							data:['待付款']
						},
						toolbox: {
							show : true,
							feature : {
								saveAsImage : {show: true}
							}
						},
						xAxis: {
							type : 'value',
							axisLabel:{formatter:'{value}元'}
							
						},
						yAxis: { 
							type: 'category',
							data: tian
						},
						series: [{
							// 根据名字对应到相应的系列
							name: '待付款',
							type: 'bar',
							itemStyle: {
								normal: {
									label:{
										show:true,
										position: 'inside'
									}
								}
							},
							data: count
						}]
					});
					
				}
			}	
		});
					
	});
});