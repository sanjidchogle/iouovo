<?php

function get_userid_from_email($email)	
{
	$this->db->select(array('userid'));
	$this->db->from('users');
	$this->db->where(array('email'=>$email));		
	$query = $this->db->get();
	if($query->num_rows() == 1)
	{
		$row = $query->row();
		return $row->userid;
	}
	else
	{
		return NULL;
	}

}

function get_firstname_from_email($email)	
{
	$this->db->select(array('firstname'));
	$this->db->from('users');
	$this->db->where(array('email'=>$email));		
	$query = $this->db->get();
	if($query->num_rows() == 1)
	{
		$row = $query->row();
		return $row->firstname;
	}
	else
	{
		return NULL;
	}

}


