<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Dashboard</title>
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le styles -->
		<link href="<?php echo base_url()."css/bootstrap.min.css" ?>" rel="stylesheet" />
		<link href="<?php echo base_url()."css/my_style.css" ?>" rel="stylesheet" />
		<script src="<?php echo base_url()."js/jquery.min.js" ?>"> </script>
		<script src="<?php echo base_url()."js/bootstrap-dropdown.js" ?>"> </script>
		
		<script type="text/javascript">

			$(document).ready(function(){

			//$("#topbar").dropdown();

				

			});

		</script>

	</head>

	<body style="padding-top:40px;">
		<div class="topbar" id="topbar">
		  <div class="fill">
			<div class="container">
          	<?php echo anchor('welcome/index', 'iouovo', 'class="brand"'); ?>
			  <ul class="nav">
				<li class="active"><?php echo anchor('welcome/dashboard','Home');?></li>
				<li><?php echo anchor('groups/index','Groups'); ?></li>
				<li><?php echo anchor('#','Contact Us'); ?></li>
			  </ul>

			<ul class="nav secondary-nav">
            <li class="dropdown" data-dropdown="dropdown">
              <a href="#" class="dropdown-toggle"><?php echo $logged_in_email;?></a>
              <ul class="dropdown-menu">
              	<li><a href="#">Settings</a></li>
                <li class="divider"></li>
                <li><?php echo anchor('welcome/logout','Logout'); ?></li>
              </ul>
            </li>
          </ul>			
				
			  

					
				  
			  </div>
			</div>
		  </div>
		</div>
		
		<div class="container">

			<div class="content">
				<div class="page-header">
					<h1>iouovo <small>Smarter way to track contributions, payments and debts</small></h1>
				</div> <!-- end of div page-header-->
			</div> <!-- end of div content-->
			<p>This is members only area! <?php echo anchor('welcome/logout','Logout'); ?></p>
			<footer>
			<p>&copy; Middle Earth 2011</p>
			</footer>
		</div> <!-- end of div container-->
	</body>
</html>  