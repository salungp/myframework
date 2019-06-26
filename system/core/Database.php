<?php
class Database
{
	private $_host = HOST;

	private $_user = USER;

	private $_pass = PASS;

	private $_name = NAME;

	public $_dbh;

	public $_stmt;

	public $_qb;

	public $_sm;

	public function __construct()
	{
		$dsn = 'mysql:host='.$this->_host.';dbname='.$this->_name;
		$this->_dbh = new PDO($dsn, $this->_user, $this->_pass);
	}

	public function query($query)
	{
		$this->_stmt = $this->_dbh->prepare($query);
	}

	public function insert($table, $data)
	{
		$_value = array();
		$_k = '';
		// $field = ltrim($key, ':');
		// $findTable = explode(' ', $query);
		$key = array_keys($data);
		$_key = implode(', ', $key);
		foreach ($data as $k => $v) {
			$_value[':'.$k] = $v;
			$_k = array_keys($_value);
			$_k = implode(', ', $_k);
		}
		// $this->_stmt = $this->_dbh->prepare("SELECT * FROM $table WHERE $field = '$value'");
		// $this->execute();
		// $obj = $this->_stmt->fetch(PDO::FETCH_ASSOC);
		// if ($obj[$field] == $value)
		// {
		// 	$_SESSION['flasher'] = array('m' => 'Sorry name '.$value.' is already used!');
		// 	redirect();
		// } else {
			$query = 'INSERT INTO '.$table.' ('.$_key.') VALUES ('.$_k.')';
			$this->_stmt = $this->_dbh->prepare($query);
			$this->_stmt->execute($_value);
		//}
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
				$this->_stmt = $this->_dbh->query('SELECT '.implode(', ', $field).' FROM '.$table);
				return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		} else {
			$this->_stmt = $this->_dbh->query('SELECT * FROM '.$table);
			return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	public function get_where($table, $property = null, $field = null)
	{
		if ($this->_qb !== null)
		{
			$query = 'SELECT * FROM '.$table.' WHERE '.$this->_qb;
			// $query = "SELECT * FROM $table WHERE nama LIKE '%$k%'";
			$this->_stmt = $this->_dbh->prepare($query);
			$this->_stmt->execute($this->_sm);
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
		$where = $this->_qb;
		if ( ! empty($where) && $field === null)
		{
			$this->_stmt = $this->_dbh->prepare('DELETE FROM '.$table.' WHERE '.$this->_qb);
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
		$this->_qb = $key.'='.$value;
		return $this;
	}

	public function like($key, $value)
	{

		$this->_qb = $key.' LIKE :'.$key;
		$this->_sm = array(':'.$key => '%'.$value.'%');
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

			// foreach ($where as $k => $v) {
			// 	$value = $k.'='.$v;
			// 	$w = $value;
			// }

			$query = 'UPDATE '.$table.' SET '.implode(', ', $field).' WHERE '.$this->_qb;
			$this->_stmt = $this->_dbh->prepare($query);
			$this->_stmt->execute($param);
		}
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