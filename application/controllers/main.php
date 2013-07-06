<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Hugo
	 * Date: 7/5/13
	 * Time: 6:48 PM
	 * To change this template use File | Settings | File Templates.
	 */
	class Main extends CI_Controller {
		public function index() {
			if ($this->ion_auth->logged_in()) {
				redirect(base_url('dashboard'));
			} else {
				redirect(base_url('login'));
			}
		}
	}