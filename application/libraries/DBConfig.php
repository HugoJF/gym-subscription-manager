<?php

	class DBConfig
	{

		private $CI;
		/**
		 *
		 */
		public function __construct()
		{
			$this->CI =& get_instance();

			$this->CI->load->database();
		}


		public function get_all()
		{
			$query = $this->CI->db->get('options');

			return $query;
		}


		/**
		 * @param $name
		 *
		 * @return mixed
		 */
		public function get_item($name)
		{
			$query = $this->CI->db->get_where('options', array('name' => $name));

			return $query;
		}


		/**
		 * @param $name
		 * @param $value
		 *
		 * @return bool
		 */
		public function set_item($name, $value)
		{
			$query = $this->CI->db->get_where('options', array('name' => $name));
			if($query->num_rows() == 1)
			{
				//Update current item
				$this->CI->db->where('name', $name);
				$this->CI->db->update('options', array('value' => $value));

				return TRUE;
			}
			else
			{
				//Return false, cant set multiple items
				return FALSE;
			}
		}


		/**
		 * @param $name
		 * @param $value
		 */
		public function add_item($name, $value)
		{
			$this->CI->db->insert('options', array('name'  => $name,
											   'value' => $value));
		}


		/**
		 * @param $name
		 * @param $value
		 *
		 * @return bool
		 */
		public function remove_item($name, $value)
		{
			$query = $this->CI->db->get_where('options', array('name' => $name));
			if($query->num_rows() == 1)
			{
				$this->CI->db->delete('options', array('name'  => $name,
												   'value' => $value));

				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}


		/**
		 * @param $name
		 *
		 * @return bool
		 */
		public function remove_items($name)
		{
			$this->CI->db->delete('options', array('name' => $name));

			return TRUE;
		}

	}