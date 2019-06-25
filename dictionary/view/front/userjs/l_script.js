$(function(){
	var message=$("#message");
	  message.animate({marginTop:'30px'},"slow");
	  message.delay(20000);
	  message.hide("slow");
	//大图轮播器
	$('#myCarousel').carousel({
		interval: 3000
	});
	//轮播器
	$('#myProductprev').click(function(){
		$('#myProduct').carousel('prev');
	});
	$('#myProductnext').click(function(){
		$('#myProduct').carousel('next');
	});
	//产品比较选择
	$("input[type='checkbox']").bind("click", function(){
		//判断产品的状态，如果选择则把产品ID添加到购物车，如果取消则把产品ID从购物车中删除
		var product=$(this);
		if (product.is(':checked')) {
			var product_id=product.attr('value');
			$.ajax({
				url:'productcomparison.php',
				type:'GET',
				data:{
					act:'add',
					product_id:product_id
				},
				success: function(data){
					if(parseInt(data)===5){
						product.removeAttr("checked");
						alert('Sorry, only compare four products at a time');
					}else if(parseInt(data)===0){
						alert('Sorry, this product does not exist');
					}else if(parseInt(data)>0 && parseInt(data)<5){
						$('#badge').text(data);
					}
				}
			});
		}else{
			var product_id=product.attr('value');
			$.ajax({
				url:'productcomparison.php',
				type:'GET',
				data:{
					act:'del',
					product_id:product_id
				},
				success: function(data){
					if(parseInt(data)===5){
						alert('Sorry, this product does not exist');
					}else if(parseInt(data)>=0 && parseInt(data)<5){
						$('#badge').text(data);
					}
				}
			});
		}											   
		
	});
	//产品比较确定按钮
	$("button[name='compareproduct']").bind("click",function(){
		window.location.href="productcomparison.php?act=display";
	});
	
	//产品类型选择
	$("#category").change(function(){
		var cate_id=$(this).val();
		var series=$('select[name="series"]');
		var modules=$('select[name="module"]');
		var badge=$('#badge');
		var items=$('#items');
		if(parseInt(cate_id)!=0){
			$.ajax({
				url:'productcomparison.php',
				type:'GET',
				data:{
					act:'series',
					cate_id:cate_id
				},
				success: function(data){
					var json=eval(data);
					badge.text(0);
					var seare='<option>Please select a series</option>';
					for(var i=0; i<json.length;i++){
						seare=seare+'<option value="'+json[i].cat_id+'">'+json[i].cat_name+'</option>';
					}
					var module='<option>Please select a model</option>';
					for(var j=0; j<series.length;j++){
						series.eq(j).html(seare);
						modules.eq(j).html(module);
					}
					
					
				}
			});
			$.ajax({
				url:'productcomparison.php',
				type:'GET',
				data:{
					act:'table',
					cate_id:cate_id
				},
				success: function(data){
					var json=eval(data);
					if(parseInt(json.length)!=0){
						items.children().detach("#abc");
						for(var i=0; i<json.length;i++){
							var text='<tr id="abc" class="text-center">';
							for(var j=1;j<=4;j++){
								if(parseInt(json[i][j])==0){
									json[i][j]="";		
								}
							}
							text=text+'<td class="text-left">'+json[i][0]+'</td>'+
									 '<td>'+json[i][1]+'</td>'+
									 '<td>'+json[i][2]+'</td>'+
									 '<td>'+json[i][3]+'</td>'+
									 '<td>'+json[i][4]+'</td></tr>';
							items.append(text);
						}
						
					}else{
						items.children().detach("#abc");
					}
				}
			});	
		}else{
			location.reload();
		}
		
	});
	$("select[name='series']").bind("change",function(){
		var cate_id=$(this).val();
		var module=$(this).parent().parent().find("select[name='module']");
		if(parseInt(cate_id)!=0){
			$.ajax({
				url:'productcomparison.php',
				type:'GET',
				data:{
					act:'module',
					cate_id:cate_id
				},
				success: function(data){
					var json=eval(data);
					if(parseInt(json.length)!=0){
						var text='<option value="0">Please select a model</option>';
						for(var i=0; i<json.length;i++){
							text=text+'<option value="'+json[i].product_id+'">'+json[i].product_name+'</option>';
						}
						module.html(text);
					}else{
						var text='<option value="0">Please select a model</option>';
						module.html(text);
					}
				}
			});
		}										  
	});
	$("select[name='module']").bind("change",function(){
		var rank=$(this).attr("title");
		var module=$(this);
		var product_id=$(this).val();
		$.ajax({
				url:'productcomparison.php',
				type:'GET',
				data:{
					act:'checkcar',
					product_id:product_id
				},
				success: function(data){
					if(parseInt(data)==1){
						alert("The product already exists！");
					}else{
						window.location.href="productcomparison.php?act=items&rank="+rank+"&product_id="+product_id;
					}
				}
			});
		
	});
	
	
	//验证码
	 
	$("#tijiao").click(function (e) {
		var product_id=$("#product_id").val();
		var eval_product=$("#eval_product").val();
		var eval_impress=$("#stars1-input").val();
		var eval_quality=$("#stars2-input").val();
		var eval_service=$("#stars3-input").val();
		var eval_city=$("#eval_city").val();
		var eval_p_e=$("#eval_p_e").val();
		var captcha=$("#captcha").val();
		$.ajax({
				url:'evaluationpost.php',
				type:'POST',
				data:{
					product_id:product_id,
					eval_product:eval_product,
					eval_impress:eval_impress,
					eval_quality:eval_quality,
					eval_service:eval_service,
					eval_city:eval_city,
					eval_p_e:eval_p_e,
					captcha:captcha
				},
				success: function(data){
					if(parseInt(data)==1){
						alert("Comment success！");
						location.reload();
					}else{
						alert(data);
						location.reload();
					}
				}
		});
	});
      
});