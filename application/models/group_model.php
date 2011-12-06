<?php

class Group_model extends CI_Model
{

	var $groupid;
	var $groupname;
	var $member_list;
	var $category_list; //Included Category in Groups model, since in future categories may be user-added per Group.
	var $group_list;

	public function __construct()
	{
		parent::__construct();
		$this->refresh();
		
	}

	function get_groups()
	{
		return $this->group_list;
	}
	
	function refresh()
	{
		$this->db->select(array('groups.groupid','groupname','balance'));
		$this->db->from('usergroup');
		$this->db->join('groups', 'usergroup.groupid = groups.groupid');
		$this->db->where(array('userid'=>$this->session->userdata('userid')));		
		$query = $this->db->get();
		$grouplist = $query->result();
		foreach ($grouplist as $group)
		{
			$group->member_list = $this->get_member_list($group->groupid);
			$group->category_list = $this->get_category_list($group->groupid);
		}
		$this->group_list = $grouplist;
					
	}

	function get_member_list($groupid)
	{
		$this->db->select(array('users.userid','balance','firstname','email'));
		$this->db->from('usergroup');
		$this->db->join('users','usergroup.userid = users.userid');
		// $this->db->join('groups', 'usergroup.groupid = groups.groupid');
		$this->db->where(array('groupid'=>$groupid));		
		$query = $this->db->get();
		$member_list = $query->result();

		// inject other member details in this list if required in future
		return $member_list;
	}

	function get_category_list($groupid)
	{
		$this->db->select(array('categories.categoryname','categories.description'));
		$this->db->from('categories');
		$query = $this->db->get();
		$category_list = $query->result();
		return $category_list;	
	}

	function add_expense($data)
	{
		// This is what we get as $data
		// $data= array(
		// 				'shareid'=>$shareid,
		// 				'shareamount'=>$shareamount,
		// 				'contributionid'=>$contributionid,
		// 				'contributionamount'=>$contributionamount,
		// 				'groupid' => $this->input->post('groupid'),
		// 				'authorid' => $this->session->userdata('userid'),
		// 				'category' => $this->input->post('categoryselect'),
		// 				'description' => $this->input->post('description'),
		// 				'timestamp'=>date('Y-m-d H:i:s')
		// 			);


		$this->db->trans_begin();

		//add entry into transactions table
		$insertdata = array(
				'groupid'=>$data['groupid'],
				'authorid'=>$data['authorid'],
				'category'=>$data['category'],
				'description'=>$data['description'],
				'timestamp'=>$data['timestamp']
			);
		$this->db->insert('transactions', $insertdata); //add entry into transactions table

		$last_tr_id = $this->db->insert_id();

		$insertdata = array(
				'transactionid'=>$last_tr_id,
				'category'=>$data['category']
			);
		$this->db->insert('transactioncategories', $insertdata); //add entry into transactioncategories table

		$sqlshare = "INSERT INTO transactionaffectedusers (transactionid, affecteduserid, amount) VALUES";
		$sqlcontribution = "INSERT INTO transactioncontributors (transactionid, contributoruserid, amount) VALUES";
		
		$length = count($data['shareid']);
		for($i = 0; $i < $length; $i++)
		{
					
			$id = $data['shareid'][$i];
			$shareamount = $data['shareamount'][$i];
			$contributionamount = $data['contributionamount'][$i];
			$debugdata[] = "id=".$id;
			$debugdata[] = "shareamount=".$shareamount;
			$debugdata[] = "contributionamount=".$contributionamount;

			$sqlshare =  $sqlshare . "($last_tr_id , $id , $shareamount )";
			$sqlcontribution =  $sqlcontribution . "($last_tr_id , $id , $contributionamount )";
			
			if($i != ($length - 1) )
			{
				$sqlshare = $sqlshare . ",";
				$sqlcontribution = $sqlcontribution . ",";
			}

			$sqlbalance = "update usergroup set balance = balance";
			if($contributionamount > $shareamount)
			{
				$sqlbalance = $sqlbalance. " + ".($contributionamount - $shareamount);
				$sqlbalance .= " where userid = ".$id." and groupid = ".$data['groupid'];
				$debugdata[] = "sqlbalance=".$sqlbalance;
				$this->db->query($sqlbalance);

			}
			elseif($contributionamount < $shareamount)
			{
				$sqlbalance =$sqlbalance. " - ".($shareamount - $contributionamount);
				$sqlbalance .= " where userid = ".$id." and groupid = ".$data['groupid'];
				$debugdata[] = "sqlbalance=".$sqlbalance;
				$this->db->query($sqlbalance);
			}

		}

		$debugdata[] = "sqlshare=".$sqlshare;
		$debugdata[] = "sqlcontribution=".$sqlcontribution;
		$this->db->query($sqlshare);
		$this->db->query($sqlcontribution);

		


				









		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		else
		{
			$this->db->trans_commit();
			return TRUE;
		}
	}

}