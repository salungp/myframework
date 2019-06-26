<?php
class welcome_model extends Controller
{
	public $db;

	public function __construct()
	{
		$this->db = new Database();
	}

	public function insertData($data)
	{
		$nama_kota = $data['nama_kota'];
		$query = "INSERT INTO kota (nama, waktu) VALUES (:nama, :waktu)";
		$this->db->insert($query, array(':nama' => $nama_kota, ':waktu' => 1));
		return $this->db->rowCount();
	}

	public function insertDataUser($data)
	{
		$nama = $data['nama'];
		$email = $data['email'];
		$query = "INSERT INTO users (nama, email) VALUES (:nama, :email)";
		$this->db->insert($query, array(':nama' => $nama, ':email' => $email));
		return $this->db->rowCount();
	}

	public function getData($table)
	{
		return $this->db->get($table);
	}

	public function deleteData($table, $id)
	{
		$this->db->delete($table, array('id' => $id));
		return $this->db->rowCount();
	}

	public function whereUser($id)
	{
		return $this->db->get_where('users', array('id' => $id));
	}

	public function updateData()
	{
		$id = $_POST['id'];
		$nama = $_POST['nama'];
		$email = $_POST['email'];
		// $query = "UPDATE users SET nama='$nama', email='$email' WHERE id=$id";
		// die($query);
		$this->db->update('users', array('nama' => $nama, 'email' => $email), array('id' => $id));
		// $this->db->query($query);
		// $this->db->execute();
		return $this->db->rowCount();
	}
}