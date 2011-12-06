<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->output->enable_profiler(TRUE);
		$this->load->helper(array('url','form','user_profile'));
		$this->load->model('account_model');
		$this->load->library('recaptcha');
		$this->lang->load('recaptcha');
		
	}
	public function index()
	{
		
		if($this->account_model->logged_in() === TRUE)
		{
			redirect('welcome/dashboard');
		}
		else
		{
			$this->load->view('main_view');
		}
		
	}

	 
	
	function dashboard($condition = FALSE)
	{
		if($condition === TRUE
		OR $this->account_model->logged_in() === TRUE)
		{
			$data = array(
					"logged_in_email" => $this->session->userdata('email')
				);
			$this->load->view('dashboard_view',$data);
		}
		else
		{
			redirect('welcome/login');
		}
	}

	function logout()
	{
		$this->account_model->log_out();
		redirect('welcome/index');
	}
	
	function signup()
	{
		if($this->account_model->logged_in() === TRUE)
		{
			redirect('welcome/dashboard');
		}
		else
		{
			$this->form_validation->set_rules('recaptcha_response_field','recaptcha','xss_clean|callback_check_captcha');
			$this->form_validation->set_rules('email_signup', 'Email address','required|valid_email|xss_clean|callback_check_email_already_exist');
			$this->form_validation->set_rules('password_signup','Password','required|min_length[5]|callback_check_obvious|md5');
			$this->form_validation->set_rules('password_signup2','confirm password','matches[password_signup]|md5');
			$this->form_validation->set_message('required','%s is required');
			$this->_email_signup = $this->input->post('email_signup');
			$this->_password_signup = $this->input->post('password_signup');

			if($this->form_validation->run() == FALSE)
			{
				$data = array('recaptcha'=>$this->recaptcha->get_html());
				$this->load->view('signup_view',$data);
			}
			else
			{   
				$fname=explode('@',$this->input->post('email_signup'));
				// $fname will be array such that $fname[0] will have name part of Email
				$data= array(
						'email'=>$this->input->post('email_signup'),
						'password'=>$this->input->post('password_signup'),
						'firstname'=>$fname[0],
						'status'=>"active",
						'registration_timestamp'=>date('Y-m-d H:i:s')
					);
				if($this->account_model->signup($data))
				{
					$user_to_login= array(
							'email'=>$this->input->post('email_signup')
						);
					$this->account_model->login($user_to_login);
					redirect('welcome/dashboard');
				}
				else
				{
					echo "error while creating account";
					// echoing in controller just for a timebeing.
				}
				
				
			}
		}
	}

	function check_obvious()
	{
		$this->form_validation->set_message('check_obvious', 'The password is too obvious. Please choose a stronger password.');

		//need to implement this
		return TRUE;
	}

	function check_email_already_exist()
	{
		$query = $this->db->get_where('users', array('email' => $this->_email_signup));

		if($query->num_rows() > 0)
		{
			$this->form_validation->set_message('check_email_already_exist', 'The account already exists');
			return FALSE;
		}

		$query->free_result();
		return TRUE;
	}

	function login()
		{
			if($this->account_model->logged_in() === TRUE)
			{
				redirect('welcome/dashboard');
			}
			else
			{
				$this->form_validation->set_rules('recaptcha_response_field','recaptcha','xss_clean|callback_check_captcha');
				$this->form_validation->set_rules('email', 'email address','xss_clean');
				$this->form_validation->set_rules('password','password','xss_clean|md5|callback_password_check');
				// $this->form_validation->set_message('required','Please enter your %s');
				$this->_email = $this->input->post('email');
				$this->_password = md5($this->input->post('password'));
				if($this->form_validation->run() == FALSE)
				{
					$data = array('recaptcha'=>$this->recaptcha->get_html());
					$this->load->view('login_view',$data);
				}
				else
				{   
					$user_to_login= array(
							'email'=>$this->input->post('email')
						);
					$this->account_model->login($user_to_login);
					redirect('welcome/dashboard');	
				}
			}
	}
	function password_check()
	{
		$this->db->select(array('email','password'));
		$this->db->where('email',$this->_email);
		$query = $this->db->get('users');
		$result = $query->row_array();
		if($query->num_rows() === 0)
		{
			$this->form_validation->set_message('password_check', 'The username or password you entered is incorrect');
			return FALSE;
		}
		else
		{
	   		if($result['password'] == $this->_password)
			{
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('password_check', 'The username or password you entered is incorrect');
				return FALSE;
			}
		}	
		   
	}
	
	function check_captcha($val)
	{
		if ($this->input->post('recaptcha_challenge_field'))
		{

			if ($this->recaptcha->check_answer($this->input->ip_address(),$this->input->post('recaptcha_challenge_field'),$val))
			{
		    	return TRUE;
		  	}
		  	else
		  	{
		    	$this->form_validation->set_message('check_captcha',$this->lang->line('recaptcha_incorrect_response'));
		    	return FALSE;
		  	}
		}
		return TRUE;
	}	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */