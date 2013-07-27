<?php

	class Paginator
	{

	}


	class Pagination
	{

		//Option variables
		private $link_number;
		private $show_first;
		private $show_last;
		private $current_page;
		private $max_pages;

		//Working variables
		private $starting_page;
		private $ending_page;
		private $html;


		/**
		 * @param int  $link_number - Number of page links total to show
		 * @param bool $show_first - Show shortcut to first page
		 * @param bool $show_last - Show showrtcut to last page(requires max_pages set)
		 * @param int  $current_page - The current page
		 * @param null $max_pages - Max number of pages
		 */
		public function __construct($link_number = 5, $show_first = TRUE, $show_last = TRUE, $current_page = 1, $max_pages = NULL)
		{
			$this->link_number  = $link_number;
			$this->show_first   = $show_first;
			$this->show_last    = $show_last;
			$this->current_page = $current_page;
			$this->max_pages    = $max_pages;
		}


		/**
		 * @return int
		 */
		public function get_link_number()
		{
			return $this->link_number;
		}


		/**
		 * @return bool
		 */
		public function get_show_first()
		{
			return $this->show_first;
		}


		/**
		 * @return bool
		 */
		public function get_show_last()
		{
			return $this->show_last;
		}


		/**
		 * @return int
		 */
		public function get_current_page()
		{
			return $this->current_page;
		}


		/**
		 * @param $link_number
		 *
		 * @return $this
		 */
		public function set_link_number($link_number)
		{
			$this->link_number = $link_number;

			return $this;
		}


		/**
		 * @param $show_first
		 *
		 * @return $this
		 */
		public function set_show_first($show_first)
		{
			$this->show_first = $show_first;

			return $this;
		}


		/**
		 * @param $show_last
		 *
		 * @return $this
		 */
		public function set_show_last($show_last)
		{
			$this->show_last = $show_last;

			return $this;
		}


		/**
		 * @param $current_page
		 *
		 * @return $this
		 */
		public function set_current_page($current_page)
		{
			$this->current_page = $current_page;

			return $this;
		}


		/**
		 * @return string
		 */
		public function get_html()
		{
			$this->html .= '<ul class="pagination">';

			$this->starting_page = $this->current_page - ceil($this->link_number / 2) + 1;
			$this->ending_page   = $this->current_page + floor($this->link_number / 2);

			if($this->starting_page <= 0)
			{
				$this->ending_page -= $this->starting_page - 1;
				$this->starting_page = 1;
			}
			if($this->max_pages != NULL && $this->ending_page > $this->max_pages)
			{
				$this->ending_page = $this->max_pages;
			}
			for($i = $this->starting_page; $i <= $this->ending_page; $i ++)
			{
				$this->html .= "<li><a href=\"#\">$i</a></li>";
			}

			$this->html .= '</ul>';

			return $this->html;
		}
	}