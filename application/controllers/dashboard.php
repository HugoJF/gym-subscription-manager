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
		
		public function testing() {
			echo '<pre>';
			
			print_r($this->gsm_model->get_user(1)->result());
			
			echo '</pre>';
		}
		
		public function csv_decryption() {
			$data = $this->load->view('csv_data', '', TRUE);
			$data = preg_split('/\n/ ', $data);
			$data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);
			$data_processed = array();
			foreach($data as $data_s) {
				$data_s_proc = explode(',', $data_s);
				if(!isset($data_s_proc[5]) || !isset($data_s_proc[3])) continue;
				if($data_s_proc[0] == '' || $data_s_proc[1] == '') continue;
				array_push($data_processed, $data_s_proc);
			}
		//http://www.youtube.com/watch?v=DlvM68JBYkQ
		}
	}