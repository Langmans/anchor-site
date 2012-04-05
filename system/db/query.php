<?php namespace System\Db;

/**
 * PeachyPhp
 *
 * Just another PHP Framework
 *
 * @package		peachy-php
 * @author		k. wilson
 * @link		http://peachy-php.co.uk
 */

use System\Db;
use System\Str;

class Query {

	private $sql = '';
	private $bindings = array();
	private $wrapper = '`';

	private $select = '';
	private $from = '';
	private $join = '';
	private $where = '';
	private $group = '';
	private $order = '';
	private $limit = '';
	private $offset = '';

	private function wrap($value) {
		// remove white space
		$column = trim($value);
		
		// handle aliases
		if(strpos(strtolower($column), ' as ') !== false) {
			list($col, $alias) = explode(' as ', strtolower($column));
			return $this->wrap($col) . ' AS ' . $this->wrap($alias);
		}
		
		// dont wrap function calls
		if(preg_match('/[a-z]+\(.*?\)/i', $column)) {
			return $column;
		}
		
		foreach(explode('.', $column) as $segment) {
			$sql[] = ($segment !== '*') ? $this->wrapper . $segment . $this->wrapper : $segment;
		}

		return implode('.', $sql);
	}

	private function columnizer($value) {
		if(is_array($value)) {
			foreach($value as $column) {
				$sql[] = $this->wrap($column);
			}

			return implode(', ', $sql);
		}

		return $this->wrap($value);
	}
	
	public static function make() {
		return new static;
	}

	public function insert($table, $data) {
		foreach($data as $k => $v) {
			$keys[] = $this->wrap($k);
			$binds[] = '?';
			$this->bindings[] = $v;
		}

		$this->sql = 'INSERT INTO ' . $this->wrap($table) . ' (' . implode(', ', $keys) . ') values (' . implode(', ', $binds) . ')';

		return $this;
	}

	public function update($table, $data) {
		foreach($data as $k => $v) {
			$update[] = $this->wrap($k) . ' = ?';
			$this->bindings[] = $v;
		}

		$this->sql = 'UPDATE ' . $this->wrap($table) . ' SET ' . implode(', ', $update);

		return $this;
	}

	public function delete($table) {
		$this->sql = 'DELETE FROM ' . $this->wrap($table);
		return $this;
	}
	
	public function count() {
		$this->select = 'SELECT count(*)';
		return $this;
	}

	public function select($columns = '*') {
		$this->select = 'SELECT ' . $this->columnizer($columns);
		return $this;
	}
	
	public function from($table) {
		$this->from = ' FROM ' . $this->wrap($table);
		return $this;
	}
	
	public function from_select(Query $query, $alias) {
		$this->from = ' FROM (' . $query->sql() . ') AS ' . $alias;
		$this->bindings = array_merge($this->bindings, $query->bindings());
		return $this;
	}

	public function join($table, $left, $right) {
		$this->join .= ' JOIN ' . $this->wrap($table) . ' ON (' . $this->wrap($left) . ' = ' . $this->wrap($right) . ')';
		return $this;
	}

	public function left_join($table, $left, $right) {
		$this->join .= ' LEFT JOIN ' . $this->wrap($table) . ' ON (' . $this->wrap($left) . ' = ' . $this->wrap($right) . ')';
		return $this;
	}

	public function where($column, $value, $operator = '=') {
		$this->where .= (empty($this->where) ? ' WHERE ' : ' AND ') . $this->wrap($column) . ' ' . $operator . ' ?';
		$this->bindings[] = $value;
		return $this;
	}

	public function where_and($column, $value, $operator = '=') {
		$this->where .= ' AND ' . $this->wrap($column) . ' ' . $operator . ' ?';
		$this->bindings[] = $value;
		return $this;
	}

	public function where_or($column, $value, $operator = '=') {
		$this->where .= ' OR ' . $this->wrap($column) . ' ' . $operator . ' ?';
		$this->bindings[] = $value;
		return $this;
	}

	public function orderby($column, $mode = 'ASC') {
		$this->order = ' ORDER BY ' . $this->wrap($column) . ' ' . Str::upper($mode);
		return $this;
	}

	public function limit($num) {
		$this->limit = ' LIMIT ' . $num;
		return $this;
	}

	public function offset($num) {
		$this->offset = ' OFFSET ' . $num;
		return $this;
	}

	public function groupby($column) {
		$this->group = ' GROUP BY ' . $this->wrap($column);
		return $this;
	}

	public function sql() {
		return 
			$this->sql . 
			$this->select . 
			$this->from . 
			$this->join . 
			$this->where . 
			$this->group . 
			$this->order . 
			$this->limit . 
			$this->offset;
	}
	
	public function bindings() {
		return $this->bindings;
	}
	
	public function bind($value) {
		$this->bindings[] = $value;
	}
	
	public function go() {
		return Db::exec($this->sql(), $this->bindings());
	}
	
	public function col() {
		return Db::query($this->sql(), $this->bindings())->fetchColumn();
	}
	
	public function row($fetch_style = \PDO::FETCH_OBJ) {
		return Db::row($this->sql(), $this->bindings(), $fetch_style);
	}
	
	public function results($fetch_style = \PDO::FETCH_OBJ) {
		return Db::results($this->sql(), $this->bindings(), $fetch_style);
	}

}

/* End of file */
