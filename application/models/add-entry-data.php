<?php
session_start();
require('functions.php');
foreach($_GET as $k=>$v){
	echo "$k = $v <br />";
	$pieces  = explode('_',$k);
	if($pieces[0] == 'shares')
	{
		$shareid[] = $pieces[2];
		$shareamount[] = $v;
	}
	if($pieces[0] == 'contributions')
	{
		$contributionid[] = $pieces[2];
		$contributionamount[] = $v;
	}
}
echo "userid ".$_SESSION['loggedinuserid'];

$groupid = $_GET['groupselect'];
$authorid = $_SESSION['loggedinuserid'];
$category = $_GET['categoryselect'];
$description = $_GET['contrbution-description'];


$con = mysql_connect(dbhostname,dbusername,dbpassword);
	if (!$con)   die('Could not connect: ' . mysql_error());
	mysql_select_db(dbname, $con);

$sql= "Insert into transactions (groupid,authorid,category,description,timestamp) values ($groupid,$authorid,'$category','$description',now())"; //add entry into transactions table
		$result = mysql_query($sql,$con);
	
		if(mysql_affected_rows($con)!=1 )
		{
			echo"something went wrong";
		}
		else
		{
			echo "values added to db";
			$last_tr_id = mysql_insert_id();
			
			$sqlcategory = "insert into transactioncategories (transactionid , category) values ($last_tr_id , '$category' )";
			$result = mysql_query($sqlcategory,$con);
	
			if(mysql_affected_rows($con)!=1 )
			{
				echo"something went wrong in adding data to transactioncategories";
			}
			
			
			$sqlshare = "INSERT INTO transactionaffectedusers (transactionid, affecteduserid, amount) VALUES";
			$sqlcontribution = "INSERT INTO transactioncontributors (transactionid, contributoruserid, amount) VALUES";
			
			$length = count($shareid);
			for($i = 0; $i < $length; $i++)
			{
				
				echo $shareid[$i]." ".$shareamount[$i] ;
				echo $contributionid[$i]." ".$contributionamount[$i]. "<br />";
				$sqlshare =  $sqlshare . "($last_tr_id , $shareid[$i] , $shareamount[$i] )";
				$sqlcontribution =  $sqlcontribution . "($last_tr_id , $contributionid[$i] , $contributionamount[$i] )";
				
				if($i != ($length - 1) )
				{
					$sqlshare = $sqlshare . ",";
					$sqlcontribution = $sqlcontribution . ",";
				}
			}
			
			echo $sqlshare;
			echo $sqlcontribution;

			$result = mysql_query($sqlshare,$con);
	
			if(mysql_affected_rows($con)!=$length )
			{
				echo"something went wrong in adding data to transactionaffectedusers";
			}
			
			$result = mysql_query($sqlcontribution,$con);
	
			if(mysql_affected_rows($con)!=$length )
			{
				echo"something went wrong in adding data to transactioncontributors";
			}
			
			for($i = 0; $i < $length; $i++)
			{
				$sqlbalance = "update usergroup set balance = balance";
				if($contributionamount[$i] > $shareamount[$i])
				{
					$sqlbalance = $sqlbalance. " + ".($contributionamount[$i] - $shareamount[$i]);
				}
				elseif($contributionamount[$i] < $shareamount[$i])
				{
					$sqlbalance =$sqlbalance. " - ".($shareamount[$i] - $contributionamount[$i]);
				}
				elseif($contributionamount[$i] == $shareamount[$i])
				{
					$sqlbalance = $sqlbalance." + ".($contributionamount[$i] - $shareamount[$i]);
				}
				
				
				$sqlbalance .= " where userid = ".$shareid[$i]." and groupid = ".$groupid;
				echo "sqlbalance: ".$sqlbalance;
				
				$result = mysql_query($sqlbalance,$con);
				if(mysql_affected_rows($con)!=1 )
				{
					echo"\nsomething went wrong in updating balance in usergroup";
				}
				
			}

			
		}