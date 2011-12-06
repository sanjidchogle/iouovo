<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->output->enable_profiler(TRUE);
		$this->load->helper(array('url','form','user_profile'));
		$this->load->model('group_model');
		$this->load->model('account_model');
	}

	function index()
	{
		if($this->account_model->logged_in() === FALSE)
		{
			$this->load->view('main_view');
		}
		else
		{
			
			$data['group_list'] = $this->group_model->get_groups();
			$data['logged_in_email']= $this->session->userdata('email');
			$this->load->view('manage_groups_view',$data);	
		}
	}

	function add_expense()
	{
		foreach($this->input->post(NULL, TRUE) as $k=>$v)
		{
			$pieces  = explode('_',$k);
			if($pieces[0] == 'shares')
			{
				$shareid[] = $pieces[3];
				$shareamount[] = $v;
			}
			if($pieces[0] == 'contributions')
			{
				$contributionid[] = $pieces[3];
				$contributionamount[] = $v;
			}
		}

		// $groupid = $this->input->post('groupid');
		// $authorid = $this->session->userdata('userid');
		// $category = $this->input->post('categoryselect');
		// $description = $this->input->post('description');

		$data= array(
						'shareid'=>$shareid,
						'shareamount'=>$shareamount,
						'contributionid'=>$contributionid,
						'contributionamount'=>$contributionamount,
						'groupid' => $this->input->post('groupid'),
						'authorid' => $this->session->userdata('userid'),
						'category' => $this->input->post('categoryselect'),
						'description' => $this->input->post('description'),
						'timestamp'=>date('Y-m-d H:i:s')
					);

		
		$result = $this->group_model->add_expense($data);
		if($result)
		{
			// $data['group_list'] = $this->group_model->get_groups();
			// $data['logged_in_email']= $this->session->userdata('email');
			// $this->load->view('manage_groups_view',$data);

			// $cities = array(
			   //      'Adelaide',
			   //      'Perth',
			   //      'Melbourne',
			   //      'Sydney'
			   //  );
 
    
    

			$memberlist = $this->group_model->get_member_list($data['groupid']);
			echo json_encode($memberlist);

			// echo $memberlist;

			// // load a view for member_collection_groupid instead of manage_groups_view.
		}


	}


}
