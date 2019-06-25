
$(function(){
	
	$("#fanxiuh_barcode_e").focus();
	
	$('#fanxiuh_barcode_e').on('change', function(){
		var url=$('#form_fanxiuh_edit').attr('name');										  
		var barcode=$('#fanxiuh_barcode_e').val();
		if(barcode==''){
		}else{
			$.ajax({
				url:url,
				type:'GET',
				data:{
					barcode:barcode
				},
				success: function(msg){
					if(msg.state!='error'){
						//设置修改窗口的值
						$('#fanxiuh_receive_date_e').val(msg.data["receive_date"]);
						$('#fanxiuh_customer_e').val(msg.data['customer']);
						$('#fanxiuh_result_e').val(msg.data['result']);
						$('#fanxiuh_product_e').val(msg.data['product']);
						$('#fanxiuh_pdate_e').val(msg.data['pdate']);
						$('#fanxiuh_cishu_e').val(msg.data['cishu']);
						$('#fanxiuh_prdate_e').val(msg.data['prdate']);
						$('#fanxiuh_remark_e').val(msg.data['remark']);
						$('#fanxiuh_hv_e').val(msg.data['hv']);
						$('#fanxiuh_sv_e').val(msg.data['sv']);
						$('#fanxiuh_fault_e').val(msg.data['fault']);
						if(msg.data['qz']!=''){
							$('#ahqz').attr("href",msg.data['qz']);
							$('#imghqz').attr("src",msg.data['qz']);
						}else{
							$('#ahqz').attr("href",'');
							$('#imghqz').attr("src",'');	
						}
						if(msg.data['qb']!=''){
							$('#ahqb').attr("href",msg.data['qb']);
							$('#imghqb').attr("src",msg.data['qb']);
						}else{
							$('#ahqb').attr("href",'');
							$('#imghqb').attr("src",'');	
						}
						$('#fanxiuh_hsv_e').val(msg.data['hsv']);
						$('#fanxiuh_maint_e').val(msg.data['maint']);
						if(msg.data['hz']!=''){
							$('#ahhz').attr("href",msg.data['hz']);
							$('#imghz').attr("src",msg.data['hz']);
						}else{
							$('#ahhz').attr("href",'');
							$('#imghz').attr("src",'');	
						}
						if(msg.data['hb']!=''){
							$('#ahhb').attr("href",msg.data['hb']);
							$('#imghb').attr("src",msg.data['hb']);
						}else{
							$('#ahhb').attr("href",'');
							$('#imghb').attr("src",'');	
						}
						$('#fanxiuh_id_e').val(msg.data['id']);
						if(msg.list.length==0){
							$('#barcode_view').html("");
						}else{
							var str='<table width="100%"><tr><td>日期</td><td>型号</td><td>条码</td><td>状态</td></tr>';
							for(var i=0;i<msg.list.length;i++){
								str=str+"<tr><td>"+msg.list[i]['receive_date']+"</td><td>"+msg.list[i]['product']+"</td><td>"+msg.list[i]['barcode']+"</td><td>"+msg.list[i]['flag']+"</td></tr>";
							}
							str=str+"</table>";
							$('#barcode_view').html(str);
						}
						
						// JavaScript Document
						Webcam.set({
							width: 260,
							height: 180,
							// device capture size
							dest_width: 2592,
							dest_height: 1944,
							// final cropped size
							
							image_format: 'jpeg',
							jpeg_quality: 90
						});
						Webcam.attach( '#camera_xh' );
					}else{
						alert(msg.info);
						location.reload();
					}
					
				}
			});
		}
		
	});
	//修前正面拍摄
	$('#qzbtn').click(function(){
		// take snapshot and get image data
		Webcam.snap( function(data_uri) {
			
			$('#fanxiuh_qz_e').val(data_uri);
			$('#ahqz').attr("href",data_uri);
			$('#imghqz').attr("src",data_uri);
		} );						
	});
	//修前反面拍摄
	$('#qbbtn').click(function(){
		// take snapshot and get image data
		Webcam.snap( function(data_uri) {
							  
			$('#fanxiuh_qb_e').val(data_uri);
			$('#ahqb').attr("href",data_uri);
			$('#imghqb').attr("src",data_uri);
		} );						
	});
	//修后正面拍摄
	$('#hzbtn').click(function(){
		// take snapshot and get image data
		Webcam.snap( function(data_uri) {
			
			$('#fanxiuh_hz_e').val(data_uri);
			$('#ahhz').attr("href",data_uri);
			$('#imghz').attr("src",data_uri);
		} );						
	});
	//修后反面拍摄
	$('#hbbtn').click(function(){
		// take snapshot and get image data
		Webcam.snap( function(data_uri) {
							  
			$('#fanxiuh_hb_e').val(data_uri);
			$('#ahhb').attr("href",data_uri);
			$('#imghb').attr("src",data_uri);
		} );						
	});
	
	$('#btn_fanxiu_tijiao').click(function(){
		var url=$('#form_fanxiuh_edit').attr('name');
		var maint=$('#fanxiuh_maint_e').val();
		var hv=$('#fanxiuh_hv_e').val();
		var sv=$('#fanxiuh_sv_e').val();
		var fault=$('#fanxiuh_fault_e').val();
		var qz=$('#fanxiuh_qz_e').val();
		var qb=$('#fanxiuh_qb_e').val();
		var hz=$('#fanxiuh_hz_e').val();
		var hb=$('#fanxiuh_hb_e').val();
		var hsv=$('#fanxiuh_hsv_e').val();
		var id=$('#fanxiuh_id_e').val();
		if(id==""){
			alert("条码不能为空！");
		}else if(hv==""){
			alert("硬件版本号不能为空！");
		}else if(sv==""){
			alert("软件版本号不能为空！");
		}else if(fault==""){
			alert("故障现象不能为空！");
		}else if(hsv==""){
			alert("修后软件版本号不能为空！");
		}else if(maint==""){
			alert("维修过程不能为空！");
		}else{
			$.ajax({
				url:url,
				type:'POST',
				data:{
					maint:maint,
					hv:hv,
					sv:sv,
					fault:fault,
					qz:qz,
					qb:qb,
					hz:hz,
					hb:hb,
					hsv:hsv,
					id:id
				},
				success: function(msg){
					if(msg.state!='error'){
						alert(msg.info);
						location.reload();
					}else{
						alert(msg.info);
					}
					
				}
			});	
		}
					
	});
	
	$('#btn_fanxiu_zancun').click(function(){
		var url=$('#btn_fanxiu_zancun').attr('name');
		var maint=$('#fanxiuh_maint_e').val();
		var hv=$('#fanxiuh_hv_e').val();
		var sv=$('#fanxiuh_sv_e').val();
		var fault=$('#fanxiuh_fault_e').val();
		var qz=$('#fanxiuh_qz_e').val();
		var qb=$('#fanxiuh_qb_e').val();
		var hz=$('#fanxiuh_hz_e').val();
		var hb=$('#fanxiuh_hb_e').val();
		var hsv=$('#fanxiuh_hsv_e').val();
		var id=$('#fanxiuh_id_e').val();
		if(id==""){
			alert("条码不能为空！");
		}else if(hv==""){
			alert("硬件版本号不能为空！");
		}else if(sv==""){
			alert("软件版本号不能为空！");
		}else if(fault==""){
			alert("故障现象不能为空！");
		}else if(hsv==""){
			alert("修后软件版本号不能为空！");
		}else if(maint==""){
			alert("维修过程不能为空！");
		}else{
			$.ajax({
				url:url,
				type:'POST',
				data:{
					maint:maint,
					hv:hv,
					sv:sv,
					fault:fault,
					qz:qz,
					qb:qb,
					hz:hz,
					hb:hb,
					hsv:hsv,
					id:id
				},
				success: function(msg){
					if(msg.state!='error'){
						alert(msg.info);
						location.reload();
					}else{
						alert(msg.info);
					}
					
				}
			});	
		}
					
	});
});