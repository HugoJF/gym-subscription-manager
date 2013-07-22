<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/7/13
	 * Time: 8:24 AM
	 * To change this template use File | Settings | File Templates.
	 */

	class Users extends CI_Controller
	{

		public function detail($user_id = -1)
		{
			if($user_id == - 1 && ! isset($_POST['user']))
			{
				redirect('dashboard');
			}
			if($user_id == - 1)
			{
				$query = $this->gsm_model->get_id_from_name($_POST['user']);
				if($query->num_rows == 0)
				{
					redirect('dashboard');
				}
				$user_id = $query->first_row()->id;
			}
			$user     = $this->gsm_model->get_user($user_id, TRUE)->first_row();
			$payments = $this->gsm_model->get_payments($user_id);
			$this->load->view('header_view');
			$this->load->view('users_detail_view', array('user' => $user, 'payments' => $payments));
			$this->load->view('footer_view');
		}


		public function add()
		{
			$this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');
			$this->form_validation->set_rules('first_name', 'Primeiro nome', 'required');
			$this->form_validation->set_rules('last_name', 'Ultimo nome', 'required');
			$this->form_validation->set_rules('group', 'Grupo', 'required');

			if($this->form_validation->run() == TRUE)
			{
				$username        = $_POST['first_name'] . ' ' . $_POST['last_name'];
				$password        = 'password';
				$email           = ($_POST['email'] == '') ? $_POST['first_name'] . $_POST['last_name'] . '@email.com' : $_POST['email'];
				$additional_data = array('first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'],);
				$group           = array($_POST['group']);

				$result = $this->ion_auth->register($username, $password, $email, $additional_data, $group);
				if($result != FALSE)
				{
					redirect('users/detail/' . $result);
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
					redirect('dashboard');
				}
			}
			else
			{
				$this->load->view('header_view');
				$this->load->view('users_add_view', array('groups' => $this->ion_auth->groups()->result()));
				$this->load->view('footer_view');
			}
		}


		public function deactivate($user_id)
		{
			$data = array('user_id' => $user_id);
			$this->db->insert('users_deactivated', $data);
			$this->session->set_flashdata('message', 'User ' . $user_id . ' deactivated successfully');
			redirect('dashboard');
		}


		public function activate($user_id)
		{
			$this->db->delete('users_deactivated', array('user_id' => $user_id));
			$this->session->set_flashdata('message', 'User ' . $user_id . ' reactivated successfully');
			redirect('dashboard');
		}


		public function deactivated()
		{
			$deactivated_users = $this->gsm_model->get_deactivated_users();

			$table = new Table('table table-hover table-bordered');
			$table_header = new TableHeader();
			$table_body = new TableBody();

			$table->add_header($table_header);
			$table->add_body($table_body);

			$row = new TableRow();
			$row->add_tabledata(new TableData('ID'));
			$row->add_tabledata(new TableData('Name'));
			$row->add_tabledata(new TableData('Payment date'));
			$row->add_tabledata(new TableData('Payment valid until'));
			$row->add_tabledata(new TableData('Acoes'));
			$table_header->set_table_row($row);

			foreach($deactivated_users->result() as $user)
			{
				$row = new TableRow();

				$row->set_class('info');

				$row->add_tabledata(new TableData($user->id));
				$row->add_tabledata(new TableData($user->first_name . ' ' . $user->last_name));
				$row->add_tabledata(new TableData(($user->payment_date == '' ? 'N/A' : date('F j, Y, g:i a', $user->payment_date))));
				$row->add_tabledata(new TableData(($user->payment_date == '' ? 'N/A' : date('F j, Y, g:i a', $user->payment_valid_until))));
				$row->add_tabledata(new TableData('<a class="btn btn-mini" href="' . base_url('users/detail/' . $user->id) . '"><strong>Mais informacoes</strong></a>'));


				$table_body->add_table_row($row);
			}

			$this->load->view('header_view');
			$this->load->view('users_deactivated_view', array('table' => $table));
			$this->load->view('footer_view');
		}

	}