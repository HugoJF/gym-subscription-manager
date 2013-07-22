<?php  if(! defined('BASEPATH'))
	exit('No direct script access allowed');

	class TableBuilder
	{

	}


	/********
	| TABLE |
	 *******/

	class Table
	{

		private $table_head;

		private $table_body;

		private $table;

		private $class;

		private $id;

		private $name;

		private $description;


		/**
		 * @param string $class
		 * @param string $id
		 */
		function __construct($class = '', $id = '')
		{
			$this->class = $class;
			$this->id    = $id;
		}


		/**
		 * @param TableHeader $table_header
		 *
		 * @return $this
		 */
		public function add_header(TableHeader $table_header)
		{
			$this->table_head = $table_header;

			return $this;
		}


		/**
		 * @param TableBody $table_body
		 *
		 * @return $this
		 */
		public function add_body(TableBody $table_body)
		{
			$this->table_body = $table_body;

			return $this;
		}


		/**
		 * @return string
		 */
		public function get()
		{
			$this->table = '';
			$this->table .= '<table class="' . $this->class . '" id="' . $this->id . '">';
			$this->table .= $this->table_head->get();
			$this->table .= $this->table_body->get();
			$this->table .= '</table>';

			return $this->table;
		}


		/**
		 * @param string $name
		 *
		 * @return string
		 */
		public function set_name($name = '')
		{
			$this->name = $name;

			return $this->name;
		}


		/**
		 * @param string $description
		 *
		 * @return string
		 */
		public function set_description($description = '')
		{
			$this->description = $description;

			return $this->description;
		}


		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public function set_class($class = '')
		{
			$this->class = $class;

			return $this->class;
		}


		/**
		 * @param string $id
		 *
		 * @return string
		 */
		public function set_id($id = '')
		{
			$this->id = $id;

			return $this->id;
		}


		/**
		 * @return mixed
		 */
		public function get_name()
		{
			return $this->name;
		}


		/**
		 * @return mixed
		 */
		public function get_description()
		{
			return $this->description;
		}


		/**
		 * @return string
		 */
		public function get_class()
		{
			return $this->class;
		}


		/**
		 * @return string
		 */
		public function get_id()
		{
			return $this->id;
		}


		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public function add_class($class = '')
		{
			$this->class .= ' ' . $class;

			return $this->id;
		}


		/**
		 * @param string $id
		 */
		public function add_id($id = '')
		{
			$this->id .= ' ' . $id;
		}

	}


	/***************
	| TABLE HEADER |
	 **************/

	class TableHeader
	{

		private $table_row;

		private $class;

		private $id;

		private $open_tag;

		private $close_tag;

		private $content;

		private $table_header;


		/**
		 * @param string $class
		 * @param string $id
		 * @param string $open_tag
		 * @param string $close_tag.
		 */
		public function __construct($class = '', $id = '', $open_tag = '<thead>', $close_tag = '</thead>')
		{
			$this->class     = $class;
			$this->id        = $id;
			$this->open_tag  = $open_tag;
			$this->close_tag = $close_tag;
			$this->content   = '';
		}


		/**
		 * @param TableRow $tr
		 *
		 * @return $this|bool
		 */
		public function set_table_row(TableRow $tr)
		{
			if(isset($tr))
			{
				$this->table_row = $tr;

				return $this;
			}
			else
			{
				return FALSE;
			}
		}


		/**
		 * @return string
		 */
		public function get()
		{
			if(! isset($this->content) || $this->content == '')
			{
				//$this->table_row->set_data_open_tag('<th>');
				//$this->table_row->set_data_close_tag('</th>');
				foreach($this->table_row as $tr)
				{
					$tr->set_open_tag('<th>');
					$tr->set_close_tag('/th>');
				}
				$this->content = $this->table_row->get();
			}
			$this->table_header = '';
			$this->table_header .= substr($this->open_tag, 0, - 1);
			$this->table_header .= ' class="' . $this->class . '"';
			$this->table_header .= ' id="' . $this->id . '"';
			$this->table_header .= '>';
			$this->table_header .= $this->content;
			$this->table_header .= $this->close_tag;

			return $this->table_header;
		}


		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public function set_class($class = '')
		{
			$this->class = $class;

			return $this->class;
		}


		/**
		 * @param string $id
		 *
		 * @return string
		 */
		public function set_id($id = '')
		{
			$this->id = $id;

			return $this->id;
		}


		/**
		 * @param string $open_tag
		 *
		 * @return string
		 */
		public function set_open_tag($open_tag = '')
		{
			$this->open_tag = $open_tag;

			return $this->open_tag;
		}


		/**
		 * @param string $close_tag
		 *
		 * @return string
		 */
		public function set_close_tag($close_tag = '')
		{
			$this->close_tag = $close_tag;

			return $this->close_tag;
		}


		/**
		 * @return string
		 */
		public function get_class()
		{
			return $this->class;
		}


		/**
		 * @return string
		 */
		public function get_id()
		{
			return $this->id;
		}


		/**
		 * @return string
		 */
		public function get_open_tag()
		{
			return $this->open_tag;
		}


		/**
		 * @return string
		 */
		public function get_close_tag()
		{
			return $this->close_tag;
		}


		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public function add_class($class = '')
		{
			$this->class .= ' ' . $class;

			return $this->id;
		}


		/**
		 * @param string $id
		 */
		public function add_id($id = '')
		{
			$this->id .= ' ' . $id;
		}

	}


	/*************
	| TABLE BODY |
	 ************/

	class TableBody
	{

		private $table_rows;

		private $class;

		private $id;

		private $open_tag;

		private $close_tag;

		private $content;


		/**
		 * @param string $class
		 * @param string $id
		 * @param string $open_tag
		 * @param string $close_tag
		 */
		public function __construct($class = '', $id = '', $open_tag = '<tbody>', $close_tag = '</tbody>')
		{
			$this->table_rows = array();
			$this->class      = $class;
			$this->id         = $id;
			$this->open_tag   = $open_tag;
			$this->close_tag  = $close_tag;
		}


		/**
		 * @param TableRow $tr
		 *
		 * @return $this
		 */
		public function add_table_row(TableRow $tr)
		{
			if(isset($tr))
			{
				array_push($this->table_rows, $tr);

				return $this;
			}
		}


		/**
		 * @return string
		 */
		public function get()
		{
			if(! isset($this->content) || sizeof($this->content) == 0)
			{
				foreach($this->table_rows as $td)
				{
					$this->content .= $td->get();
				}
			}
			$this->table_body = '';
			$this->table_body .= substr($this->open_tag, 0, - 1);
			$this->table_body .= ' class="' . $this->class . '" ';
			$this->table_body .= ' id="' . $this->id . '" ';
			$this->table_body .= '>';
			$this->table_body .= $this->content;
			$this->table_body .= $this->close_tag;

			return $this->table_body;
		}


		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public function set_class($class = '')
		{
			$this->class = $class;

			return $this->class;
		}


		/**
		 * @param string $id
		 *
		 * @return string
		 */
		public function set_id($id = '')
		{
			$this->id = $id;

			return $this->id;
		}


		/**
		 * @param string $open_tag
		 *
		 * @return string
		 */
		public function set_open_tag($open_tag = '')
		{
			$this->open_tag = $open_tag;

			return $this->open_tag;
		}


		/**
		 * @param string $close_tag
		 *
		 * @return string
		 */
		public function set_close_tag($close_tag = '')
		{
			$this->close_tag = $close_tag;

			return $this->close_tag;
		}


		/**
		 * @return string
		 */
		public function get_class()
		{
			return $this->class;
		}


		/**
		 * @return string
		 */
		public function get_id()
		{
			return $this->id;
		}


		/**
		 * @return string
		 */
		public function get_open_tag()
		{
			return $this->open_tag;
		}


		/**
		 * @return string
		 */
		public function get_close_tag()
		{
			return $this->close_tag;
		}


		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public function add_class($class = '')
		{
			$this->class .= ' ' . $class;

			return $this->id;
		}


		/**
		 * @param string $id
		 */
		public function add_id($id = '')
		{
			$this->id .= ' ' . $id;
		}

	}


	/***********
	| TableRow |
	 **********/

	class TableRow
	{

		private $class;

		private $id;

		private $open_tag;

		private $close_tag;

		private $table_datas;

		private $table_row;

		private $content;


		/**
		 * @param string $class
		 * @param string $id
		 * @param string $open_tag
		 * @param string $closed_tag
		 */
		public function __construct($class = '', $id = '', $open_tag = '<tr>', $closed_tag = '</tr>')
		{
			$this->table_datas = array();
			$this->class       = $class;
			$this->id          = $id;
			$this->open_tag    = $open_tag;
			$this->close_tag   = $closed_tag;

			return $this;
		}


		/**
		 * @param TableData $td
		 *
		 * @return bool
		 */
		public function add_tabledata(TableData $td)
		{
			if(isset($td))
			{
				array_push($this->table_datas, $td);

				return $this;
			}
		}


		/**
		 * @param TableData $td
		 */
		public function add_data(TableData $td)
		{
			$this->add_tabledata($td);
		}


		/**
		 * @param TableData $td
		 */
		public function add_column(TableData $td)
		{
			$this->add_tabledata($td);
		}


		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public function set_class($class = '')
		{
			$this->class = $class;

			return $this->class;
		}


		/**
		 * @param string $id
		 *
		 * @return string
		 */
		public function set_id($id = '')
		{
			$this->id = $id;

			return $this->id;
		}


		/**
		 * @param string $open_tag
		 *
		 * @return string
		 */
		public function set_open_tag($open_tag = '')
		{
			$this->open_tag = $open_tag;

			return $this->open_tag;
		}


		/**
		 * @param string $close_tag
		 *
		 * @return string
		 */
		public function set_close_tag($close_tag = '')
		{
			$this->close_tag = $close_tag;

			return $this->close_tag;
		}


		/**
		 * @return string
		 */
		public function get_class()
		{
			return $this->class;
		}


		/**
		 * @return string
		 */
		public function get_id()
		{
			return $this->id;
		}


		/**
		 * @return string
		 */
		public function get_open_tag()
		{
			return $this->open_tag;
		}


		/**
		 * @return string
		 */
		public function get_close_tag()
		{
			return $this->close_tag;
		}


		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public function add_class($class = '')
		{
			$this->class .= ' ' . $class;

			return $this->id;
		}


		/**
		 * @param string $id
		 */
		public function add_id($id = '')
		{
			$this->id .= ' ' . $id;
		}


		/**
		 * @param string $open_tag
		 */
		public function set_data_open_tag($open_tag = '<td>')
		{
			foreach($this->table_datas as $td)
			{
				$td->set_open_tag($open_tag);
			}
		}


		/**
		 * @param string $close_tag
		 */
		public function set_data_close_tag($close_tag = '</td>')
		{
			foreach($this->table_datas as $td)
			{
				$td->set_close_tag($close_tag);
			}
		}


		/**
		 * @return string
		 */
		public function get()
		{
			if(! isset($this->content))
			{
				foreach($this->table_datas as $td)
				{
					$this->content .= $td->get();
				}
			}
			$this->table_row = '';
			$this->table_row .= substr($this->open_tag, 0, - 1);
			$this->table_row .= ' class="' . $this->class . '" ';
			$this->table_row .= ' id="' . $this->id . '" ';
			$this->table_row .= '>';
			$this->table_row .= $this->content;
			$this->table_row .= $this->close_tag;

			return $this->table_row;
		}
	}


	/************
	| TableData |
	 ***********/
	class TableData
	{

		private $content;

		private $open_tag;

		private $close_tag;

		private $class;

		private $id;


		/**
		 * @param        $content
		 * @param string $open_tag
		 * @param string $close_tag
		 * @param string $class
		 * @param string $id
		 */
		public function __construct($content, $class = '', $id = '', $open_tag = '<td>', $close_tag = '</td>')
		{
			$this->content   = $content;
			$this->open_tag  = $open_tag;
			$this->close_tag = $close_tag;
			$this->class     = $class;
			$this->id        = $id;
		}


		/**
		 * @return string
		 */
		public function get()
		{
			$this->table_data = '';
			$this->table_data .= substr($this->open_tag, 0, - 1);
			$this->table_data .= ' class="' . $this->class . '" ';
			$this->table_data .= ' id="' . $this->id . '" ';
			$this->table_data .= '>';
			$this->table_data .= $this->content;
			$this->table_data .= $this->close_tag;

			return $this->table_data;
		}


		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public function set_class($class = '')
		{
			$this->class = $class;

			return $this->class;
		}


		/**
		 * @param string $id
		 *
		 * @return string
		 */
		public function set_id($id = '')
		{
			$this->id = $id;

			return $this->id;
		}


		/**
		 * @param string $open_tag
		 *
		 * @return string
		 */
		public function set_open_tag($open_tag = '')
		{
			$this->open_tag = $open_tag;

			return $this->open_tag;
		}


		/**
		 * @param string $close_tag
		 *
		 * @return string
		 */
		public function set_close_tag($close_tag = '')
		{
			$this->close_tag = $close_tag;

			return $this->close_tag;
		}


		/**
		 * @return string
		 */
		public function get_class()
		{
			return $this->class;
		}


		/**
		 * @return string
		 */
		public function get_id()
		{
			return $this->id;
		}


		/**
		 * @return string
		 */
		public function get_open_tag()
		{
			return $this->open_tag;
		}


		/**
		 * @return string
		 */
		public function get_close_tag()
		{
			return $this->close_tag;
		}


		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public function add_class($class = '')
		{
			$this->class .= ' ' . $class;

			return $this->id;
		}


		/**
		 * @param string $id
		 */
		public function add_id($id = '')
		{
			$this->id .= ' ' . $id;
		}
	}

