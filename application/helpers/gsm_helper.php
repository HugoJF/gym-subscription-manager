<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/21/13
	 * Time: 11:18 PM
	 * To change this template use File | Settings | File Templates.
	 */

	if(! function_exists('build_user_table_from_query'))
	{
		function build_user_table_from_query($query, $group)
		{
			if($query->num_rows() == 0)
			{
				return FALSE;
			}
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

			//Uri decomposition
			$uri         = explode('/', uri_string());
			$group_order = (isset($uri[2]) ? $uri[2] : '');
			$field       = (isset($uri[3]) ? $uri[3] : '');
			$type        = (isset($uri[4]) ? $uri[4] : '');

			//Pre-determines what symbol will be used
			$symbol = '';
			if($type == 'ASC')
				$symbol = '&#9650;';
			if($type == 'DESC')
				$symbol = '&#9660;';

			//Create header based on ordering

			//If sorting this field and sorting current group/table
			//User id header
			if($field == 'user_id' && $group_order == $group->name)
			{
				$td = new TableData();
				$row->add_child($td->add_child('<a href="' . base_url('dashboard/order/' . $group->name . '/user_id/' . (($type == 'ASC') ? 'DESC' : 'ASC')) . '"><strong>ID ' . $symbol . '</strong></a>'));
			}
			else
			{
				$td = new TableData();
				$row->add_child($td->add_child('<a href="' . base_url('dashboard/order/' . $group->name . '/user_id/' . (($type == 'ASC') ? 'DESC' : 'ASC')) . '"><strong>ID</strong></a>'));
			}

			//If sorting this field and sorting current group/table
			//User name header
			if($field == 'name' && $group_order == $group->name)
			{
				$td = new TableData();
				$row->add_child($td->add_child('<a href="' . base_url('dashboard/order/' . $group->name . '/name/' . (($type == 'ASC') ? 'DESC' : 'ASC')) . '"><strong>Nome ' . $symbol . '</strong></a>'));
			}
			else
			{
				$td = new TableData();
				$row->add_child($td->add_child('<a href="' . base_url('dashboard/order/' . $group->name . '/name/' . (($type == 'ASC') ? 'DESC' : 'ASC')) . '"><strong>Nome</strong></a>'));
			}

			//If sorting this field and sorting current group/table
			//Payment date header
			if($field == 'payment_date' && $group_order == $group->name)
			{
				$td = new TableData();
				$row->add_child($td->add_child('<a href="' . base_url('dashboard/order/' . $group->name . '/payment_date/' . (($type == 'ASC') ? 'DESC' : 'ASC')) . '"><strong>Data do ultimo pagamento ' . $symbol . '</strong></a>'));
			}
			else
			{
				$td = new TableData();
				$row->add_child($td->add_child('<a href="' . base_url('dashboard/order/' . $group->name . '/payment_date/' . (($type == 'ASC') ? 'DESC' : 'ASC')) . '"><strong>Data do ultimo pagamento</strong></a>'));
			}

			//If sorting this field and sorting current group/table
			//Payment valid until header
			if($field == 'payment_valid_until' && $group_order == $group->name)
			{
				$td = new TableData();
				$row->add_child($td->add_child('<a href="' . base_url('dashboard/order/' . $group->name . '/payment_valid_until/' . (($type == 'ASC') ? 'DESC' : 'ASC')) . '"><Strong>Valido ate ' . $symbol . '</strong></a>'));
			}
			else
			{
				$td = new TableData();
				$row->add_child($td->add_child('<a href="' . base_url('dashboard/order/' . $group->name . '/payment_valid_until/' . (($type == 'ASC') ? 'DESC' : 'ASC')) . '"><Strong>Valido ate</strong></a>'));
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