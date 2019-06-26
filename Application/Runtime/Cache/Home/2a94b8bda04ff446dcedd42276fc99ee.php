<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<!-- BEGIN HEAD -->

<head>

	<meta charset="utf-8" />

	<title><?php echo (L("Index_title")); ?></title>

	<meta content="width=device-width, initial-scale=1.0" name="viewport" />

	<meta content="" name="description" />

	<meta content="" name="author" />

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

	<link href="/SGISP/Public/media/css/login.css" rel="stylesheet" type="text/css"/>

	<!-- END PAGE LEVEL STYLES -->


</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login">

	<!-- BEGIN LOGO -->

		<div class="logo">
	
			<img src="/SGISP/Public/media/image/logo-big.png" alt="" /> 
	
		</div>

	<!-- END LOGO -->
	
	<!-- BEGIN LOGIN -->

	<div class="content">
		
		<!-- BEGIN LOGIN FORM -->

		<form class="form-vertical login-form" method="post" action="<?php echo U('Index/login');?>">
			
			

			<h3 class="form-title text-center"><?php echo (L("Index_title")); ?></h3>
			<!--hide--> 
			<div class="alert alert-error <?php echo ($message?'':'hide'); ?>">

				<button class="close" data-dismiss="alert"></button>

				<span><?php echo ($message); ?></span>

			</div>
			
			
			<div class="control-group">

				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

				<label class="control-label visible-ie8 visible-ie9"><?php echo (L("Index_username")); ?></label>

				<div class="controls">

					<div class="input-icon left">

						<i class="icon-user"></i>

						<input class="m-wrap placeholder-no-fix" type="text" placeholder="<?php echo (L("Index_username")); ?>" name="manager_name" value="<?php if(($_SESSION['remember']) == "1"): echo (session('manager_name')); endif; ?>"/>

					</div>

				</div>

			</div>

			<div class="control-group">

				<label class="control-label visible-ie8 visible-ie9"><?php echo (L("Index_passwd")); ?></label>

				<div class="controls">

					<div class="input-icon left">

						<i class="icon-lock"></i>

						<input class="m-wrap placeholder-no-fix" type="password" placeholder="<?php echo (L("Index_passwd")); ?>" name="manager_passwd" value="<?php if(($_SESSION['remember']) == "1"): echo (session('manager_passwd')); endif; ?>"/>

					</div>

				</div>

			</div>

			<div class="form-actions">

				<label class="checkbox">

				<input type="checkbox" name="remember" value="1" <?php if(($_SESSION['remember']) == "1"): ?>checked="checked"<?php endif; ?>/> <?php echo (L("Index_remember")); ?>

				</label>

				<button type="submit" class="btn green pull-right">

				<?php echo (L("Index_login")); ?> <i class="m-icon-swapright m-icon-white"></i>

				</button>            

			</div>

		</form>

		<!-- END LOGIN FORM -->        

	</div>

	<!-- END LOGIN -->


	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

	<!-- BEGIN CORE PLUGINS -->

	<script src="/SGISP/Public/media/js/jquery-1.10.1.min.js" type="text/javascript"></script>

	<script src="/SGISP/Public/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

	<script src="/SGISP/Public/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      

	<script src="/SGISP/Public/media/js/bootstrap.min.js" type="text/javascript"></script>

	<!--[if lt IE 9]>

	<script src="/SGISP/Public/media/js/excanvas.min.js"></script>

	<script src="/SGISP/Public/media/js/respond.min.js"></script>  

	<![endif]-->   

	<script src="/SGISP/Public/media/js/jquery.slimscroll.min.js" type="text/javascript"></script>

	<script src="/SGISP/Public/media/js/jquery.blockui.min.js" type="text/javascript"></script>  

	<script src="/SGISP/Public/media/js/jquery.cookie.min.js" type="text/javascript"></script>

	<script src="/SGISP/Public/media/js/jquery.uniform.min.js" type="text/javascript" ></script>

	<!-- END CORE PLUGINS -->

	<!-- BEGIN PAGE LEVEL PLUGINS -->

	<script src="/SGISP/Public/media/js/jquery.validate.min.js" type="text/javascript"></script>

	<!-- END PAGE LEVEL PLUGINS -->

	<!-- BEGIN PAGE LEVEL SCRIPTS -->

	<script src="/SGISP/Public/media/js/app.js" type="text/javascript"></script>

	<script src="/SGISP/Public/media/js/login.js" type="text/javascript"></script>      

	<!-- END PAGE LEVEL SCRIPTS --> 

	<script>

		jQuery(document).ready(function() {     

		  App.init();

		  Login.init();

		});

	</script>

	<!-- END JAVASCRIPTS -->

</body>

<!-- END BODY -->

</html>