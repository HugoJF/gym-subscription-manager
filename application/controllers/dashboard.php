<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/5/13
	 * Time: 6:52 PM
	 * To change this template use File | Settings | File Templates.
	 */
	class Dashboard extends CI_Controller {
		public function index () {
			$query = $this->gsm_model->get_all_users();
			$this->load_dashboard($query);
		}

		public function user_id ($type = 'DESC') {
			$sorting = 'user_id/' . strtoupper($type);
			$query = $this->gsm_model->get_all_users($sorting);
			$this->load_dashboard($query);
		}

		public function name($type = 'DESC') {
			$sorting = 'name/' . strtoupper($type);
			$query = $this->gsm_model->get_all_users($sorting);
			$this->load_dashboard($query);
		}

		public function payment_date ($type = 'DESC') {
			$sorting = 'payment_date/' . strtoupper($type);
			$query = $this->gsm_model->get_all_users($sorting);
			$this->load_dashboard($query);
		}

		public function payment_valid_until ($type = 'DESC') {
			$sorting = 'payment_valid_until/' . strtoupper($type);
			$query = $this->gsm_model->get_all_users($sorting);
			$this->load_dashboard($query);
		}

		private function load_dashboard($users) {
			$this->load->view('header_view');
			$this->load->view('dashboard_view', array('users' => $users));
			$this->load->view('footer_view');
		}


		public function testing () {
			echo '<pre>';
			echo '<h1>1</h1>';
			print_r ($this->gsm_model->get_users (array(1, 2), TRUE)->result ());
			echo '<h1>2</h1>';
			print_r ($this->gsm_model->get_valid_users ()->result ());
			echo '</pre>';
		}
	}