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
				$user_id = $query->row()->id;
			}
			$user     = $this->gsm_model->get_user($user_id, TRUE)->first_row();
			$payments = $this->gsm_model->get_payments($user_id);
			$this->load->view('header_view');
			$this->load->view('users_detail_view', array('user' => $user, 'payments' => $payments));
			$this->load->view('footer_view');
		}


		public function edit($user_id = -1)
		{
			$this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');
			$this->form_validation->set_rules('sending', 'token', 'required');

			$user = $this->ion_auth->user($user_id)->row();

			if($this->form_validation->run() == TRUE)
			{
				$data = array('email'      => ($_POST['email'] != '' ? $_POST['email'] : $user->email),
							  'first_name' => ($_POST['first_name'] != '' ? $_POST['first_name'] : $user->first_name),
							  'last_name'  => ($_POST['last_name'] != '' ? $_POST['last_name'] : $user->last_name));
				if(! empty($_POST['group']) && $_POST['group'] != - 1)
				{
					if(!$this->ion_auth->remove_from_group(NULL, $user_id))
					{
						$this->session->set_flashdata('error', 'Error removing user from groups');
						redirect('dashboard');
					}
					if(!$this->ion_auth_model->add_to_group($_POST['group'], $user_id))
					{
						$this->session->set_flashdata('error', 'Error adding user to group');
						redirect('dashboard');
					}
				}
				if($this->ion_auth->update($user_id, $data) == TRUE)
				{
					$this->session->set_flashdata('message', 'User edited successfully');
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
				}
				redirect('dashboard');
			}
			else
			{
				$this->load->view('header_view');
				$this->load->view('users_edit_view', array('user'   => $user,
														   'groups' => $this->ion_auth->groups()->result()));
				$this->load->view('footer_view');
			}
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
					$this->session->set_flashdata('message', 'User ' . $username . ' created successfully');
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

		public function register()
		{
			$this->add();
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

			$table        = new Table('table table-hover table-bordered');
			$table_header = new TableHeader();
			$table_body   = new TableBody();

			$table->add_child($table_header);
			$table->add_child($table_body);

			$row = new TableRow();
			$td = new TableData();
			$row->add_child($td->add_child('ID'));
			$td = new TableData();
			$row->add_child($td->add_child('Name'));
			$td = new TableData();
			$row->add_child($td->add_child('Payment date'));
			$td = new TableData();
			$row->add_child($td->add_child('Payment valid until'));
			$td = new TableData();
			$row->add_child($td->add_child('Acoes'));
			$table_header->add_child($row);

			foreach($deactivated_users->result() as $user)
			{
				$row = new TableRow();

				$row->set_class('info');

				$td = new TableData();
				$row->add_child($td->add_child($user->id));
				$td = new TableData();
				$row->add_child($td->add_child($user->first_name . ' ' . $user->last_name));
				$td = new TableData();
				$row->add_child($td->add_child(($user->payment_date == '' ? 'N/A' : date('F j, Y, g:i a', $user->payment_date))));
				$td = new TableData();
				$row->add_child($td->add_child(($user->payment_date == '' ? 'N/A' : date('F j, Y, g:i a', $user->payment_valid_until))));
				$td = new TableData();
				$row->add_child($td->add_child('<a class="btn btn-mini btn-success" href="' . base_url('users/activate/' . $user->id) . '">Ativar usuario</a><a class="btn btn-mini" href="' . base_url('users/detail/' . $user->id) . '"><strong>Mais informacoes</strong></a>'));

				$table_body->add_child($row);
			}

			$this->load->view('header_view');
			$this->load->view('users_deactivated_view', array('table' => $table));
			$this->load->view('footer_view');
		}

	}