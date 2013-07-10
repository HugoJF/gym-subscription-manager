<?php  if(! defined('BASEPATH'))
	exit('No direct script access allowed');
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/8/13
	 * Time: 4:30 PM
	 * To change this template use File | Settings | File Templates.
	 */
	$config['gsm_payment_options']            = array(array('name' => '7 dias', 'value' => 604800),
													  array('name' => '14 dias', 'value' => 1209600),
													  array('name' => '30 dias', 'value' => 2592000),
													  array('name' => '60 dias', 'value' => 5184000));
	$config['gsm_payment_date_format']        = 'l j \of F Y';
	$config['gsm_payment_valid_until_format'] = 'l j \of F Y';
	$config['gsm_payment_date_detail_format']        = 'l jS \of F Y h:i:s A';
	$config['gsm_payment_valid_until_detail_format'] = 'l jS \of F Y h:i:s A';
	$config['gsm_password_payment_required']  = FALSE;
	$config['gsm_payment_warning_time']       = 604800;
	$config['gsm_users_per_page']             = 20;
	$config['gsm_pagination_links']           = 10;
