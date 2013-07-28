<?php  if(! defined('BASEPATH'))
	exit('No direct script access allowed');

	class TableBuilder
	{

	}


	/********
	| TABLE |
	 *******/

	class Table extends HTMLElement
	{

		private $name;
		private $description;
		private $empty;
		private $pagination;


		public function set_name($name)
		{
			$this->name = $name;

			return $this;
		}


		public function get_name()
		{
			return $this->name;
		}


		public function set_description($desc)
		{
			$this->description = $desc;

			return $this;
		}


		public function get_description()
		{
			return $this->description;
		}


		public function set_empty($empty)
		{
			$this->empty = $empty;

			return $this;
		}


		public function is_empty()
		{
			return $this->empty;
		}


		public function add_pagination($pagination)
		{
			$this->pagination = $pagination;

			return $this;
		}


		function __construct($class = '', $id = '')
		{
			parent::__construct('<table>', '</table>', $class, $id);
		}


		public function get_element_html()
		{
			if($this->is_empty())
			{
				return '<span style="width:auto;" class="label label-important">Nao ha mais usuarios nesta pagina</span>' . $this->pagination;
			}

			return parent::get_element_html() . $this->pagination;
		}
	}


	/***************
	| TABLE HEADER |
	 **************/

	class TableHeader extends HTMLElement
	{

		public function __construct($class = '', $id = '')
		{
			parent::__construct('<thead>', '</thead>', $class, $id);
		}

	}


	/*************
	| TABLE BODY |
	 ************/

	class TableBody extends HTMLElement
	{

		public function __construct($class = '', $id = '')
		{
			parent::__construct('<tbody>', '</tbody>', $class, $id);
		}

	}


	/***********
	| TableRow |
	 **********/

	class TableRow extends HTMLElement
	{

		public function __construct($class = '', $id = '')
		{
			parent::__construct('<tr>', '</tr>', $class, $id);
		}
	}


	/************
	| TableData |
	 ***********/
	class TableData extends HTMLElement
	{

		public function __construct($class = '', $id = '')
		{
			parent::__construct('<td>', '</td>', $class, $id);
		}
	}


	class HTMLElement
	{

		private $open_tag;
		private $close_tag;
		private $class;
		private $id;
		private $extra_attr;
		private $html;
		private $childs;


		public function __construct($open_tag, $close_tag, $class = '', $id = '')
		{
			$this->open_tag   = $open_tag;
			$this->close_tag  = $close_tag;
			$this->class      = $class;
			$this->id         = $id;
			$this->extra_attr = '';
			$this->html       = '';
			$this->childs     = array();

			return $this;
		}


		public function set_open_tag($open_tag)
		{
			$this->open_tag = $open_tag;

			return $this;
		}


		public function get_open_tag()
		{
			return $this->open_tag;
		}


		public function set_close_tag($close_tag)
		{
			$this->close_tag = $close_tag;

			return $this;
		}


		public function get_close_tag()
		{
			return $this->close_tag;
		}


		public function set_class($class)
		{
			$this->class = $class;

			return $this;
		}


		public function add_class($class)
		{
			$this->class .= ' ' . $class;

			return $this;
		}


		public function get_class()
		{
			return $this->class;
		}


		public function set_id($id)
		{
			$this->id = $id;

			return $this;
		}


		public function add_id($id)
		{
			$this->id .= ' ' . $id;

			return $this;
		}


		public function get_id()
		{
			return $this->id;
		}


		public function set_extra_attr($extra_attr)
		{
			$this->extra_attr = $extra_attr;

			return $this;
		}


		public function get_extra_attr()
		{
			return $this->extra_attr;
		}


		public function add_extra_attr($extra_attr)
		{
			$this->extra_attr .= ' ' . $extra_attr;
		}


		public function set_content($content)
		{
			$this->content = $content;

			return $this;
		}


		public function get_content()
		{
			return $this->content;
		}


		public function get_child($i)
		{
			return (isset($this->childs[$i]) ? $this->childs[$i] : NULL);
		}


		public function add_child($child)
		{
			array_push($this->childs, $child);

			return $this;
		}


		public function get_element_html()
		{
			$this->html = '';
			$this->html .= substr($this->open_tag, 0, - 1);
			$this->html .= ' class="' . $this->class . '" ';
			$this->html .= ' id="' . $this->id . '" ';
			$this->html .= '>';
			foreach($this->childs as $child)
			{
				if(method_exists($child, 'get_element_html'))
				{
					$this->html .= $child->get_element_html();
				}
				else
				{
					$this->html .= $child;
				}
			}
			$this->html .= $this->close_tag;

			return $this->html;
		}
	}

