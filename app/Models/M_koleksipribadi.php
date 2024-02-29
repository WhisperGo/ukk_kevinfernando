<?php

namespace App\Models;
use CodeIgniter\Model;

class M_koleksipribadi extends Model
{		
	protected $table      = 'koleksipribadi';
	protected $primaryKey = 'KoleksiID';
	protected $allowedFields = ['UserID', 'BukuID'];
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
		->get()
		->getResult();
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

	public function tampilKoleksiBukuByIdUser($idUser)
	{
		$builder = $this->db->table('koleksipribadi');
		$builder->select('koleksipribadi.*, buku.*, kategoribuku_relasi.*, kategoribuku.*');
		$builder->join('buku', 'buku.BukuID = koleksipribadi.BukuID');
		$builder->join('kategoribuku_relasi', 'buku.BukuID = kategoribuku_relasi.BukuID');
		$builder->join('kategoribuku', 'kategoribuku_relasi.KategoriID = kategoribuku.KategoriID');
		$builder->where('koleksipribadi.UserID', $idUser);
		$builder->where('koleksipribadi.deleted_at', null);
		$builder->where('buku.stok_buku !=', 0);

		$results = $builder->get()->getResult();

    // Tambahkan properti isLiked ke setiap buku dalam koleksi
		foreach ($results as $result) {
			$result->isLiked = $this->isLiked($result->BukuID, $idUser);
		}

		return $results;
	}

	//CI4 Model
	public function deletee($id)
	{
		return $this->delete($id);
	}
}