// JavaScript Document
$(function(){
	
	//计划月份
	$('#fahuoshixiao_date_dir').datepicker({
		dateFormat: "yy", 
		//monthNames: [ "一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月" ], 
		//monthNamesShort: [ "一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月" ], 
		changeYear: true,          // 年下拉菜单  
		//changeMonth: true,             // 月下拉菜单  
		//showButtonPanel: true,         // 显示按钮面板  
		//showMonthAfterYear: true,  // 月份显示在年后面 
		yearRange: "-20:+20",
		startView: 2,
		maxViewMode:2,
		minViewMode:2,
		
		onClose: function(dateText, inst) {}// 关闭事件
		  

	});
	
});