// JavaScript Document

// Global variables for list of edit box DOM elements for currently selected Group.
// Will be populated and refreshed each time when group tile is clicked.
var payment_list = null;
var share_list = null;

function addContribution(groupId){
	alert("addContribution"+groupId);
	var validation_result = validate_addentry(groupId);
	// validation_result = 1 No tally errors, No type errors
	// validation_result = -1 Type errors found in one or mode editboxes. Expected numberical value
	// validation_result = -2 Tally errors found. Expected total payment should equal total shares
	switch(validation_result){
		case 1:
			
			$.ajax({
				type: 'POST',
				url: 'add_expense',
				data: $("#group_contribution_form_"+groupId).serialize(),
				dataType: 'json',
				success: function(result){
					var len=result.length;
					for(var i=0;i<len;i++)
					{
						var balance_id="#balance_"+groupId+"_"+result[i].userid;
						$(balance_id).text("Balance: "+result[i].balance);
					}
					alert("Expense added");
				}
				
			});

			break;
		case -1:
			alert("Enter expenses as positive numbers only");
			break;
		case -2:
			alert("Total does not matches");
			break;
		default:
			alert("Unknown error");

	}	

}


// validation_result = 1 No tally errors, No type errors
// validation_result = -1 Type errors found in one or mode editboxes. Expected positive numberical value
// validation_result = -2 Tally errors found. Expected total payment should equal total shares
// Called by: addContribution(groupId)
function validate_addentry(groupId){
	
	if(!posCheck(payment_list)||!posCheck(share_list))
		return -1;	
	
	if(!sumCheck(payment_list,share_list))
		return -2;
	
	
	
	return 1;

}

function sumCheck(payment_list,share_list){
	return(getTotal(payment_list)==getTotal(share_list));
}



function posCheck(editBoxList){
	for (var i=0;i<editBoxList.length;i++){
		if(isNaN(editBoxList[i].value)){
			return false;
		}
		else if(editBoxList[i].value<0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	return true;
}

function getPaymentEditBox(groupId)
{
	var payment_list = document.getElementsByClassName('contributions-amount-'+groupId);
	return payment_list;
}
function getShareEditBox(groupId)
{
	var share_list = document.getElementsByClassName('shares-amount-'+groupId);
	return share_list;
}

// sets equal shares in share edit boxes when total payment changes
function distributeEqualShare(equal_value,editbox_list)
{
	for (var i=0; i<editbox_list.length; i++)
	{
		if(editbox_list[i].disabled == false)	
		{
			editbox_list[i].value = equal_value;
		}
	}
}


//returns count of enabled edit boxes in list
function getEnabledCount(editbox_list)
{
	var count =0;
	for(var i=0 ; i<editbox_list.length; i++)
	{
		if (editbox_list[i].disabled == false)
		{
			count++;
		}
	}
	return count;
}

//gets the total
function getTotal(editbox_list)
{
	var total = new Number(0);
	for (var i=0;i<editbox_list.length;i++)
	{
		if (isNaN(editbox_list[i].value))
		{
			return 0;
		}
		else
		{
			total += Number(editbox_list[i].value);
		}
	}
	return total;
}