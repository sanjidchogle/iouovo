<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Manage Groups</title>
		<meta name="description" content="">
		<meta name="sanjid" content="">

		<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	<link href="<?php echo base_url()."css/bootstrap.min.css" ?>" rel="stylesheet" />
	<link href="<?php echo base_url()."css/my_style.css" ?>" rel="stylesheet" />
	<script src="<?php echo base_url()."js/jquery.min.js" ?>"> </script>
	<script src="<?php echo base_url()."js/bootstrap-dropdown.js" ?>"> </script>
	<script src="<?php echo base_url()."js/functions.js" ?>"> </script>

	<script type="text/javascript">
	$(document).ready(function(){
		$(".group-details").hide();
		$(".add-group-expense-form").hide();

		$(".group-tile").click(function(){
			$(".group-tile").removeClass('group-tile-selected');
			$(this).addClass('group-tile-selected');
			var groupid=$(this).attr("id").slice($(this).attr("id").lastIndexOf("_")+1);
			var group_details_id="#group_details_"+ groupid;
			var add_group_expense_form_id="#add_group_expense_form_"+ groupid;
			var member_collection_id="#member_collection_"+ groupid;

			// Logic to show/hide group info when group tile is clicked
			$(".group-details").hide();
			$(member_collection_id).show();
			$(add_group_expense_form_id).hide();
			$(group_details_id).fadeIn();

			// populate gloabal lists of editbox DOM elements.
			payment_list = getPaymentEditBox(groupid);
			share_list = getShareEditBox(groupid);
		});

		$(".show-expense-form").click(function(){

			var groupid=$(this).attr("id").slice($(this).attr("id").lastIndexOf("_")+1);
			var add_group_expense_form_id="#add_group_expense_form_"+ groupid;
			var member_collection_id="#member_collection_"+ groupid;
			$(member_collection_id).hide();
			$(add_group_expense_form_id).fadeIn();

		});

		$('.add-group-expense-form').change(function(e) {
				if( $(e.target).is('.contributions-amount') )
				{
					if (isNaN($(e.target).val()))
					{
						// alert("Please enter only numbers");
						$(e.target).focus();						
						$(e.target).select();						
						return;
					}
					else if($(e.target).val() < 0)
					{
						$(e.target).select();
						alert("Please enter only positive numbers");
						return;
					}

					var payment_total = getTotal(payment_list);
					var enabled_edit_share_count = getEnabledCount(share_list);
					var equal_share = 0;
					if(enabled_edit_share_count != 0)
					{
						equal_share = payment_total /  enabled_edit_share_count;
						if(isNaN(equal_share))
						{
							equal_share=0;
						}
					}
					distributeEqualShare(equal_share,share_list);
 
				}
    		});

    		$(".contributions-amount").focus(function(){
			    this.select();
				});
		
	
	});

	</script>




	</head>

	<body style="padding-top:40px;">

		<div class="topbar">
			<div class="fill">
				<div class="container">
					<?php echo anchor('welcome/index', 'iouovo', 'class="brand"'); ?>
					<ul class="nav">
						<li><?php echo anchor('welcome/dashboard','Home');?></li>
						<li class="active"><?php echo anchor('groups/index','Groups'); ?></li>
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

		<div class="fill-gray-backround">
			<div class="container">

					<div class="content">
						<div class="page-header">
								<h1>iouovo <small>Smarter way to track contributions, payments and debts</small><h1>
						</div>
						<div class="row">
							<div class="span3">
							<?php
            		$grav_url = "http://www.gravatar.com/avatar/".md5(strtolower(trim($logged_in_email)))."?d=mm&s=150";
            	?>
							<div class="media-grid">
								<a href="#">
									<img class="thumbnail"src="<?php echo $grav_url?>" alt="<?php echo $logged_in_email?>"/>
								</a>
							</div>
            	
							</div>
							<div class="span13 main-content">
								<div class="row">
								<div class="span5">
									<div class="secondary-pane">
										<?php
											foreach ($group_list as $group)
											{
										?>
											<div class = "group-tile" id="<?php echo "group_tile_".$group->groupid; ?>">        
												<div class="group-tile-profile-pic">
													<img src="http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=50" />
												</div>
												<div class="group-tile-content">
													<p><?php echo $group->groupname; ?></p>
													<!-- <h2><?php echo $group->groupid; ?><h2> -->
													<!-- <h2><?php echo $group->balance; ?><h2> -->
												<!-- <p>This is a group for residents of BOI Colony 2F, Middle Earth</p> -->
												</div>
											</div>
										<?php
											}
										?>

									</div>	
								</div>
								<div class="span8">
									<div class= "main-pane">
										<div class="member-collection-collection">	
											<?php
												foreach ($group_list as $group)
												{
											?>
													<div class="group-details" id = "<?php echo "group_details_".$group->groupid; ?>">
														<div class="member-collection" id = "<?php echo "member_collection_".$group->groupid; ?>">
															<?php
																foreach ($group->member_list as $member)
																{
															?>
																<div class = "member-tile" id="<?php echo "member_tile_".$group->groupid."_".$member->userid; ?>">        
																	<div class="member-tile-profile-pic">
																		<?php $grav_url = "http://www.gravatar.com/avatar/".md5(strtolower(trim($member->email)))."?d=mm&s=50"; ?>
																		<img src="<?php echo $grav_url; ?>" />
																	</div>
																	<div class="member-tile-content">
																		<p><?php echo $member->firstname; ?></p>
																		<p id="<?php echo"balance_".$group->groupid."_".$member->userid;?>">Balance: <?php echo $member->balance; ?></p>
																	</div>
																</div>
															<?php
																}
															?>

															<input type="button"	id="<?php echo "show_expense_form_".$group->groupid; ?>" value="Add Expenses" class="show-expense-form btn"/>
														</div>	<!-- member-collection ends -->

														<div class="add-group-expense-form" id = "<?php echo "add_group_expense_form_".$group->groupid; ?>">
															<?php

																$this->load->view('add_expense_form_view',$group); 
															?>	
														</div>	<!-- add-expense-form Ends -->
													</div> <!-- group-details ends -->
											<?php
												}
											?>
										</div>	<!-- member-collection-collection ends -->
									</div>
								</div>
								</div>
							</div>
							
							
							</div>
					</div>

					<footer>
							<p>&copy; Middle Earth 2011</p>
					</footer>

				</div> <!-- /container -->
		</div>
	</body>
</html>
