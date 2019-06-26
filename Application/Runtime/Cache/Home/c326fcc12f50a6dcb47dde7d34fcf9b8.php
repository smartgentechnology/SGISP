<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--[if IE 8]> <html lang="cn" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="cn" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="cn" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($title); ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- BEGIN GLOBAL MANDATORY STYLES -->

<link href="/SGISP/Public/media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

<link href="/SGISP/Public/media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

<link href="/SGISP/Public/media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

<link href="/SGISP/Public/media/css/style-metro.css" rel="stylesheet" type="text/css"/>

<link href="/SGISP/Public/media/css/style.css" rel="stylesheet" type="text/css"/>

<link href="/SGISP/Public/media/css/style-responsive.css" rel="stylesheet" type="text/css"/>

<link href="/SGISP/Public/media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>

<link href="/SGISP/Public/media/css/uniform.default.css" rel="stylesheet" type="text/css"/>

<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL STYLES --> 

<link href="/SGISP/Public/media/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>

<link href="/SGISP/Public/media/css/daterangepicker.css" rel="stylesheet" type="text/css" />

<link href="/SGISP/Public/media/css/fullcalendar.css" rel="stylesheet" type="text/css"/>

<link href="/SGISP/Public/media/css/jqvmap.css" rel="stylesheet" type="text/css" media="screen"/>

<link href="/SGISP/Public/media/css/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>

<link rel="stylesheet" type="text/css" href="/SGISP/Public/media/css/select2_metro.css" />

<link rel="stylesheet" href="/SGISP/Public/media/css/DT_bootstrap.css" />

<link rel="stylesheet" type="text/css" href="/SGISP/Public/media/css/jquery-ui-1.10.1.custom.min.css"/>

<link rel="stylesheet" type="text/css" href="/SGISP/Public/media/css/bootstrap-modal.css"/>

<link rel="stylesheet" type="text/css" href="/SGISP/Public/media/css/select2_metro.css" />

<link rel="stylesheet" type="text/css" href="/SGISP/Public/media/css/chosen.css" />

<!-- 摄像JS-->
<script src="/SGISP/Public/media/webcamjs/webcam.min.js"></script>




<!-- END PAGE LEVEL STYLES -->

<!--
<link rel="stylesheet" type="text/css" href="/SGISP/Public/media/css/chosen.css" />

<link rel="stylesheet" type="text/css" href="/SGISP/Public/media/css/datepicker.css" />


-->

<!--用户自定义开始-->

<link  type="text/css" rel="stylesheet" href="/SGISP/Public/media/lc/jquery/ui/smoothness/jquery-ui.css" />

<!--用户自定义结束-->

</head>

<body class="page-header-fixed">
<?php echo W('Header/top');?>


