<?php
class Database extends Controller
{
	// database host
	private $_host = HOST;
	// database username
	private $_user = USER;
	// database password
	private $_pass = PASS;
	// database name
	private $_name = NAME;
	// database handler
	public $_dbh;
	// database statement
	public $_stmt;
	// database query like
	public $_like;
	// database query builder
	public $_qb;
	// database query where
	public $_where;
	// database query order by
	public $_order_by;
	// database query limit
	public $_limit;

	public function __construct()
	{
		// set connection
		$dsn = 'mysql:host='.$this->_host.';dbname='.$this->_name;
		$this->_dbh = new PDO($dsn, $this->_user, $this->_pass);
	}

	public function query($query)
	{
		if (isset($query))
		{
			// set manual query sql
			$this->_stmt = $this->_dbh->prepare($query);
		}
	}

	public function insert($table, $data)
	{
		if ($this->_input === false)
		{
			$_SESSION['flasher'] = 'Insert data failed!';
			redirect();
		} else {
			// declare $_value array
			$_value = array();
			// declare $_k array
			$_k = '';
			// put keys in $data array
			$key = array_keys($data);
			// fetch to query sql
			$_key = implode(', ', $key);

			foreach ($data as $k => $v) {
				$v = ltrim($v, ' ');
				$v = rtrim($v, ' ');
				$_value[':'.$k] = $v;
				$_k = array_keys($_value);
				$_k = implode(', ', $_k);
			}

			$query = 'INSERT INTO '.$table.' ('.$_key.') VALUES ('.$_k.')';
			$this->_stmt = $this->_dbh->prepare($query);
			$this->_stmt->execute($_value);
		}
	}

	public function bind($param, $value, $type = null)
	{
		if (is_null($type))
		{
			switch (true)
			{
				case is_int($value) :
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value) :
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value) :
					$type = PDO::PARAM_NULL;
					break;
				default :
					$type = PDO::PARAM_STR;
					break;
			}
		}

		$this->_stmt->bindValue($param, $value, $type);
	}

	public function execute()
	{
		$this->_stmt->execute();
	}

	public function get($table, $field = null)
	{
		if ( ! empty($field))
		{
			if (is_array($field))
			{
				$this->_stmt = $this->_dbh->query('SELECT '.implode(', ', $field).' FROM '.$table.$this->_like.$this->_order_by.$this->_limit);
				$this->_stmt->execute($this->_qb);
			}
		} else {
			$query = 'SELECT * FROM '.$table.$this->_like.$this->_order_by.$this->_limit;
			$this->_stmt = $this->_dbh->query($query);
			$this->_stmt->execute($this->_qb);
		}
	}

	public function get_where($table, $property = null, $field = null)
	{
		if ($this->_like !== null)
		{
			$query = 'SELECT * FROM '.$table.' WHERE '.$this->_like.$this->_order_by;
			// $query = "SELECT * FROM $table WHERE nama LIKE '%$k%'";
			$this->_stmt = $this->_dbh->prepare($query);
			$this->_stmt->execute($this->_qb);
		}
		else if ( ! is_null($field))
		{
			if (is_array($field))
			{
				$field = implode(', ', $field);
				$key = '';
				$value = '';
				foreach ($property as $k => $v) {
					$key = $k;
					$value = $v;
				}
				$query = 'SELECT '.$field.' FROM '.$table.' WHERE '.$key.'='.$value;
				$this->_stmt = $this->_dbh->prepare($query);
			}	
		} else {
			$key = '';
			$value = '';
			foreach ($property as $k => $v) {
				$key = $k;
				$value = $v;
			}
			$query = 'SELECT * FROM '.$table.' WHERE '.$key.'='.$value;
			$this->_stmt = $this->_dbh->prepare($query);
		}
	}

	public function delete($table, $field = null)
	{
		if ( ! empty($where) && $field === null)
		{
			$this->_stmt = $this->_dbh->prepare('DELETE FROM '.$table.' WHERE '.$this->_like);
			$this->_stmt->execute();	
		}
		else if (count($field) > 1)
		{
			die('Sorry you can pass 1 value');
		} else {
			$key = '';
			$value = '';
			foreach ($field as $k => $v)
			{
				$key = $k;
				$value = $v;
			}

			$this->_stmt = $this->_dbh->prepare('DELETE FROM '.$table.' WHERE '.$key.'='.$value);
			$this->_stmt->execute();
		}
	}

	public function where($key, $value)
	{
		$this->_where = $key.'='.$value;
		return $this;
	}

	public function like($key, $value, $property = null)
	{
		if ( ! is_null($property))
		{
			switch ($property) {
				case 'front':
					$this->_qb = array(':'.$key => $value.'%');
					break;
				case 'back' :
					$this->_qb = array(':'.$key => '%'.$value);
				default:
					$this->_qb = array(':'.$key => '%'.$value.'%');
					break;
			}
		} else {
			$this->_qb = array(':'.$key => '%'.$value.'%');
		}
		$this->_like = ' '.$key.' LIKE :'.$key.' ';
		return $this;
	}

	public function orderBy($key, $property)
	{
		$this->_order_by = ' ORDER BY '.$key.' '.strtoupper($property);
		return $this;
	}

	public function update($table, $data)
	{
		if (is_array($data))
		{
			$key = '';
			$value = '';
			$field = array();
			$param = array();
			$w = '';

			foreach ($data as $k => $v) {
				$key = $k.'='.':'.$k;
				$param[':'.$k] = $v;
				$field[] = $key;
			}

			$query = 'UPDATE '.$table.' SET '.implode(', ', $field).' WHERE '.$this->_where;
			$this->_stmt = $this->_dbh->prepare($query);
			$this->_stmt->execute($param);
		}
	}

	public function limit($first, $second = null)
	{
		$this->_limit = ' LIMIT '.$first;
		return $this;
	}

	public function result_array()
	{
		$this->execute();
		return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function result_row()
	{
		$this->execute();
		return $this->_stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function rowCount()
	{
		return $this->_stmt->rowCount();
	}
}