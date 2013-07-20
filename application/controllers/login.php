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
			$this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');
			$this->form_validation->set_rules('email', $this->lang->line('login_email'), 'required');
			$this->form_validation->set_rules('password', $this->lang->line('login_password'), 'required');

			if ($this->form_validation->run() == TRUE) {
				//User is logging in
				if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), FALSE)) {
					//Login successful
					if ($this->ion_auth->is_admin()) {
						//Can login
						redirect('dashboard');
					} else {
						//Dummy user
						$this->ion_auth->logout();
						$this->session->set_flashdata('error', $this->lang->line('error_cant_access'));
						redirect('login');
					}
				} else {
					//Login fail
					$this->load->view('login_view');
				}
			} else {
				//User is not loggin in, show login form
				$this->load->view('login_view');
			}
		}
	}