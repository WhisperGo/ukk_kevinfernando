<?php

namespace App\Models;
use CodeIgniter\Model;

class M_buku extends Model
{		
	protected $table      = 'buku';
	protected $primaryKey = 'BukuID';
	protected $allowedFields = ['Judul', 'Penulis', 'Penerbit', 'TahunTerbit'];
	protected $useSoftDeletes = true;
	protected $useTimestamps = true;

	public function tampil($table1)	
	{
		return $this->db->table($table1)->where('deleted_at', null)->get()->getResult();
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
    public function join2digital($table1, $table2, $on)
    {
    	return $this->db->table($table1)
    	->join($table2, $on, 'left')
    	->where("$table1.deleted_at", null)
    	->where("$table2.deleted_at", null)
        ->where("buku.kategori_buku =", 10) // Menambahkan kondisi kategori_buku != 10
        ->get()
        ->getResult();
    }
    public function join3($table1, $table2, $table3, $on, $on2)
    {
    	return $this->db->table($table1)
    	->join($table2, $on, 'left')
    	->join($table3, $on2, 'left')
    	->where("$table1.deleted_at", null)
    	->where("$table2.deleted_at", null)
    	->where("$table3.deleted_at", null)
        ->where('buku.stok_buku !=', 0)
    	->get()
    	->getResult();
    }
    public function join4($table1, $table2, $table3, $table4, $on, $on2, $on3)
    {
    	return $this->db->table($table1)
    	->join($table2, $on, 'left')
    	->join($table3, $on2, 'left')
    	->join($table4, $on3, 'left')
    	->where("$table1.deleted_at", null)
    	->where("$table2.deleted_at", null)
    	->where("$table3.deleted_at", null)
    	->where("$table4.deleted_at", null)
    	->orderBy('peminjaman.StatusPeminjaman', 'ASC')
    	->orderBy('peminjaman.created_at', 'DESC')
    	->get()
    	->getResult();
    }
    public function join4biasa()
    {
        return $this->db->table('peminjaman')
        ->select('peminjaman.*, buku.*, kategoribuku_relasi.*, kategoribuku.*')
        ->select('peminjaman.stok_buku AS stok_buku_peminjaman') 
        ->join('buku', 'peminjaman.BukuID = buku.BukuID', 'left')
        ->join('kategoribuku_relasi', 'buku.BukuID = kategoribuku_relasi.BukuID', 'left')
        ->join('kategoribuku', 'kategoribuku_relasi.KategoriID = kategoribuku.KategoriID', 'left')
        ->where('peminjaman.deleted_at', null)
        ->where('buku.deleted_at', null)
        ->where('kategoribuku_relasi.deleted_at', null)
        ->where('kategoribuku.deleted_at', null)
        ->orderBy('peminjaman.StatusPeminjaman', 'ASC')
        ->orderBy('peminjaman.created_at', 'DESC')
        ->get()
        ->getResult();
    }
    public function join4user($idUser)
    {
        return $this->db->table('peminjaman')
        ->select('peminjaman.*, buku.*, kategoribuku_relasi.*, kategoribuku.*')
        ->select('peminjaman.stok_buku AS stok_buku_peminjaman') 
        ->join('buku', 'peminjaman.BukuID = buku.BukuID', 'left')
        ->join('kategoribuku_relasi', 'buku.BukuID = kategoribuku_relasi.BukuID', 'left')
        ->join('kategoribuku', 'kategoribuku_relasi.KategoriID = kategoribuku.KategoriID', 'left')
        ->where('peminjaman.deleted_at', null)
        ->where('buku.deleted_at', null)
        ->where('kategoribuku_relasi.deleted_at', null)
        ->where('kategoribuku.deleted_at', null)
        ->where('peminjaman.UserID', $idUser)
        ->orderBy('peminjaman.StatusPeminjaman', 'ASC')
        ->orderBy('peminjaman.created_at', 'DESC')
        ->get()
        ->getResult();
    }

    public function hitungsemua()
    {
    	return $this->where('deleted_at', null)->countAllResults();
    }

    public function getBooksByCategory($kategoriID)
    {
    	$builder = $this->db->table('buku');
    	$builder->select('buku.*, kategoribuku.NamaKategori');
    	$builder->join('kategoribuku_relasi', 'buku.BukuID = kategoribuku_relasi.BukuID');
    	$builder->join('kategoribuku', 'kategoribuku_relasi.KategoriID = kategoribuku.KategoriID');
    	$builder->where('kategoribuku_relasi.KategoriID', $kategoriID);
        $builder->where('buku.stok_buku !=', 0);
        $query = $builder->get();
        return $query->getResult();
    }

	// ----------------------------------- STOK BUKU MASUK -------------------------------------

    public function getBukuMasukById($id)
    {
    	return $this->db->table('buku_masuk')
    	->select('buku_masuk.*, buku.*') 
    	->join('buku', 'buku.BukuID = buku_masuk.buku_id')
    	->where('buku.BukuID', $id)
    	->get()
    	->getResult();
    }


    public function getBukuMasukByIdBukuMasuk($id)
    {
        // Query untuk mengambil data stok buku masuk berdasarkan ID
    	$query = $this->db->table('buku_masuk')
    	->where('id_buku_masuk', $id)
    	->get();

        // Mengembalikan satu baris data stok buku masuk
    	return $query->getRow();
    }

	// ----------------------------------- STOK BUKU KELUAR -------------------------------------

    public function getBukuKeluarById($id)
    {
    	return $this->db->table('buku_keluar')
    	->select('buku_keluar.*, buku.*') 
    	->join('buku', 'buku.BukuID = buku_keluar.buku_id')
    	->where('buku.BukuID', $id)
    	->get()
    	->getResult();
    }


    public function getBukuKeluarByIdBukuMasuk($id)
    {
        // Query untuk mengambil data stok buku masuk berdasarkan ID
    	$query = $this->db->table('buku_keluar')
    	->where('id_buku_keluar', $id)
    	->get();

        // Mengembalikan satu baris data stok buku masuk
    	return $query->getRow();
    }

	// ------------------------------------- PEMINJAM ---------------------------------------------

    public function isLiked($idBuku, $idUser)
    {
    	return $this->db->table('koleksipribadi')
    	->where(['BukuID' => $idBuku, 'UserID' => $idUser])
    	->countAllResults() > 0;
    }

    public function hapusLike($idBuku, $idUser)
    {
    	return $this->db->table('koleksipribadi')
    	->where(['BukuID' => $idBuku, 'UserID' => $idUser])
    	->delete();
    }

    public function isLikedByIdUser($idUser)
    {
    	return $this->db->table('koleksipribadi')
    	->select('koleksipribadi.*, buku.*, kategoribuku_relasi.*, kategoribuku.*')
    	->join('buku', 'buku.BukuID = koleksipribadi.BukuID')
    	->join('kategoribuku_relasi', 'buku.BukuID = kategoribuku_relasi.BukuID')
    	->join('kategoribuku', 'kategoribuku_relasi.KategoriID = kategoribuku.KategoriID')
    	->where('koleksipribadi.UserID', $idUser)
    	->where('koleksipribadi.deleted_at', null)
    	->get()
    	->getResult();
    }

	//CI4 Model
    public function deletee($id)
    {
    	return $this->delete($id);
    }
}