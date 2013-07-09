<?php  if (! defined ('BASEPATH'))
	exit('No direct script access allowed');
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/8/13
	 * Time: 4:30 PM
	 * To change this template use File | Settings | File Templates.
	 */
	$config['gsm_payment_options']            = array('name' => '7 dias', 'value' => 604800);
	$config['gsm_payment_options']            = array('name' => '14 dias', 'value' => 1209600);
	$config['gsm_payment_options']            = array('name' => '30 dias', 'value' => 2592000);
	$config['gsm_payment_options']            = array('name' => '60 dias', 'value' => 5184000);
	$config['gsm_payment_date_format']        = 'Testing config';
	$config['gsm_payment_valid_until_format'] = 'Testing config';