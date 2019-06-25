$(function(){
	var message=$("#message");
	  message.animate({marginTop:'30px'},"slow");
	  message.delay(20000);
	  message.hide("slow");
	//大图轮播器
	$('#myCarousel').carousel({
		interval: 3000
	});
	//产品轮播器
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
						alert('对不起，一次只能比较四个产品');
					}else if(parseInt(data)===0){
						alert('对不起，该产品不存在');
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
						alert('对不起，该产品不存在');
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
	//品牌按钮
	$("#pinpaibtn").bind("click",function(){
		var pinpai=$.cookie('pinpaiflg');
		if(pinpai=='asc'){
			$.cookie('pinpaiflg','desc'); 
		}else{
			$.cookie('pinpaiflg','asc');	
		}
		location.reload();
	});
	//SPN按钮
	$("#SPNbtn").bind("click",function(){
		var spn=$.cookie('spnflg');
		if(spn=='asc'){
			$.cookie('spnflg','desc'); 
		}else{
			$.cookie('spnflg','asc');	
		}
		location.reload();
	});
	//FMI按钮
	$("#FMIbtn").bind("click",function(){
		var fmi=$.cookie('fmiflg');
		if(fmi=='asc'){
			$.cookie('fmiflg','desc'); 
		}else{
			$.cookie('fmiflg','asc');	
		}
		location.reload();
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
					var seare='<option>请选择系列</option>';
					for(var i=0; i<json.length;i++){
						seare=seare+'<option value="'+json[i].cat_id+'">'+json[i].cat_name+'</option>';
					}
					var module='<option>请选择型号</option>';
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
						var text='<option value="0">请选择型号</option>';
						for(var i=0; i<json.length;i++){
							text=text+'<option value="'+json[i].product_id+'">'+json[i].product_name+'</option>';
						}
						module.html(text);
					}else{
						var text='<option value="0">请选择型号</option>';
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
						alert("该产品已存在！");
					}else{
						window.location.href="productcomparison.php?act=items&rank="+rank+"&product_id="+product_id;
					}
				}
			});
		
	});
	
	
	//验证码
	 var handlerEmbed = function (captchaObj) {
        $("#tijiao").click(function (e) {
            var validate = captchaObj.getValidate();
            if (!validate) {
                $("#notice")[0].className = "show";
                setTimeout(function () {
                    $("#notice")[0].className = "hide";
                }, 2000);
                e.preventDefault();
            }
			$.ajax({
                url: "lib/geetest/web/VerifyLoginServlet.php", // 进行二次验证
                type: "post",
                dataType: "json",
                data: {
                    type: "pc",
                    geetest_challenge: validate.geetest_challenge,
                    geetest_validate: validate.geetest_validate,
                    geetest_seccode: validate.geetest_seccode
                },
                success: function (data) {
                    if (data && (data.status === "success")) {
						var product_id=$("#product_id").val();
						var eval_product=$("#eval_product").val();
						var eval_impress=$("#stars1-input").val();
						var eval_quality=$("#stars2-input").val();
						var eval_service=$("#stars3-input").val();
						var eval_city=$("#eval_city").val();
						var eval_p_e=$("#eval_p_e").val();
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
									eval_p_e:eval_p_e
								},
								success: function(data){
									if(parseInt(data)==1){
										alert("评论成功！");
										location.reload();
									}else{
										alert(data);
										location.reload();
									}
								}
						});
                    } 
                }
            });
        });
        // 将验证码加到id为captcha的元素里，同时会有三个input的值：geetest_challenge, geetest_validate, geetest_seccode
        captchaObj.appendTo("#embed-captcha");
        captchaObj.onReady(function () {
            $("#wait")[0].className = "hide";
        });
        // 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
    };
    $.ajax({
        // 获取id，challenge，success（是否启用failback）
        url: "lib/geetest/web/StartCaptchaServlet.php?type=pc&t=" + (new Date()).getTime(), // 加随机数防止缓存
        type: "get",
        dataType: "json",
        success: function (data) {
            // 使用initGeetest接口
            // 参数1：配置参数
            // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
            initGeetest({
                gt: data.gt,
                challenge: data.challenge,
                product: "embed", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
                offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
                // 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
            }, handlerEmbed);
        }
    });
});