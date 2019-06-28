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
		$deskripsi = $data['deskripsi'];
		$this->db->insert('kota', array('nama' => $nama_kota, 'deskripsi' => $deskripsi));
		return $this->db->rowCount();
	}

	public function insertDataUser($data)
	{
		$nama = $data['nama'];
		$email = $data['email'];
		$this->db->insert('users', array('nama' => $nama, 'email' => $email));
		return $this->db->rowCount();
	}

	public function getData()
	{
		$this->db->orderBy('id', 'asc');
		$this->db->get('kota');
		$data = $this->db->result_array();
		$convert = json_encode($data);
		return $convert;

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
		$this->db->get_where('users', array('id' => $id));
		return $this->db->result_row();
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

	public function cariData()
	{
		$k = $_POST['cari'];
		// Jika menggunakan fitur like isikan pertama key dan kedua value 
		// ketiga property (otional) terdiri dari front dan back front untuk like depan dan back untuk like belakang
		$this->db->like('nama', $k);
		$this->db->orderBy('id', 'DESC');
		$this->db->get_where('kota');
		return $this->db->result_array();
	}
}