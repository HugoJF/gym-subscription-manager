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
			//Loads paginator
			$this->load->library('Paginator');
			$pagination = new Pagination(5);
			$pagination->set_show_first(TRUE)->set_show_last(TRUE)->set_current_page(20)->set_link_format(base_url('dashboard/%d'));
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
			$this->load->view('dashboard_view', array('tables'     => $tables,
													  'pagination' => $pagination));
			$this->load->view('footer_view');
		}


		public function order($group_name = '', $field = '', $order_type = '', $page = 1)
		{
			$this->output->enable_profiler(TRUE);

			$tables = array();

			foreach($this->ion_auth->groups()->result() as $group)
			{
				if(strtolower($group_name) == strtolower($group->name))
				{
					$query = $this->gsm_model->get_all_users_from_group($group->id, strtolower($field) . '/' . strtoupper($order_type), ($page - 1) * 10, 10);
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


		public function test()
		{
			$this->load->view('header_view');
			$this->load->library('Paginator');
			$paginator = new Pagination(10);
			$paginator->set_current_page(10);
			echo $paginator->get_html();
			echo '<br><br><hr><br><br>';
			echo date('d-m-Y', strtotime('Sunday'));
			echo '<br>';
			echo date('d-m-Y', strtotime('next Sunday'));
			echo '<br>';
			echo date('d-m-Y', strtotime('Saturday'));
			echo '<br>';
			echo date('d-m-Y', strtotime('next Saturday'));
			$this->load->view('footer_view');
		}
	}