<?php  if(! defined('BASEPATH'))
	exit('No direct script access allowed');
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/8/13
	 * Time: 4:30 PM
	 * To change this template use File | Settings | File Templates.
	 */
	$config['gsm_payment_options']            = array(array('name' => '7 dias', 'value' => 60 * 60 * 24 * 7),
													  array('name' => '14 dias', 'value' => 60 * 60 * 24 * 14),
													  array('name' => '30 dias', 'value' => 60 * 60 * 24 * 30),
													  array('name' => '60 dias', 'value' => 60 * 60 * 24 * 60));
	$config['gsm_payment_date_format']        = 'l j \of F Y';
	$config['gsm_payment_valid_until_format'] = 'l j \of F Y';
	$config['gsm_payment_date_detail_format']        = 'l jS \of F Y h:i:s A';
	$config['gsm_payment_valid_until_detail_format'] = 'l jS \of F Y h:i:s A';
	$config['gsm_payments_add_conf_remaining_format'] = 'l j \of F Y';
	$config['gsm_password_payment_required']  = FALSE;
	$config['gsm_payment_warning_time']       = 60 * 60 * 2;
	$config['gsm_users_per_page']             = 20;
	$config['gsm_pagination_links']           = 5;
