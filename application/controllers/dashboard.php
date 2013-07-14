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
			
			$final = array();
			foreach($data_processed as $p) {
				$rid = $p[0];
				$name = $p[1];
				$type = $p[2];
				$bd = $p[4];
				$gender = $p[5];
				list($day, $month, $year) = explode('/', $bd);
				$day = intval($day);
				$month = intval($month);
				$year = intval($year);
				$bd = mktime(0, 0, 0, $month, $day, $year);
				array_push($final, array(
					'rid' => $rid,
					'name' => $name,
					'type' => $type,
					'birthday' => date('d.m.Y', $bd),
					'gender' => $gender
				));
			}
			print_r($final);
			$this->output->enable_profiler(true);
		}
		
		function populate_payments() {
		while(true) {
			$data = array(
				'user_id' => rand(0, 50),
				'date' => date("Y-m-d H:i:s", time()),
				'valid_until' => date("Y-m-d H:i:s", time())
			);
		$this->db->insert('payments', $data);
		}
		}
		function populate_users() {
			$i = 0;
			while(true) {
				$data = array(
					'username' => 'administrator' . $i,
					'password' => '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4',
					'salt' => '9462e8eee0',
					'email' => 'admin' . $i . '@admin.com',
					'created_on' => 1268889823,
					'last_login' => 1268889823,
					'active' => 1,
					'first_name' => 'admin' . $i,
					'last_name' => 'istrator',
					'company' => 'ADMIN'
				);
				$this->db->insert('users', $data);
				$i++;
			}
		}
		//http://www.youtube.com/watch?v=DlvM68JBYkQ
	}