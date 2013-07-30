<?php

	class Ajax extends CI_Controller
	{

		public function user_search()
		{
			$query = $_GET['query'];
			$query = $this->db->query("SELECT concat(first_name, ' ', last_name) as name FROM users WHERE concat(first_name, ' ', last_name) LIKE '%$query%'");

			$final = array();
			foreach($query->result_array() as $r)
			{
				array_push($final, $r['name']);
			}
			echo json_encode($final);

		}
	}