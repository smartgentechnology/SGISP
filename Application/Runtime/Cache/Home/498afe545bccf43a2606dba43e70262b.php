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
	
	<div class="page-container page-full-width">
		
			<!-- BEGIN PAGE -->
		
			<div class="page-content">
				<br>
				<!-- BEGIN PAGE CONTENT-->
				<div class="tiles span16">
					<?php if(is_array($mod_data)): foreach($mod_data as $key=>$a): ?><a href="<?php echo U($a['mca']);?>">
					
					<div class="tile bg-<?php echo ($a['color']); ?>">
					
						<div class="tile-body">
							<i class="<?php echo ($a['ico']); ?>"></i>
						</div>
						
						<div class="tile-object">
							<div class="name"><?php echo ($a['name']); ?></div>
						</div>

					</div>
					
					</a><?php endforeach; endif; ?>

				</div>

				<!-- END PAGE CONTENT-->

			</div>
		
			<!-- END PAGE -->
		</div>
		
	<!-- END CONTAINER -->
	
</div>

<!-- END LAYOUT-->

	
<?php echo W('Header/footer');?>
</body>
</html>