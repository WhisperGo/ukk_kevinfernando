<?php

namespace App\Models;
use CodeIgniter\Model;

class M_log_activity extends Model
{		
	protected $table      = 'log_activity';
	protected $primaryKey = 'id_log';
	protected $allowedFields = ['UserID', 'nama_log'];
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
    public function joinUser()
    {
        return $this->db->table('log_activity')
        ->select('log_activity.*, user.*')
        ->select('log_activity.created_at AS created_at_log')
        ->join('user', 'log_activity.UserID = user.UserID', 'left')
        ->where('log_activity.deleted_at', null)
        ->where('user.deleted_at', null)
        ->orderBy('log_activity.created_at', 'DESC')
        ->get()
        ->getResult();
    }


	//CI4 Model
    public function insertt($data)
    {
        return $this->insert($data);
    }

    public function deletee($id)
    {
     return $this->delete($id);
 }
}