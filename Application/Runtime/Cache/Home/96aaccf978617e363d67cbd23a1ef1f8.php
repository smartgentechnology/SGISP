<?php if (!defined('THINK_PATH')) exit();?><!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">

	<!-- BEGIN TOP NAVIGATION BAR -->

	<div class="navbar-inner">

		<div class="container-fluid">

			<!-- BEGIN LOGO -->

			<a class="brand" href="<?php echo U('Main/index');?>">

			<img src="/SGISP/Public/media/lc/image/logo.png" alt="logo"/>

			</a>

			<!-- END LOGO -->
			
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->

				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target="#example-navbar-collapse">

				<img src="/SGISP/Public/media/image/menu-toggler.png" alt="" />

				</a>
			<!-- END RESPONSIVE MENU TOGGLER -->
				
			<!-- BEGIN HORIZANTAL MENU -->

			<div class="navbar hor-menu hidden-phone hidden-tablet">

				<div class="navbar-inner">

					<ul class="nav">
					
						<?php if(is_array($nav_data)): foreach($nav_data as $key=>$a): if(empty($a['_data'])): ?><li>
				
									<a href="<?php echo U($a['mca'].'/id/'.$a['id']);?>">
						
									<i class="<?php echo ($a['ico']); ?>"></i> 
						
									<span class="title"><?php echo ($a['name']); ?></span>
						
									</a>
						
								</li><?php endif; endforeach; endif; ?>
						

					</ul>

				</div>

			</div>

			<!-- END HORIZANTAL MENU -->           

		</div>
		
		

	</div>
	
	

	<!-- END TOP NAVIGATION BAR -->

</div>
<!-- END HEADER -->

<div class="page-container">

	<div class="page-sidebar collapse navbar-collapse visible-phone visible-tablet" id="example-navbar-collapse">
			
		<ul class="page-sidebar-menu">
		
			<?php if(is_array($nav_data)): foreach($nav_data as $key=>$a): if(empty($a['_data'])): ?><li>
					
						<a href="<?php echo U($a['mca'].'/id/'.$a['id']);?>">
							
							<i class="<?php echo ($a['ico']); ?>"></i> 
							
							<span class="title"><?php echo ($a['name']); ?></span>
						
						</a>
					
					</li><?php endif; endforeach; endif; ?>
		
		</ul>
	
	</div>
	
</div>