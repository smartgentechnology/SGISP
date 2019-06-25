// JavaScript Document
$(function(){
	
	//通过按钮
	$('#qiankuan_chaxun').click(function(){
		var qiankuan = echarts.init(document.getElementById('qiankuan'));
		window.onresize = qiankuan.resize;
		var month=$('#workplan_month_a').val();
		var url=$('#qiankuanform').attr('name');
		qiankuan.showLoading();
		$.ajax({
			url:url,
			type:'POST',
			data:{
				month:month
			},
			success: function(msg){
				qiankuan.clear();
				if(msg.state!='error'){
					var tian=msg.data.tian;
					var count=msg.data.count;
					qiankuan.hideLoading();
					//加载数据图表
					qiankuan.setOption({
						tooltip: {},
						legend: {
							data:['客户欠款']
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
							name: '客户欠款',
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