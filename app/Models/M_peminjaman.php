<?php

namespace App\Models;
use CodeIgniter\Model;

class M_peminjaman extends Model
{		
	protected $table      = 'peminjaman';
	protected $primaryKey = 'PeminjamanID';
	protected $allowedFields = ['UserID', 'BukuID', 'TanggalPeminjaman', 'TanggalPengembalian', 'StatusPeminjaman'];
	protected $useSoftDeletes = true;
	protected $useTimestamps = true;

	public function tampil($table1)	
	{
		return $this->db->table($table1)->where('deleted_at', null)->get()->getResult();
	}
	public function tampilid($table1, $id)	
	{
		return $this->db->table($table1)->where('deleted_at', null)->where('buku.BukuID', $id)->get()->getRow();
	}
	public function hapus($table, $where)
	{
		return $this->db->table($table)->delete($where);
	}
	public function simpan($table, $data)
	{
		return $this->db->table($table)->insert($data);
	}
	public function qedit($table, $data, $where)
	{
		return $this->db->table($table)->update($data, $where);
	}
	public function getWhere($table, $where)
	{
		return $this->db->table($table)->getWhere($where)->getRow();
	}
	public function getWhere2($table, $where)
	{
		return $this->db->table($table)->getWhere($where)->getRowArray();
	}
	public function join2($table1, $table2, $on)
	{
		return $this->db->table($table1)
		->join($table2, $on, 'left')
		->where("$table1.deleted_at", null)
		->where("$table2.deleted_at", null)
        ->where("buku.kategori_buku !=", 10) // Menambahkan kondisi kategori_buku != 10
        ->get()
        ->getResult();
    }
    public function hitungSemuaHariIni()
    {
	    $hariIni = date('Y-m-d'); // Mengambil tanggal hari ini
	    $besok = date('Y-m-d', strtotime('+1 day')); // Mengambil tanggal besok

	    return $this->where('deleted_at', null)
	    ->where('created_at >=', $hariIni)
	    ->where('created_at <', $besok)
	    ->countAllResults();
	}


	// ----------------------------------- PEMINJAMAN -------------------------------------

	public function getPeminjamanById($id)
	{
		return $this->db->table('peminjaman')
		->select('peminjaman.*, buku.*, user.*') 
		->select('peminjaman.stok_buku AS stok_buku_peminjaman') 
		->join('buku', 'buku.BukuID = peminjaman.BukuID')
		->join('user', 'user.UserID = peminjaman.UserID')
		->where('peminjaman.BukuID', $id)
		->where('peminjaman.deleted_at', null)
		->orderBy('peminjaman.StatusPeminjaman', 'ASC')
		->orderBy('peminjaman.created_at', 'DESC')
		->get()
		->getResult();
	}

	public function getBukuByIdPeminjaman($id)
	{
        // Query untuk mengambil data stok buku masuk berdasarkan ID
		$query = $this->db->table('peminjaman')
		->where('id_peminjaman', $id)
		->get();

        // Mengembalikan satu baris data stok buku masuk
		return $query->getRow();
	}

	public function tampilPeminjamanByIdUser($idUser)
	{
		$builder = $this->db->table('peminjaman');
		$builder->select('peminjaman.*, buku.*, kategoribuku_relasi.*, kategoribuku.*');
		$builder->join('buku', 'buku.BukuID = peminjaman.BukuID');
		$builder->join('kategoribuku_relasi', 'buku.BukuID = kategoribuku_relasi.BukuID');
		$builder->join('kategoribuku', 'kategoribuku_relasi.KategoriID = kategoribuku.KategoriID');
		$builder->where('peminjaman.UserID', $idUser);
		$builder->where('peminjaman.deleted_at', null);

		$results = $builder->get()->getResult();
	}

	// Peminjaman Per Periode

	public function getAllPeminjamanInRange($tanggal_awal, $tanggal_akhir)
	{
		return $this->db->table('peminjaman')
		->select('peminjaman.*, buku.*, user.*') 
		->select('peminjaman.stok_buku AS stok_buku_peminjaman') 
		->join('buku', 'buku.BukuID = peminjaman.BukuID')
		->join('user', 'user.UserID = peminjaman.UserID')
		->where('peminjaman.StatusPeminjaman =', 1)
		->where('peminjaman.TanggalPeminjaman >=', $tanggal_awal)
		->where('peminjaman.TanggalPengembalian <=', $tanggal_akhir)
		->where('peminjaman.deleted_at', null)
		->orderBy('peminjaman.created_at', 'DESC')
		->get()
		->getResult();
	}

	public function countPeminjamanByStatus($awal, $akhir, $status)
	{
		return $this->db->table('peminjaman')
		->where('TanggalPeminjaman >=', $awal)
		->where('TanggalPengembalian <=', $akhir)
		->where('StatusPeminjaman', $status)
		->countAllResults();
	}

	// Peminjaman Per Hari

	public function getAllPeminjamanPerHari($tanggal)
	{
		return $this->db->table('peminjaman')
		->select('peminjaman.*, buku.*, user.*') 
		->select('peminjaman.stok_buku AS stok_buku_peminjaman') 
		->join('buku', 'buku.BukuID = peminjaman.BukuID')
		->join('user', 'user.UserID = peminjaman.UserID')
		->where('peminjaman.StatusPeminjaman =', 1)
		->where('DATE(peminjaman.created_at)', $tanggal)
		->where('peminjaman.deleted_at', null)
		->orderBy('peminjaman.created_at', 'DESC')
		->get()
		->getResult();
	}

	// ----------------------------------------- PENGEMBALIAN -----------------------------------------

	// Pengembalian Per Periode
	public function getAllPengembalianInRange($tanggal_awal, $tanggal_akhir)
	{
		return $this->db->table('peminjaman')
		->select('peminjaman.*, buku.*, user.*') 
		->select('peminjaman.stok_buku AS stok_buku_peminjaman') 
		->join('buku', 'buku.BukuID = peminjaman.BukuID')
		->join('user', 'user.UserID = peminjaman.UserID')
		->where('peminjaman.StatusPeminjaman =', 2)
		->where('peminjaman.TanggalPengembalian >=', $tanggal_awal)
		->where('peminjaman.TanggalPengembalian <=', $tanggal_akhir)
		->where('peminjaman.deleted_at', null)
		->orderBy('peminjaman.created_at', 'DESC')
		->get()
		->getResult();
	}

	// Pengembalian Per Hari
	public function getAllPengembalianPerHari($tanggal)
	{
		return $this->db->table('peminjaman')
		->select('peminjaman.*, buku.*, user.*') 
		->select('peminjaman.stok_buku AS stok_buku_peminjaman') 
		->join('buku', 'buku.BukuID = peminjaman.BukuID')
		->join('user', 'user.UserID = peminjaman.UserID')
		->where('peminjaman.StatusPeminjaman =', 2)
		->where('DATE(peminjaman.TanggalPengembalian)', $tanggal)
		->where('peminjaman.deleted_at', null)
		->orderBy('peminjaman.created_at', 'DESC')
		->get()
		->getResult();
	}
	

	//CI4 Model
	public function deletee($id)
	{
		return $this->delete($id);
	}
}