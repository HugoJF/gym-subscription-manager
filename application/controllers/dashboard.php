<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/5/13
	 * Time: 6:52 PM
	 * To change this template use File | Settings | File Templates.
	 */
	class Dashboard extends CI_Controller {
		public function index() {
			$query = $this->gsm_model->get_all_users('', 0, $this->config->item('gsm_users_per_page'));
			$this->load_dashboard($query);
		}

		public function user_id($type = 'DESC', $offset = -1, $limit = -1) {
			if($offset == - 1 || $limit == - 1) {
				$offset = 0;
				$limit  = $this->config->item('gsm_users_per_page');
			}
			$sorting = 'user_id/' . strtoupper($type);
			$query   = $this->gsm_model->get_all_users($sorting, $offset, $limit);
			$this->load_dashboard($query);
		}

		public function name($type = 'DESC', $offset = -1, $limit = -1) {
			if($offset == - 1 || $limit == - 1) {
				$offset = 0;
				$limit  = $this->config->item('gsm_users_per_page');
			}
			$sorting = 'name/' . strtoupper($type);
			$query   = $this->gsm_model->get_all_users($sorting, $offset, $limit);
			$this->load_dashboard($query);
		}

		public function payment_date($type = 'DESC', $offset = -1, $limit = -1) {
			if($offset == - 1 || $limit == - 1) {
				$offset = 0;
				$limit  = $this->config->item('gsm_users_per_page');
			}
			$sorting = 'payment_date/' . strtoupper($type);
			$query   = $this->gsm_model->get_all_users($sorting, $offset, $limit);
			$this->load_dashboard($query);
		}

		public function payment_valid_until($type = 'DESC', $offset = -1, $limit = -1) {
			if($offset == - 1 || $limit == - 1) {
				$offset = 0;
				$limit  = $this->config->item('gsm_users_per_page');
			}
			$sorting = 'payment_valid_until/' . strtoupper($type);
			$query   = $this->gsm_model->get_all_users($sorting, $offset, $limit);
			$this->load_dashboard($query);
		}

		private function load_dashboard($users) {
			$this->output->enable_profiler(TRUE);
			$this->load->view('header_view');
			$this->load->view('dashboard_view', array('users' => $users));
			$this->load->view('footer_view');
		}

		public function superpopulatepayments() {
			$this->output->enable_profiler(TRUE);
			for($i = 0; $i < 10000; $i ++) {
				$data = array('ip_address' => '00000000000000000000000000000001', 'username' => 'administrator' . $i,
							  'password'   => '3531e4e40812dd5ae8cb64a14e504c0b0ae71272',
							  'email'      => 'admimnistrator' . $i . '@email.com', 'created_on' => '1373205992',
							  'active'     => '1', 'first_name' => 'admin', 'last_name' => 'istrator',);
				$this->db->insert('users', $data);
			}
		}
	}