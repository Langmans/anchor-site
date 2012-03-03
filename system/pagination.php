<?php namespace System;

/**
 * PeachyPhp
 *
 * Just another PHP Framework
 *
 * @package		peachy-php
 * @author		k. wilson
 * @link		http://peachy-php.co.uk
 */

class Pagination {

	public $base_url = '';
	public $total_rows = '';
	public $per_page = 10;
	public $num_links = 2;
	public $cur_page =  0;

	public $next_link  = '&gt;';
	public $prev_link = '&lt;';
	
	public $last_link  = '&gt;&gt;';
	public $first_link = '&lt;&lt;';

	public $cur_tag_open = '<strong>';
	public $cur_tag_close = '</strong>';

	public $next_tag_open = '';
	public $next_tag_close = '';

	public $prev_tag_open = '';
	public $prev_tag_close = '';

	public $num_tag_open = '';
	public $num_tag_close = '';
	
	public $first_tag_open = '';
	public $first_tag_close = '';
	
	public $last_tag_open = '';
	public $last_tag_close = '';

	public function initialise($params = array()) {
		foreach($params as $key => $val) {
			if(isset($this->$key))  {
				$this->$key = $val;
			}
		}
	}

	public function create() {
		$pagination = '';
		$pages = ceil($this->total_rows / $this->per_page);

		// make sure we have pages to create
		if($this->total_rows > $this->per_page) {

			if($this->cur_page >= $this->per_page) {
				// First link
				$pagination .= $this->first_tag_open . ' <a href="' . $this->base_url . '0">' . $this->first_link . '</a> ' . $this->first_tag_close;

				// Previous link
				$pagination .= $this->prev_tag_open . ' <a href="' . $this->base_url . ($this->cur_page - $this->per_page) . '">' . $this->prev_link . '</a> ' . $this->prev_tag_close;
			}

			// Pages
			$range = ($this->num_links * $this->per_page);

			for($i = 0; $i < $pages; $i++) {
				$page = $i + 1;
				$page_offset = ($this->per_page * $i);

				if($page_offset == $this->cur_page) {
					$pagination .= $this->cur_tag_open . $page . $this->cur_tag_close;
				} 
				elseif(($page_offset >= $this->cur_page - $range) and ($page_offset <= $this->cur_page + $range)) {
					$pagination .= $this->num_tag_open . ' <a href="' . $this->base_url . $page_offset . '">' . $page . '</a> ' . $this->num_tag_close;
				}
			}

			if($this->cur_page < (($pages - 1) * $this->per_page)) {
				// Next link
				$pagination .= $this->next_tag_open . ' <a href="' . $this->base_url . ($this->cur_page + $this->per_page) . '">' . $this->next_link . '</a> ' . $this->next_tag_close;
			
				// Last link
				$pagination .= $this->last_tag_open . ' <a href="' . $this->base_url . (($pages - 1) * $this->per_page) . '">' . $this->last_link . '</a> ' . $this->last_tag_close;
			}
		}

		return $pagination;
	}

}

/* End of file */
