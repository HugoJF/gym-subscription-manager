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
			$this->all();
		}


		/**
		 * @param string $group_name - Specific group to order
		 * @param string $field      - Field to be ordered
		 * @param string $order_type - Order method
		 * @param int    $page       - Query page
		 */
		public function all($group_name = '', $field = 'user_id', $order_type = 'ASC', $page = 1)
		{
			$this->output->enable_profiler(true);
			//Protect page
			if(! $this->ion_auth->logged_in())
			{
				redirect('login', 'refresh');
			}
			if(! $this->ion_auth->is_admin())
			{
				$this->ion_auth->logout();
				redirect('login', 'refresh');
			}

			$tables = array();

			foreach($this->ion_auth->groups()->result() as $group)
			{
				if(strcasecmp($group_name, $group->name) == 0)
				{
					$query = $this->gsm_model->get_all_users_from_group($group->id, $field . '/' . $order_type, ($page - 1) * 5, 5);
					$table = $this->build_user_table_from_query($query, array('uri_format'  => '{controller}/{method}/{order_group}/{field}/{order_type}/{page}',
																			  'uri_default' => 'dashboard/all/admin/user_id/asc/1',
																			  'group_info'  => $group));
				}
				else
				{
					$query = $this->gsm_model->get_all_users_from_group($group->id);
					$table = $this->build_user_table_from_query($query, array('uri_format'  => '{controller}/{method}/{order_group}/{field}/{order_type}/{page}',
																			  'uri_default' => 'dashboard/all/admin/user_id/asc/1',
																			  'group_info'  => $group));
				}

				$table->set_name($group->name);
				$table->set_description($group->description);
				array_push($tables, $table);
			}

			$this->load->view('header_view');
			$this->load->view('dashboard_view', array('tables' => $tables));
			$this->load->view('footer_view');
		}


		/**
		 * @param string $group_name - Group to be displayed
		 * @param string $field      - Field to be ordered
		 * @param string $order_type - Order method
		 * @param int    $page       - Query page
		 */
		public function group($group_name = '', $field = 'id', $order_type = 'ASC', $page = 1)
		{
			//Protect page
			if(! $this->ion_auth->logged_in())
			{
				redirect('login', 'refresh');
			}
			if(! $this->ion_auth->is_admin())
			{
				$this->ion_auth->logout();
				redirect('login', 'refresh');
			}

			if($group_name == '')
			{
				redirect('dashboard');
			}

			foreach($this->ion_auth->groups()->result() as $group)
			{
				if(strcasecmp($group->name, $group_name) == 0)
				{
					$query = $this->gsm_model->get_all_users_from_group($group->id, $field . '/' . $order_type, ($page - 1) * 5, 5);
					$table = $this->build_user_table_from_query($query, array('uri_format'  => '{controller}/{method}/{order_group}/{field}/{order_type}/{page}',
																			  'uri_default' => 'dashboard/group/admin/user_id/asc/1',
																			  'group_info'  => $group));
					$table->set_name($group->name);
					$table->set_description($group->description);
					break;
				}
			}
			$this->load->view('header_view');
			$this->load->view('dashboard_view', array('tables' => array($table)));
			$this->load->view('footer_view');
		}


		public function test()
		{
			$query = $this->gsm_model->get_all_users_from_group(1);
			$this->build_user_table_from_query($query, array('uri_format'  => '{controller}/{method}/{param1}/{param2}/{param3}',
															 'uri_default' => 'default_cont/method/value1/value2/value3',
															 'group_info'  => $this->ion_auth->group()));
		}


		/**
		 * @param $query  - Content of the table
		 * @param $params - uri_format => expectation of URI, uri_default => default URI when missing, group_info => information about group used
		 *
		 * @return bool|Table
		 */
		private function build_user_table_from_query($query, $params)
		{
			$CI =& get_instance();

			//Creates main table components
			$table        = new Table('table table-hover table-bordered');
			$table_header = new TableHeader();
			$table_body   = new TableBody();

			//Binding components to table
			$table->add_child($table_header);
			$table->add_child($table_body);

			//Bind TableRow to represent TableHeader
			$row = new TableRow();

			//URI manipulation

			//The keywords used in the URI format
			$search = array('{controller}', '{method}', '{order_group}', '{field}', '{order_type}', '{page}');
			//Current expected URI format
			$uri_format = $params['uri_format'];
			//URI default - if can't find value on current URI, uses this URI
			$uri_default = explode('/', $params['uri_default']);
			//We split the format into the keywords
			$uri_format_s = explode('/', $uri_format);
			//We split the current URI
			$uri_current_s = explode('/', uri_string());
			//Array that holds the magic
			$uri = array();
			//Bind current URI value to what it's expected to be
			for($i = 0; $i < sizeof($uri_format_s); $i ++)
			{
				if(! isset($uri_current_s[$i]) && ! isset($uri_default[$i]))
					return FALSE;
				//trim { and } from keyword
				$uri[str_replace(array('{',
									   '}'), '', $uri_format_s[$i])] = (empty($uri_current_s[$i]) ? $uri_default[$i] : $uri_current_s[$i]);
			}
			//Creates pagination
			$CI->load->library('Paginator');
			$pagination = new Pagination(5);
			$pagination->set_link_format(base_url(str_replace($search, array($uri['controller'],
																			 $uri['method'],
																			 $uri['order_group'],
																			 $uri['field'],
																			 $uri['order_type'],
																			 '%d'), $uri_format)));
			$pagination->set_show_first(TRUE)->set_show_last(TRUE);
			if($uri['order_group'] == $params['group_info']->name)
			{
				$pagination->set_current_page($uri['page']);
			}
			else
			{
				$pagination->set_current_page(1);
			}
			$table->add_pagination($pagination->get_html());

			//Determines what symbol will be used
			$symbol = '';
			if($uri['order_type'] == 'ASC')
				$symbol = '&#9650;';
			if($uri['order_type'] == 'DESC')
				$symbol = '&#9660;';

			//Create header based on ordering

			$main_href = base_url(str_replace($search, array($uri['controller'],
															 $uri['method'],
															 $params['group_info']->name,
															 '{field}',
															 '{order_type}',
															 $uri['page']), $uri_format));
			//If sorting this field and sorting current group/table
			//User id header
			if($uri['field'] == 'user_id' && $uri['order_group'] == $params['group_info']->name)
			{
				$td   = new TableData();
				$href = str_replace(array('{field}',
										  '{order_type}',), array('user_id',
																  $uri['order_type'] == 'ASC' ? 'DESC' : 'ASC'), $main_href);
				$row->add_child($td->add_child("<a href=\"$href\"><strong>ID $symbol</strong></a>"));
			}
			else
			{
				$td   = new TableData();
				$href = str_replace(array('{field}',
										  '{order_type}',), array('user_id',
																  $uri['order_type']), $main_href);
				$row->add_child($td->add_child("<a href=\"$href\"><strong>ID</strong></a>"));
			}

			//If sorting this field and sorting current group/table
			//User name header
			if($uri['field'] == 'name' && $uri['order_group'] == $params['group_info']->name)
			{
				$td   = new TableData();
				$href = str_replace(array('{field}',
										  '{order_type}',), array('name',
																  $uri['order_type'] == 'ASC' ? 'DESC' : 'ASC'), $main_href);
				$row->add_child($td->add_child("<a href=\"$href\"><strong>Nome $symbol</strong></a>"));
			}
			else
			{
				$td   = new TableData();
				$href = str_replace(array('{field}', '{order_type}',), array('name', $uri['order_type']), $main_href);
				$row->add_child($td->add_child("<a href=\"$href\"><strong>Nome</strong></a>"));
			}

			//If sorting this field and sorting current group/table
			//Payment date header
			if($uri['field'] == 'payment_date' && $uri['order_group'] == $params['group_info']->name)
			{
				$td   = new TableData();
				$href = str_replace(array('{field}',
										  '{order_type}',), array('payment_date',
																  $uri['order_type'] == 'ASC' ? 'DESC' : 'ASC'), $main_href);
				$row->add_child($td->add_child("<a href=\"$href\"><strong>Data de pagamento $symbol</strong></a>"));
			}
			else
			{
				$td   = new TableData();
				$href = str_replace(array('{field}',
										  '{order_type}',), array('payment_date',
																  $uri['order_type']), $main_href);
				$row->add_child($td->add_child("<a href=\"$href\"><strong>Data de pagamento</strong></a>"));
			}

			//If sorting this field and sorting current group/table
			//Payment valid until header
			if($uri['field'] == 'payment_valid_until' && $uri['order_group'] == $params['group_info']->name)
			{
				$td   = new TableData();
				$href = str_replace(array('{field}',
										  '{order_type}',), array('payment_valid_until',
																  $uri['order_type'] == 'ASC' ? 'DESC' : 'ASC'), $main_href);
				$row->add_child($td->add_child("<a href=\"$href\"><strong>Valido ate $symbol</strong></a>"));
			}
			else
			{
				$td   = new TableData();
				$href = str_replace(array('{field}',
										  '{order_type}',), array('payment_valid_until',
																  $uri['order_type']), $main_href);
				$row->add_child($td->add_child("<a href=\"$href\"><strong>Valido ate</strong></a>"));
			}

			$td = new TableData();
			$row->add_child($td->add_child('<strong>Status</strong>'));
			$td = new TableData();
			$row->add_child($td->add_child('<strong>Acoes</strong>'));

			//Bind table row to header
			$table_header->add_child($row);

			//Populates table with contents
			foreach($query->result_array() as $user)
			{
				$row = new TableRow();
				$row->set_class(($user['payment_valid_until'] < time()) ? 'error' : 'success');

				$td = new TableData();
				$row->add_child($td->add_child($user['id']));
				$td = new TableData();
				$row->add_child($td->add_child($user['first_name'] . ' ' . $user['last_name']));
				$td = new TableData();
				$row->add_child($td->add_child(($user['payment_date'] == '' ? 'N/A' : date('F j, Y, g:i a', $user['payment_date']))));
				$td = new TableData();
				$row->add_child($td->add_child(($user['payment_date'] == '' ? 'N/A' : date('F j, Y, g:i a', $user['payment_valid_until']))));
				$td = new TableData();
				$row->add_child($td->add_child(($user['payment_valid_until']) < time() ? 'Vencido' : 'Em dia'));
				$td = new TableData();
				$row->add_child($td->add_child('<a class="btn btn-mini" href="' . base_url('users/detail/' . $user['id'] . '"><i class="icon-plus"></i><strong> Mais informacoes</strong></a>')));

				$table_body->add_child($row);

			}

			return $table;
		}
	}