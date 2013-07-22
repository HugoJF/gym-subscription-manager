<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/6/13
	 * Time: 2:20 AM
	 * To change this template use File | Settings | File Templates.
	 */

	class GSM_Model extends CI_Model
	{

		function __construct()
		{

		}


		function get_user($user_id = -1)
		{
			if($user_id == - 1)
			{
				return FALSE;
			}
			$this->db->from('users');
			$this->db->select('id, first_name, last_name, username, email, last_payment_id AS payment_id, last_payment_date AS payment_date, last_payment_valid_until AS payment_valid_until');
			$this->db->where('id', $user_id);
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() == 0)
			{
				return FALSE;
			}
			else
			{
				return $query;
			}
		}


		function get_users($users_id = -1)
		{
			if($users_id == - 1 || sizeof($users_id) == 0)
			{
				return FALSE;
			}
			$this->db->from('users');
			$this->db->select('id, first_name, last_name, username, email, last_payment_id AS payment_id, last_payment_date AS payment_date, last_payment_valid_until AS payment_valid_until');
			$this->db->where_in('id', $users_id);
			$this->db->limit(sizeof($users_id));
			$query = $this->db->get();
			if($query->num_rows() == 0)
			{
				return FALSE;
			}
			else
			{
				return $query;
			}
		}


		function get_valid_users($offset = 0, $limit = 30)
		{
			$now   = time();
			$query = $this->db->query("SELECT id, first_name, last_name, username, email, last_payment_id AS payment_id, last_payment_date AS payment_date, last_payment_valid_until AS payment_valid_until FROM users WHERE payment_valid_until > $now LIMIT $offset, $limit");
			if($query->num_rows() == 0)
			{
				return FALSE;
			}
			else
			{
				return $query;
			}
		}


		function get_invalid_users($offset = 0, $limit = 30)
		{
			$now   = time();
			$query = $this->db->query("SELECT id, first_name, last_name, username, email, last_payment_id AS payment_id, last_payment_date AS payment_date, last_payment_valid_until AS payment_valid_until FROM users WHERE payment_valid_until < $now LIMIT $offset, $limit");
			if($query->num_rows() == 0)
			{
				return FALSE;
			}
			else
			{
				return $query;
			}
		}


		function get_all_users($sorting = '', $offset = 0, $limit = 30)
		{
			switch($sorting)
			{
				default:
				case 'user_id/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY id ASC LIMIT $offset, $limit");
					break;
				case 'user_id/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY id DESC LIMIT $offset, $limit");
					break;
				case 'name/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY first_name ASC, last_name ASC LIMIT $offset, $limit");
					break;
				case 'name/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY first_name DESC, last_name DESC LIMIT $offset, $limit");
					break;
				case 'payment_date/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY payment_date ASC LIMIT $offset, $limit");
					break;
				case 'payment_date/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY payment_date DESC LIMIT $offset, $limit");
					break;
				case 'payment_valid_until/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY payment_valid_until ASC LIMIT $offset, $limit");
					break;
				case 'payment_valid_until/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) ORDER BY payment_valid_until DESC LIMIT $offset, $limit");
					break;
			}
			if($query->num_rows() == 0)
			{
				return FALSE;
			}
			else
			{
				return $query;
			}
		}


		function get_all_users_from_group($group, $sorting = '', $offset = 0, $limit = 30)
		{
			switch($sorting)
			{
				default:
				case 'user_id/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) AND users.id IN (SELECT user_id FROM users_groups WHERE group_id = $group) ORDER BY id ASC LIMIT $offset, $limit");
					break;
				case 'user_id/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) AND users.id IN (SELECT user_id FROM users_groups WHERE group_id = $group) ORDER BY id DESC LIMIT $offset, $limit");
					break;
				case 'name/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) AND users.id IN (SELECT user_id FROM users_groups WHERE group_id = $group) ORDER BY first_name ASC, last_name ASC LIMIT $offset, $limit");
					break;
				case 'name/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) AND users.id IN (SELECT user_id FROM users_groups WHERE group_id = $group) ORDER BY first_name DESC, last_name DESC LIMIT $offset, $limit");
					break;
				case 'payment_date/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) AND users.id IN (SELECT user_id FROM users_groups WHERE group_id = $group) ORDER BY payment_date ASC LIMIT $offset, $limit");
					break;
				case 'payment_date/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) AND users.id IN (SELECT user_id FROM users_groups WHERE group_id = $group) ORDER BY payment_date DESC LIMIT $offset, $limit");
					break;
				case 'payment_valid_until/ASC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) AND users.id IN (SELECT user_id FROM users_groups WHERE group_id = $group) ORDER BY payment_valid_until ASC LIMIT $offset, $limit");
					break;
				case 'payment_valid_until/DESC':
					$query = $this->db->query("SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id NOT IN (SELECT user_id FROM users_deactivated) AND users.id IN (SELECT user_id FROM users_groups WHERE group_id = $group) ORDER BY payment_valid_until DESC LIMIT $offset, $limit");
					break;
			}

			return $query;
		}


		function get_payments($user_id = -1)
		{
			if($user_id == - 1)
				return FALSE;
			$this->db->from('payments');
			$this->db->select('id, date, valid_until');
			$this->db->where('user_id', $user_id);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get();

			return $query;
		}


		public function is_user_deactivated($user_id)
		{
			$query = $this->db->query("SELECT IF( COUNT(*)=1, 1, 0 ) AS r FROM users_deactivated WHERE user_id = $user_id LIMIT 1");
			if($query->first_row()->r == '1')
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}


		public function get_deactivated_users()
		{
			$query = $this->db->query('SELECT users.id, users.first_name, users.last_name, users.email, last_payment_id as payment_id, last_payment_date as payment_date, last_payment_valid_until as payment_valid_until FROM users WHERE users.id IN (SELECT user_id FROM users_deactivated)');

			return $query;
		}
	}