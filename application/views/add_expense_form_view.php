<!-- We'll get $groupid,
						$groupname,
						$category_list
							categoryname , description
						$member_list
							userid','balance','firstname','email' -->

<?php 
	$attributes = array('class' => 'group-contribution-form', 'id' => 'group_contribution_form_'.$groupid);
	 // echo form_open('',$attributes); 
	// echo "<form>"; // replace this line with above line for form open if action attribute is required
	// action attribute may not be required since php script may be called from ajax
?>
	<form id="<?php echo 'group_contribution_form_'.$groupid?>">
		<input type="hidden" id="groupid" name="groupid" value="<?php echo $groupid;?>" />
	<div class="row">
		<div id="<?php echo "add_expense_contributions_".$groupid; ?>" class="span4" >
			<fieldset>
		  	<legend>Payments</legend>
		  	<span class="help-block">
					How much everyone paid for this expense?
				</span>
				<?php
					foreach($member_list as $member)
					{
						$lbl_id='contributions_lbl_'.$groupid."_".$member->userid;
						$txt_id='contributions_txt_'.$groupid."_".$member->userid;
						$txt_class='contributions-amount-'.$groupid;
					?>
					<div class = "contributor-tile" id="<?php echo "contributor_tile_".$groupid."_".$member->userid; ?>">	
					<div class="contributor-tile-profile-pic">
						<?php $grav_url = "http://www.gravatar.com/avatar/".md5(strtolower(trim($member->email)))."?d=mm&s=50"; ?>
							<img src="<?php echo $grav_url; ?>" />
						</div>
						<div class="contributor-tile-content">
							<p id="<?php echo $lbl_id;?>" class="contributions-label">
								<?php echo $member->firstname;?> 
							</p>
							<input type="text" id="<?php echo $txt_id;?>" value="0" name="<?php echo $txt_id;?>" class="<?php echo $txt_class;?> contributions-amount" />
						</div>
					</div>	
				<?php
					}
				?>
			</fieldset>
	  </div>
	  
	  <div id="<?php echo "add_expense_shares_".$groupid; ?>" class="span4" >
			<fieldset>
		  	<legend>Shares</legend>
		  	<span class="help-block">
					What was everyone's share in this expense?
				</span>
				<?php
					foreach($member_list as $member)
					{
						$lbl_id='shares_lbl_'.$groupid."_".$member->userid;
						$txt_id='shares_txt_'.$groupid."_".$member->userid;
						$txt_class='shares-amount-'.$groupid;
					?>
					<div class = "sharer-tile" id="<?php echo "sharer_tile_".$groupid."_".$member->userid; ?>">	
					<div class="sharer-tile-profile-pic">
						<?php $grav_url = "http://www.gravatar.com/avatar/".md5(strtolower(trim($member->email)))."?d=mm&s=50"; ?>
							<img src="<?php echo $grav_url; ?>" />
						</div>
						<div class="sharer-tile-content">
							<p id="<?php echo $lbl_id;?>" class="shares-label">
								<?php echo $member->firstname;?> 
							</p>
							<input type="text" id="<?php echo $txt_id;?>" value="0" name="<?php echo $txt_id;?>" class="<?php echo $txt_class;?> shares-amount" />
						</div>
					</div>	
				<?php
					}
				?>
			</fieldset>
	  </div>
	  
	  
	 </div>	  <!-- row -->
	 <div class="row"> <!-- row for category select-->
	 	<div class="span8">
		 	<select id="categoryselect" name="categoryselect">
				<?php
					foreach($category_list as $category)
					{
						echo "<option>$category->categoryname</option>";
					}
				?>
			</select>
			<span class="help-block">
				Select a suitable category for this expense.
			</span>
		</div>
	 	</div> <!-- row for category select-->
	 	<div class="row">
	 		<div class="span8">
	 			<textarea class="span8" id="description" name="description" rows="3"></textarea>
	 			<span class="help-block">
	 				Enter description or calulations for this expense so that you can refer it later.
	 			</span>
	 		</div>
	 	</div>

	 <div class="row">	
	  	<div class="span8">
	  		<!-- <button type="submit" value="Add Expense" class="btn">Add Expense</button> -->
	  		<input type="button" onclick="javascript:addContribution(<?php echo $groupid;?>);" value="Add Expense" class="btn" />
	  	</div>
	  </div>
 
</form>
					

