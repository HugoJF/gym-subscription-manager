<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/5/13
	 * Time: 6:52 PM
	 * To change this template use File | Settings | File Templates.
	 */
	class Login extends CI_Controller {
		public function index() {
			$this->form_validation->set_rules('email', $this->lang->line('login_email'), 'required');
			$this->form_validation->set_rules('password', $this->lang->line('login_password'), 'required');

			if ($this->form_validation->run() == TRUE) {
				//User is logging in
				if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), FALSE)) {
					//Login successful
					if($this->ion_auth->is_admin()) {
						//Administrator, can access the dashboard
					} else {
						//Normal user, probably dummy
					}
				} else {
					//Login failed
				}
			} else {
				//User is not loggin in, show login form
				$this->load->view('login_view');
			}
		}
	}