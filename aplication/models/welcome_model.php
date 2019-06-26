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
		$this->db->insert('kota', array('nama' => $nama_kota, 'waktu' => 1));
		return $this->db->rowCount();
	}

	public function insertDataUser($data)
	{
		$nama = $data['nama'];
		$email = $data['email'];
		$this->db->insert('users', array('nama' => $nama, 'email' => $email));
		return $this->db->rowCount();
	}

	public function getData($table)
	{
		return $this->db->get($table);
	}

	public function deleteData($table, $id)
	{
		$this->db->delete($table, ['id' => $id]);
		return $this->db->rowCount();
	}

	public function insertFile()
	{
		$nama_file = $_FILES['foto']['name'];
		$ekstensi = array('jpg', 'png');
		$x = explode('.', $nama_file);
		$eks_file = strtolower(end($x));
		$file_size = $_FILES['foto']['size'];
		$file_place = $_FILES['foto']['tmp_name'];
		$dir = 'assets/images/'.$nama_file;
		if (in_array($eks_file, $ekstensi) === true)
		{
			move_uploaded_file($file_place, base_url($dir));
			$this->db->insert('foto', array('nama' => $nama_file, 'dir' => $dir));
			return $this->db->rowCount();
		} else {
			return null;
		}
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
		$this->db->where('id', $id);
		$this->db->update('users', array('nama' => $nama, 'email' => $email));
		// $this->db->query($query);
		// $this->db->execute();
		return $this->db->rowCount();
	}
}