<!-- BEGIN LAYOUT--> 

	<!-- BEGIN CONTAINER -->
	
	<div class="page-container">
		
		<!-- BEGIN SIDEBAR -->

		<div class="page-sidebar nav-collapse collapse">
			
			<!-- BEGIN SIDEBAR MENU -->        
		
			<ul class="page-sidebar-menu">
		
				<li>
		
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		
					<div class="sidebar-toggler hidden-phone"></div>
		
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		
				</li>
				<li>
					<a href="<?php echo U('Workplan/index/dept/'.$company['id']);?>"> 
					
					<span class="title"><?php echo ($company['name']); ?></span>

					</a>
					
						
						<?php if(is_array($company["son"])): foreach($company["son"] as $key=>$d): if(empty($d["son"])): ?><li>
							<a href="<?php echo U('Workplan/index/dept/'.$d['id']);?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($d["name"]); ?></a>
							</li><?php endif; ?>
							
							<?php if(!empty($d["son"])): ?><li>
							<a href="<?php echo U('Workplan/index/dept/'.$d['id']);?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($d["name"]); ?></a><li/>
								<?php if(is_array($d["son"])): foreach($d["son"] as $key=>$b): ?><li>
								<a href="<?php echo U('Workplan/index/dept/'.$b['id']);?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($b["name"]); ?></a>
								</li><?php endforeach; endif; endif; endforeach; endif; ?>
					
				</li>
			</ul>
		
			<!-- END SIDEBAR MENU -->
		
		</div>
		
		<!-- END SIDEBAR -->
	
		<!-- 页面光被导航栏覆盖掉 -->
		
		<div style="margin-top:42px;">
		
		<!-- BEGIN PAGE -->
	
		<div class="page-content">
		
		<!-- BEGIN PAGE CONTAINER-->
		
			<div class="container-fluid">
			
				<br>
				
				
				<!-- BEGIN PAGE CONTENT-->
		
					<div class="row-fluid">
		
						<div class="span12">
							<div class="tabbable tabbable-custom tabbable-custom-profile">

								<ul class="nav nav-tabs">

									<li class="active"><a href="<?php echo U('Workplan/index/');?>">工作计划管理-完成率<?php echo ($successrate); ?>%</a></li>

									<li class=""><a href="<?php echo U('Zichan/index/');?>">固定资产管理</a></li>

								</ul>

								<div class="tab-content">

									<div class="tab-pane active">
		
										
					
											<div class="portlet-body">
					
												<div class="clearfix">
					
													<div class="btn-group">
														<button id="lc_workplan_add" name="<?php echo U('Workplan/add');?>"  class="btn green">
					
															 <?php echo (L("lc_add")); ?> <i class="icon-plus"></i>
					
														</button>
													</div>
													
													<div class="btn-group">
														<button id="lc_workplan_edit" name="<?php echo U('Workplan/edit');?>"  class="btn purple">
					
															 <?php echo (L("lc_edit")); ?> <i class="icon-edit"></i>
					
														</button>
													</div>
			
													<div class="btn-group">
														<button id="lc_workplan_del" name="<?php echo U('Workplan/del');?>"  class="btn black">
					
															 <?php echo (L("lc_del")); ?> <i class="icon-remove"></i>
					
														</button>
													</div>
													<div class="btn-group">
														<a id="lc_workplan_dir"  data-toggle="modal" href="#workplan_dir"  class="btn black">
					
															 <?php echo (L("lc_dir")); ?> <i class="icon-search"></i>
					
														</a>
													</div>
													<div class="btn-group">
														
														<a id="lc_workplan_export" href="<?php echo U('Workplan/exportExcel');?>"  class="btn black">
					
															 <?php echo (L("lc_export")); ?> <i class="icon-external-link"></i>
					
														</a>
														
													</div>
					
												</div>
					
												<!--添加数据层开始-->
												
												<div id="add" style="display:none;" title="添加工作计划">
												<br>
													<div class="row-fluid">
					
														<div class="span12">
									
															<!-- BEGIN VALIDATION STATES-->
									
															<div class="portlet box green">
									
																<div class="portlet-title">
									
																	<div class="caption"><i class="icon-reorder"></i>添加工作计划</div>
																	<div class="tools">
					
																		<button id="removeadd" class="btn mini black">关闭</button>
									
																	</div>
					
					
																</div>
									
																<div class="portlet-body form">
									
																	<!-- BEGIN FORM-->
									
																	<form name="<?php echo U('Workplan/add');?>" id="form_workplan_add" class="form-horizontal">
									
																		<div class="alert alert-error hide">
									
																			<button class="close" data-dismiss="alert"></button>
									
																			您输入的信息有误，请重新输入！
									
																		</div>
									
																		<div class="alert alert-success hide">
									
																			<button class="close" data-dismiss="alert"></button>
									
																			完成验证！
									
																		</div>
																		<div class="row-fluid">
																			<div class="control-group span4">
																			
																				<label class="control-label">部门<span class="required">*</span></label>
																				<div class="controls">
										
																					<select class="m-wrap" id="workplan_dept_id_a" name="workplan_dept_id_a">
																						
																							<?php if(is_array($deptinfolist)): foreach($deptinfolist as $key=>$d): ?><option value="<?php echo ($d['id']); ?>" <?php if(($_SESSION['add_workplan_dept_id']) == $d['id']): ?>selected="selected"<?php endif; ?>><?php echo ($d['name']); ?></option><?php endforeach; endif; ?>
																					</select>
																					<input type="hidden" id="change_deptid_a" name="<?php echo U('Workplan/getmanager');?>">
																					<input type="hidden" id="change_month_a" name="<?php echo U('Workplan/getnumber');?>">
																				</div>
										
																			</div>
																			<div class="control-group span4">
																				<label class="control-label">计划月份<span class="required">*</span></label>
									
																				<div class="controls">
										
																					<input type="text" id="workplan_month_a" class="m-wrap" name="workplan_month_a" data-required="1" readonly value="<?php echo (session('add_workplan_month')); ?>">
																					
										
																				</div>
																				
																			</div>
																			<div class="control-group span4">
																			
																				<label class="control-label">计划编号<span class="required">*</span></label>
									
																				<div class="controls">
										
																					<input type="text" name="workplan_number_a" id="workplan_number_a" data-required="1" class="m-wrap" value="<?php echo ($newnumber); ?>"/>
										
																				</div>
										
																			</div>
																			
																		</div>
																		<div class="row-fluid">
																			
																			<div class="control-group span4">
																				<label class="control-label">计划内容<span class="required">*</span></label>
									
																				<div class="controls">
																					<textarea name="workplan_content_a" id="workplan_content_a" data-required="1" class="m-wrap" ><?php echo (session('add_workplan_content')); ?></textarea>
										
																				</div>
																				
																			</div>
																			<div class="control-group span4">
																			
																				<label class="control-label">资源支持</label>
									
																				<div class="controls">
										
																					<input type="text" name="workplan_resource_a" id="workplan_resource_a" class="m-wrap" value="<?php echo (session('add_workplan_resource')); ?>"/>
										
																				</div>
										
																			</div>
																			<div class="control-group span4">
																			
																				<label class="control-label">计划完成时间<span class="required">*</span></label>
									
																				<div class="controls">
																					<input type="text" name="workplan_date_a" id="workplan_date_a" data-required="1" class="m-wrap" value="<?php echo (session('add_workplan_date')); ?>"/>
										
																				</div>
										
																			</div>
																		</div>
																		
																		<div class="row-fluid">
																			
																			<div class="control-group span4">
																				<label class="control-label">负责人<span class="required">*</span></label>
									
																				<div class="controls">
																					<select class="m-wrap" id="workplan_manager_id_a" name="workplan_manager_id_a">															
																						<?php if(is_array($managerlist)): foreach($managerlist as $key=>$m): ?><option value="<?php echo ($m['id']); ?>" <?php if(($_SESSION['add_workplan_manager_id']) == $m['id']): ?>selected="selected"<?php endif; ?>><?php echo ($m['name']); ?></option><?php endforeach; endif; ?>
											
																					</select>
										
																				</div>
																				
																			</div>
																			<div class="control-group span4">
																			
																				<label class="control-label">完成情况</label>
									
																				<div class="controls">
																					
																					<select class="m-wrap" id="workplan_state_a" name="workplan_state_a">															
																						<?php if(is_array($state)): foreach($state as $key=>$s): ?><option value="<?php echo ($s['id']); ?>" <?php if(($_SESSION['add_workplan_state']) == $s['id']): ?>selected="selected"<?php endif; ?>><?php echo ($s['value']); ?></option><?php endforeach; endif; ?>
											
																					</select>
										
																				</div>
										
																			</div>
																			<div class="control-group span4">
																				<label class="control-label">备注</label>
									
																				<div class="controls">
																					<input type="text" name="workplan_remarks_a" id="workplan_remarks_a" class="m-wrap" value="<?php echo (session('add_workplan_remarks')); ?>"/>
										
																				</div>
																				
																			</div>
																		</div>
																		
																		<div class="form-actions">
									
																			<button type="submit" class="btn green">添加</button>
									
																		</div>
									
																	</form>
									
																	<!-- END FORM-->
									
																</div>
									
															</div>
									
															<!-- END VALIDATION STATES-->
									
														</div>
									
													</div>
					
					
													
												</div>
												
												<!--添加数据层结束-->
												
												<!--修改数据层开始-->
												
												<div id="edit" style="display:none;" title="修改工作计划">
												<br>
													<div class="row-fluid">
					
														<div class="span12">
									
															<!-- BEGIN VALIDATION STATES-->
									
															<div class="portlet box green">
									
																<div class="portlet-title">
									
																	<div class="caption"><i class="icon-reorder"></i>修改工作计划</div>
																	<div class="tools">
					
																		<button id="removeedit" class="btn mini black">关闭</button>
									
																	</div>
					
					
																</div>
									
																<div class="portlet-body form">
									
																	<!-- BEGIN FORM-->
									
																	<form name="<?php echo U('Workplan/edit');?>" id="form_workplan_edit" class="form-horizontal">
									
																		<div class="alert alert-error hide">
									
																			<button class="close" data-dismiss="alert"></button>
									
																			您输入的信息有误，请重新输入！
									
																		</div>
									
																		<div class="alert alert-success hide">
									
																			<button class="close" data-dismiss="alert"></button>
									
																			完成验证！
									
																		</div>
																		<div class="row-fluid">
																			<div class="control-group span4">
																			
																				<label class="control-label">部门<span class="required">*</span></label>
																				<div class="controls">
										
																					<select class="m-wrap" id="workplan_dept_id_e" name="workplan_dept_id_e">
																						<?php if(is_array($deptinfolist)): foreach($deptinfolist as $key=>$d): ?><option value="<?php echo ($d['id']); ?>"><?php echo ($d['name']); ?></option><?php endforeach; endif; ?>
											
																					</select>
																					<input type="hidden" id="change_deptid_e" name="<?php echo U('Workplan/getmanager');?>">
																					<input type="hidden" id="change_month_e" name="<?php echo U('Workplan/getnumber');?>">
																				</div>
										
																			</div>
																			<div class="control-group span4">
																				<label class="control-label">计划月份<span class="required">*</span></label>
									
																				<div class="controls">
										
																					<input type="text" id="workplan_month_e" class="m-wrap" name="workplan_month_e" data-required="1" readonly>
										
																				</div>
																				
																			</div>
																			<div class="control-group span4">
																			
																				<label class="control-label">计划编号<span class="required">*</span></label>
									
																				<div class="controls">
										
																					<input type="text" name="workplan_number_e" id="workplan_number_e" data-required="1" class="span4 m-wrap"/>
										
																				</div>
										
																			</div>
																		</div>
																		<div class="row-fluid">
																			
																			<div class="control-group span4">
																				<label class="control-label">计划内容<span class="required">*</span></label>
									
																				<div class="controls">
																					<textarea name="workplan_content_e" id="workplan_content_e" data-required="1" class="m-wrap" ></textarea>
										
																				</div>
																				
																			</div>
																			<div class="control-group span4">
																			
																				<label class="control-label">资源支持</label>
									
																				<div class="controls">
										
																					<input type="text" name="workplan_resource_e" id="workplan_resource_e" class="m-wrap"/>
										
																				</div>
										
																			</div>
																			<div class="control-group span4">
																			
																				<label class="control-label">计划完成时间<span class="required">*</span></label>
									
																				<div class="controls">
																					<input type="text" name="workplan_date_e" id="workplan_date_e" data-required="1" class="m-wrap"/>
										
																				</div>
										
																			</div>
																		</div>
																		
																		<div class="row-fluid">
																			
																			<div class="control-group span4">
																				<label class="control-label">负责人<span class="required">*</span></label>
									
																				<div class="controls">
																					<select class="m-wrap" id="workplan_manager_id_e" name="workplan_manager_id_e">															
																						<?php if(is_array($managerlist)): foreach($managerlist as $key=>$m): ?><option value="<?php echo ($m['id']); ?>"><?php echo ($m['name']); ?></option><?php endforeach; endif; ?>
																						
											
																					</select>
										
																				</div>
																				
																			</div>
																			<div class="control-group span4">
																			
																				<label class="control-label">完成情况</label>
									
																				<div class="controls">
																					
																					<select class="m-wrap" id="workplan_state_e" name="workplan_state_e">													
																						<?php if(is_array($state)): foreach($state as $key=>$s): ?><option value="<?php echo ($s['id']); ?>"><?php echo ($s['value']); ?></option><?php endforeach; endif; ?>
											
																					</select>
										
																				</div>
										
																			</div>
																			<div class="control-group span4">
																				<label class="control-label">备注</label>
									
																				<div class="controls">
																					<input type="text" name="workplan_remarks_e" id="workplan_remarks_e" class="m-wrap"/>
										
																				</div>
																				
																			</div>
																		</div>
																		
																		<input type="hidden" id="workplan_id_e" name="workplan_id_e"/>
																		<div class="form-actions">
									
																			<button type="submit" class="btn green">修改</button>
									
																		</div>
									
																	</form>
									
																	<!-- END FORM-->
									
																</div>
									
															</div>
									
															<!-- END VALIDATION STATES-->
									
														</div>
									
													</div>
					
					
													
												</div>
												
												<!--修改数据层结束-->
												<!--查询条件层开始-->
												
												<div id="workplan_dir" class="modal hide fade" tabindex="-1" data-width="760">
			
													<div class="modal-header">
				
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				
														<h3>查询条件</h3>
				
													</div>
													<!--START modal-body-->
													<div class="modal-body">
				
														<div class="row-fluid">
				
															<div class="span12">
				
																<!-- BEGIN FORM-->
									
																	<form action="<?php echo U('Workplan/index');?>" method="post" id="form_workplan_dir" class="form-horizontal">
									
																		<div class="alert alert-error hide">
									
																			<button class="close" data-dismiss="alert"></button>
									
																			您输入的信息有误，请重新输入！
									
																		</div>
									
																		<div class="alert alert-success hide">
									
																			<button class="close" data-dismiss="alert"></button>
									
																			完成验证！
									
																		</div>
			
																		<div class="control-group">
									
																			<label class="control-label span5">计划日期</label>
									
																			<div class="controls span6">
									
																				<input type="text" id="workplan_month_dir_start" style="width:100px;" name="workplan_month_dir_start" readonly>&nbsp;一&nbsp;
																				<input type="text" id="workplan_month_dir_end" style="width:100px;" name="workplan_month_dir_end" readonly>
																				
									
																			</div>
									
																		</div>
																		<div class="control-group">
									
																			<label class="control-label span5">计划内容</label>
									
																			<div class="controls span7">
									
																				<input type="text" id="workplan_content_dir" class="span7 m-wrap" name="workplan_content_dir" value="<?php echo (session('workplan_content_dir')); ?>">
																				
																			</div>
									
																		</div>
																		
																		<div class="control-group">
									
																			<label class="control-label span5">完成日期</label>
									
																			<div class="controls span6">
									
																				<input type="text" id="workplan_date_dir_start" style="width:100px;" name="workplan_date_dir_start" readonly>&nbsp;一&nbsp;
																				<input type="text" id="workplan_date_dir_end" style="width:100px;" name="workplan_date_dir_end" readonly>
																				
									
																			</div>
									
																		</div>
																		<div class="control-group">
									
																			<label class="control-label span5">完成情况</label>
									
																			<div class="controls span6">
																				
																				<select class="span5 m-wrap" id="workplan_state_dir" name="workplan_state_dir">															
																					<option value="5"></option>
																					<?php if(is_array($state)): foreach($state as $key=>$s): ?><option value="<?php echo ($s['id']); ?>"><?php echo ($s['value']); ?></option><?php endforeach; endif; ?>
																					
																				</select>
									
																			</div>
									
																		</div>
																		<div class="control-group">
									
																			<label class="control-label span5">负责人</label>
									
																			<div class="controls span6">
									
																				<input type="text" id="workplan_manager_name_dir" class="span5 m-wrap" name="workplan_manager_name_dir" value="<?php echo (session('workplan_manager_name_dir')); ?>">
																				
									
																			</div>
									
																		</div>
			
																		<div class="control-group" align="center">
									
																			<button type="submit" class="btn green">查询</button>
									
																		</div>
									
																	</form>
									
																	<!-- END FORM-->
				
															</div>
				
														</div>
				
													</div><!--END modal-body-->
				
													
				
												</div>
			
												<!--查询条件层结束-->
												
												<div class="row-fluid ">
					
													<div class="span12">
													
														<!--BEGIN TABS-->
				
														<div class="tabbable tabbable-custom">
				
															<ul class="nav nav-tabs">
				
																<li><a href="<?php echo U('Workplan/index/state/0');?>">日常计划(<?php echo ($zero); ?>)</a></li>
				
																<li><a href="<?php echo U('Workplan/index/state/3');?>">持续计划(<?php echo ($three); ?>)</a></li>
																
																<li><a href="<?php echo U('Workplan/index/state/1');?>">已完成计划(<?php echo ($one); ?>)</a></li>
																
																<li><a href="<?php echo U('Workplan/index/state/2');?>">暂停或取消计划(<?php echo ($two); ?>)</a></li>
				
															</ul>
															<div style="overflow:scroll; height:700px;">
																<table class="table table-striped table-bordered table-hover" id="sample">
	
																	<thead>
									
																		<tr>
									
																			<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample .checkboxes" /></th>
									
																			<th style="width:7%;" class="hidden-480">编号</th>
																			<th style="width:34%;" class="hidden-480">计划内容</th>
																			<th style="width:7%;" class="hidden-480">资源支持</th>
																			<th style="width:7%;" class="hidden-480">完成时间</th>
																			<th style="width:7%" class="hidden-480">负责人</th>
																			<th style="width:7%" class="hidden-480">完成情况</th>
																			<th style="width:15%" class="hidden-480">备注</th>
																			<th style="width:7%" class="hidden-480">添加人</th>
																			<th style="width:7%" class="hidden-480">添加日期</th>
																		</tr>
									
																	</thead>
									
																	<tbody>
																		
																		<?php if(is_array($changelist)): foreach($changelist as $key=>$d): ?><tr class="odd gradeX" id="work<?php echo ($d['id']); ?>">
																				<td><input type="checkbox" class="checkboxes" value="<?php echo ($d['id']); ?>" /></td>
																				<td><?php echo ($d['number']); ?></td>
																				<td><?php echo ($d['content']); ?></td>
																				<td><?php echo ($d['resource']); ?></td>
																				<td><?php echo ($d['date']); ?></td>
																				<td><?php echo ($d['manager_name']); ?></td>
																				<td><?php echo ($d['state']); ?></td>
																				<td><?php echo ($d['remarks']); ?></td>
																				<td><?php echo ($d['manager_add_name']); ?></td>
																				<td><?php echo ($d['add_time']); ?></td>
																			</tr><?php endforeach; endif; ?>
									
																	</tbody>
									
																</table>
																<!--
																<div class="clearfix">
	
																	<?php echo ($page); ?>
									
																</div>
																<div class="clearfix">
																-->
																		
															</div>
																	

															</div>
				
														</div>
				
														<!--END TABS-->
								
																	
								
													</div>
								
												</div>
					
											</div>
					
										
									</div>
								</div>
		
						</div>
		
						<!-- END PAGE CONTENT-->
				
				</div>
			
				<!-- END PAGE CONTAINER--> 

			</div>
	
		<!-- END PAGE -->
		</div>
		
	</div>

	<!-- END CONTAINER -->
	
</div>

<!-- END LAYOUT-->

	
<?php echo W('Header/footer');?>
</body>
</html>