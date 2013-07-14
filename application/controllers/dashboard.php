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
		function populate_memory() {
		while(true) {
			$data = array(
				'user_id' => rand(0, 50),
				'valid_until' => date("Y-m-d H:i:s", time())
			);
		$this->db->insert('memory_test', $data);
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
		function do_tests() {
			$this->output->enable_profiler(true);
			echo '<pre>';
			
			
			//id
			$id_array = array();
			for($i = 1; $i <= 30; $i++) {
				array_push($id_array, $i);
			}
			echo '<h1>ID ARRAY</h1>';
			print_r($this->get_users_info($id_array));
			//name
			$name_query = $this->db->query('SELECT id FROM users ORDER BY first_name ASC, last_name ASC LIMIT 30');
			$name_array = array();
			foreach($name_query->result_array() as $name_q) {
				array_push($name_array, $name_q['id']);
			}
			echo '<h1>NAME ARRAY</h1>';
			print_r($this->get_users_info($name_array));
			//payment date
			$pd_query = $this->db->query('SELECT DISTINCT user_id FROM payments ORDER BY DATE DESC LIMIT 30');
			$pd_array = array();
			foreach($pd_query->result_array() as $pd) {
				array_push($pd_array, $pd['user_id']);
			}
			echo '<h1>PAYMENT DATE ARRAY</h1>';
			print_r($this->get_users_info($pd_array));
			//payments valid until
			$pvu_query = $this->db->query('SELECT DISTINCT user_id FROM payments ORDER BY valid_until DESC LIMIT 30');
			$pvu_array = array();
			foreach($pvu_query->result_array() as $pvu) {
				array_push($pvu_array, $pvu['user_id']);
			}
			echo '<h1>PAYMENT VALID UNTIL ARRAY</h1>';
			print_r($this->get_users_info($pvu_array));
			
			echo '</pre>';
		}
		
		private function get_users_info($users = NULL) {
			if($users == NULL) return FALSE;
			
			$final_query = '';
			
			for($i = 1; $i <= sizeof($users); $i++) {
				if($i != 1) {
					$final_query .= ' UNION ALL ';
				}
				$final_query .= "(SELECT u.id, u.username, u.first_name, u.last_name, u.email, payments.id as payment_id, payments.date as payment_date, payments.valid_until as payment_valid_until FROM `payments` left join users as u on u.id = payments.user_id where user_id = $i order by payments.date desc, payments.id desc limit 1)";
			}
			
			$query = $this->db->query($final_query);
			
			return $query->result();
			
		}
	}