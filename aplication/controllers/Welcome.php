<?php
class Welcome extends Controller
{
	public function index()
	{
		$data['kota'] = $this->model('welcome_model')->getData('kota');
		$data['user'] = $this->model('welcome_model')->getData('users');
		$data['foto'] = $this->model('welcome_model')->getData('foto');
		$this->view('main', $data);
	}

	public function main()
	{
		$this->view('main');
	}

	public function insert()
	{
		if ($this->model('welcome_model')->insertData($_POST) > 0)
		{
			Flasher::set('Insert data successfuly!');
			redirect();
		} else {
			Flasher::set('Insert data failed');
			redirect();
		}
	}

	public function insertUser()
	{
		if ($this->model('welcome_model')->insertDataUser($_POST) > 0)
		{
			Flasher::set('Insert data successfuly!');
			redirect();
		} else {
			Flasher::set('Insert data failed');
			redirect();
		}
	}

	public function deleteUser($id)
	{
		if ($this->model('welcome_model')->deleteData('users', $id) > 0)
		{
			Flasher::set('Delete data successfuly');
			redirect();
		} else {
			Flasher::set('Delete data failed!');
			redirect();
		}
	}

	public function deleteKota($id)
	{
		if ($this->model('welcome_model')->deleteData('kota', $id) > 0)
		{
			Flasher::set('Delete data successfuly');
			redirect();
		} else {
			Flasher::set('Delete data failed!');
			redirect();
		}
	}

	public function insertFoto()
	{
		if ($this->model('welcome_model')->insertFile() > 0)
		{
			Flasher::set('Insert data successfuly');
			redirect();
		} else {
			Flasher::set('Insert data failed!');
			redirect();
		}
	}

	public function updateUser()
	{
		if ($this->model('welcome_model')->updateData() > 0)
		{
			Flasher::set('Update data successfuly');
			redirect();
		} else {
			Flasher::set('Update data failed!');
			redirect();
		}
	}

	public function update($id)
	{
		$data['user'] = $this->model('welcome_model')->whereUser($id);
		$this->view('update', $data);
	}
}