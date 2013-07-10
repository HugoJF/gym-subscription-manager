<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/6/13
	 * Time: 2:20 AM
	 * To change this template use File | Settings | File Templates.
	 */

	class GSM_Model extends CI_Model {
		function __construct() {

		}

		function get_user($user_id = -1, $return_last_payment = FALSE) {
			if($user_id == - 1)
				return FALSE;
			if($return_last_payment == TRUE) {
				$query = $this->db->query("SELECT u.id, u.username, u.first_name, u.last_name, u.email, payment_id, payment_date, payment_valid_until FROM users AS u LEFT JOIN ( SELECT * FROM ( SELECT payments.id AS payment_id, payments.user_id, payments.date AS payment_date, payments.valid_until AS payment_valid_until FROM payments WHERE user_id =$user_id ORDER BY valid_until DESC ) AS a GROUP BY a.user_id ) AS b ON u.id = b.user_id WHERE u.id =$user_id");
			} else {
				$this->db->from('users');
				$this->db->select('id AS user_id, first_name, last_name, email');
				$this->db->where('id', $user_id);
				$this->db->limit(1);
				$query = $this->db->get();
			}

			return $query;
		}

		function get_users($users_id = -1, $return_last_payment = FALSE) {
			if($users_id == - 1 || sizeof($users_id) == 0)
				return FALSE;
			if($return_last_payment == TRUE) {
				$mini_array = implode(', ', $users_id);
				$query      = $this->db->query("SELECT u.id, u.username, u.first_name, u.last_name, u.email, b.id AS payment_id, b.date AS payment_date, b.valid_until AS payment_valid_until FROM users AS u LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date, payments.valid_until FROM payments WHERE payments.user_id IN ($mini_array) ORDER BY valid_until DESC ) AS a GROUP BY a.user_id ) AS b ON b.user_id = u.id WHERE user_id IN ($mini_array)");
			} else {
				$this->db->from('users');
				$this->db->select('id, username,first_name, last_name, email');
				$this->db->where_in('id', $users_id);
				$query = $this->db->get();

			}

			return $query;
		}

		function get_valid_users() {
			$query = $this->db->query('SELECT u.id, u.username, u.first_name, u.last_name, u.email, grouped_query.id AS payment_id, grouped_query.date AS payment_date, grouped_query.valid_until AS payment_valid_until FROM users AS u LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date, payments.valid_until FROM payments ORDER BY valid_until DESC ) AS ordered_query GROUP BY ordered_query.user_id ) AS grouped_query ON grouped_query.user_id = u.id WHERE u.id IN ( SELECT a.user_id FROM ( SELECT user_id FROM payments WHERE valid_until > NOW( ) ORDER BY valid_until DESC ) AS a GROUP BY user_id )');

			return $query;
		}

		function get_invalid_users() {
			$query = $this->db->query('SELECT u.id, u.username, u.first_name, u.last_name, u.email, grouped_query.id AS payment_id, grouped_query.date AS payment_date, grouped_query.valid_until AS payment_valid_until FROM users AS u LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date, payments.valid_until FROM payments ORDER BY valid_until DESC ) AS ordered_query GROUP BY ordered_query.user_id ) AS grouped_query ON grouped_query.user_id = u.id WHERE u.id NOT IN ( SELECT a.user_id FROM ( SELECT user_id FROM payments WHERE valid_until > NOW( ) ORDER BY valid_until DESC ) AS a GROUP BY user_id )');

			return $query;
		}

		function get_all_users($sorting = '', $offset = -1, $limit = -1) {
			if($offset == - 1 || $limit == - 1) {
				$offset = 0;
				$limit  = $this->config->item('gsm_users_per_page');
			}
			switch($sorting) {
				default:
				case 'user_id/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, final.id AS payment_id, payment_date, final.valid_until AS payment_valid_until FROM users LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date AS payment_date, payments.valid_until FROM payments ORDER BY payments.valid_until DESC ) AS p GROUP BY p.user_id) AS final ON final.user_id = users.id WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY id ASC LIMIT $offset, $limit");
					break;
				case 'user_id/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, final.id AS payment_id, payment_date, final.valid_until AS payment_valid_until FROM users LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date AS payment_date, payments.valid_until FROM payments ORDER BY payments.valid_until DESC ) AS p GROUP BY p.user_id) AS final ON final.user_id = users.id WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY id DESC LIMIT $offset, $limit");
					break;
				case 'name/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, final.id AS payment_id, payment_date, final.valid_until AS payment_valid_until FROM users LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date AS payment_date, payments.valid_until FROM payments ORDER BY payments.valid_until DESC ) AS p GROUP BY p.user_id) AS final ON final.user_id = users.id WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY first_name ASC, last_name ASC LIMIT $offset, $limit");
					break;
				case 'name/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, final.id AS payment_id, payment_date, final.valid_until AS payment_valid_until FROM users LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date AS payment_date, payments.valid_until FROM payments ORDER BY payments.valid_until DESC ) AS p GROUP BY p.user_id) AS final ON final.user_id = users.id WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY first_name DESC, last_name DESC LIMIT $offset, $limit");
					break;
				case 'payment_date/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, final.id AS payment_id, payment_date, final.valid_until AS payment_valid_until FROM users LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date AS payment_date, payments.valid_until FROM payments ORDER BY payments.valid_until DESC ) AS p GROUP BY p.user_id) AS final ON final.user_id = users.id WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY payment_date ASC LIMIT $offset, $limit");
					break;
				case 'payment_date/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, final.id AS payment_id, payment_date, final.valid_until AS payment_valid_until FROM users LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date AS payment_date, payments.valid_until FROM payments ORDER BY payments.valid_until DESC ) AS p GROUP BY p.user_id) AS final ON final.user_id = users.id WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY payment_date DESC LIMIT $offset, $limit");
					break;
				case 'payment_valid_until/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, final.id AS payment_id, payment_date, final.valid_until AS payment_valid_until FROM users LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date AS payment_date, payments.valid_until FROM payments ORDER BY payments.valid_until DESC ) AS p GROUP BY p.user_id) AS final ON final.user_id = users.id WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY payment_valid_until ASC LIMIT $offset, $limit");
					break;
				case 'payment_valid_until/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, final.id AS payment_id, payment_date, final.valid_until AS payment_valid_until FROM users LEFT JOIN ( SELECT * FROM ( SELECT payments.id, payments.user_id, payments.date AS payment_date, payments.valid_until FROM payments ORDER BY payments.valid_until DESC ) AS p GROUP BY p.user_id) AS final ON final.user_id = users.id WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY payment_valid_until DESC LIMIT $offset, $limit");
					break;
			}

			return $query;
		}

		function get_all_users_name() {
			$this->db->from('users');
			$this->db->select('first_name, last_name');
			$query = $this->db->get();

			return $query;
		}

		function get_payments($user_id = -1) {
			if($user_id == - 1)
				return FALSE;
			$this->db->from('payments');
			$this->db->select('id, date, valid_until');
			$this->db->where('user_id', $user_id);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get();

			return $query;
		}

		function get_id_from_name($user_name = '') {
			if($user_name == '')
				return FALSE;
			$query = $this->db->query("SELECT id FROM users WHERE CONCAT( first_name,  ' ', last_name ) =  '$user_name' LIMIT 1");

			return $query;
		}

		public function get_deactivated_users() {
			$query = $this->db->query('SELECT users.id, users.first_name, users.last_name, users.email FROM users WHERE users.id IN (SELECT user_id FROM users_deactivated)');
			return $query;
		}
	}