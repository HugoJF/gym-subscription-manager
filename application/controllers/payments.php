<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/7/13
	 * Time: 3:48 AM
	 * To change this template use File | Settings | File Templates.
	 */
	class Payments extends CI_Controller
	{
		public function index()
		{
			$the_user  = $this->ion_auth->user()->row();
			$user_info = $this->gsm_model->get_user($the_user->id);
			$payments  = $this->gsm_model->get_payments($the_user->id);


			$this->load->view('header_view');
			echo '<pre>';
			print_r($user_info->result());
			print_r($payments->result());
			echo '</pre>';
			$this->load->view('footer_view');
		}

		public function add($user_id = -1)
		{
			if($user_id == - 1)
			{
				redirect(base_url('dashboard'));
			}
			$this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');
			$this->form_validation->set_rules('payment_time', 'Tempo do pagamento', 'required');
			$this->form_validation->set_rules('payment_method', 'Metodo de pagamento', 'required');

			if($this->form_validation->run() == TRUE)
			{
				//Is adding payment go confirm
				if(isset($_POST['confirmed']))
				{
					if($_POST['payment_method'] == 'renew')
					{
						//The new payment date equals today
						list($period, $method) = explode('|', $_POST['payment_time']);
						if($method == 'period_sum')
						{
							//payment time is int = adding perion only
							$date        = time();
							$valid_until = time() + $period;
						}
						else if($method == 'maintain_day')
						{
							//maintaining payment day
							$date          = time();
							$date_formated = date('H-i-s-m-j-Y', $date);
							list($hour, $minute, $second, $month, $day, $year) = explode('-', $date_formated);
							$valid_until = mktime($hour, $minute, $second, $month + $period, $day, $year);
						}
						$data = array('date'        => $date,
									  'valid_until' => $valid_until,
									  'user_id'     => $user_id);
						$this->db->insert('payments', $data);
						$this->session->set_flashdata('message', 'Payment added successfully');
						redirect('dashboard');
					}
					else if($_POST['payment_method'] == 'extend')
					{
						//The new payment date equals last payments expiration
						list($period, $method) = explode('|', $_POST['payment_time']);
						$user = $this->ion_auth->user()->row();
						if($method == 'period_sum')
						{
							//payment time is int = adding perion only
							$date        = time();
							$valid_until = $user->last_payment_valid_until + $period;
						}
						else if($method == 'maintain_day')
						{
							//maintaining payment day
							$date          = time();
							$date_formated = date('H-i-s-m-j-Y', $user->last_payment_valid_until);
							list($hour, $minute, $second, $month, $day, $year) = explode('-', $date_formated);
							$valid_until = mktime($hour, $minute, $second, $month + $period, $day, $year);
						}
						$data = array('date'        => $date,
									  'valid_until' => $valid_until,
									  'user_id'     => $user_id);
						$this->db->insert('payments', $data);
						$this->session->set_flashdata('message', 'Payment added successfully');
						redirect('dashboard');
					}
					else
					{
						$this->session->set_flashdata('error', 'Payment method was not set properly, please contact administrator');
						redirect('dashboard');
					}
				}
				else
				{
					//Open confirmation window
					$this->load->view('header_view');
					$this->load->view('payments_add_conf_view', array('user' => $this->gsm_model->get_user($user_id, TRUE)->first_row()));
					$this->load->view('footer_view');
				}
			}
			else
			{
				$this->load->view('header_view');
				$this->load->view('payments_add_view', array('user' => $this->gsm_model->get_user($user_id, TRUE)->first_row()));
				$this->load->view('footer_view');
			}
		}
	}