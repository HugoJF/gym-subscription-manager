<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/5/13
	 * Time: 6:52 PM
	 * To change this template use File | Settings | File Templates.
	 */
	class Dashboard extends CI_Controller
	{

		public function index()
		{
			$this->output->enable_profiler(TRUE);
			//Array of tables to show
			$tables = array();

			//Push a table for each group present in ion_auth
			foreach($this->ion_auth->groups()->result() as $group)
			{
				$query = $this->gsm_model->get_all_users_from_group($group->id);
				$table = build_user_table_from_query($query, $group);
				if($table == FALSE)
				{
					continue;
				}
				$table->set_name($group->name);
				$table->set_description($group->description);
				array_push($tables, $table);
			}

			$this->load->view('header_view');
			$this->load->view('dashboard_view', array('tables' => $tables));
			$this->load->view('footer_view');
		}


		public function order($group_name = '', $field = '', $order_type = '')
		{
			$this->output->enable_profiler(TRUE);

			$tables = array();

			foreach($this->ion_auth->groups()->result() as $group)
			{
				if(strtolower($group_name) == strtolower($group->name))
				{
					$query = $this->gsm_model->get_all_users_from_group($group->id, strtolower($field) . '/' . strtoupper($order_type));
					$table = build_user_table_from_query($query, $group);
				}
				else
				{
					$query = $this->gsm_model->get_all_users_from_group($group->id);
					$table = build_user_table_from_query($query, $group);
				}

				if($table == FALSE)
				{
					continue;
				}
				$table->set_name($group->name);
				$table->set_description($group->description);
				array_push($tables, $table);
			}

			$this->load->view('header_view');
			$this->load->view('dashboard_view', array('tables' => $tables));
			$this->load->view('footer_view');
		}
	}