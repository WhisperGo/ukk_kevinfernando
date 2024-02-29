<?php

namespace App\Controllers;
use App\Models\M_durasi_peminjaman;

class Durasi_peminjaman extends BaseController
{
    public function index()
    {
       if(session()->get('level')== 1) {
        $model=new M_durasi_peminjaman();
        $data['jojo']=$model->tampil('durasi_peminjaman');

        $data['title']='Durasi Peminjaman';
        $data['desc']='Anda dapat melihat Durasi Peminjaman di Menu ini.';

        // Menghitung jumlah data website
        $data['jumlah_data'] = count($data['jojo']);

        echo view('hopeui/partial/header', $data);
        echo view('hopeui/partial/side_menu');
        echo view('hopeui/partial/top_menu', $data);
        echo view('hopeui/durasi_peminjaman/view', $data);
        echo view('hopeui/partial/footer');
    }else {
        return redirect()->to('/');
    }
}

public function create()
{
    if(session()->get('level')== 1) {
        $model=new M_durasi_peminjaman();

        $data['title']='Durasi Peminjaman';
        $data['desc']='Anda dapat tambah Durasi Peminjaman di Menu ini.'; 
        $data['subtitle'] = 'Tambah Durasi Peminjaman';

        echo view('hopeui/partial/header', $data);
        echo view('hopeui/partial/side_menu');
        echo view('hopeui/partial/top_menu');
        echo view('hopeui/durasi_peminjaman/create', $data);
        echo view('hopeui/partial/footer');
    }else {
        return redirect()->to('/');
    }
}

public function aksi_create()
{ 
    if(session()->get('level')== 1) {
        $a= $this->request->getPost('lama_durasi');

        //Yang ditambah ke user
        $data1=array(
            'lama_durasi'=>$a,
        );

        $model=new M_durasi_peminjaman();
        $model->simpan('durasi_peminjaman', $data1);

        return redirect()->to('durasi_peminjaman');
    }else {
        return redirect()->to('/');
    }
}
public function edit($id)
{ 
    if(session()->get('level')== 1) {
        $model=new M_durasi_peminjaman();
        $where=array('id_durasi'=>$id);
        $data['jojo']=$model->getWhere('durasi_peminjaman',$where);
        
        $data['title'] = 'Durasi Peminjaman';
        $data['desc'] = 'Anda dapat mengedit Durasi Peminjaman di Menu ini.';      
        $data['subtitle'] = 'Edit Durasi Peminjaman';  

        echo view('hopeui/partial/header', $data);
        echo view('hopeui/partial/side_menu');
        echo view('hopeui/partial/top_menu');
        echo view('hopeui/durasi_peminjaman/edit', $data);
        echo view('hopeui/partial/footer');
    }else {
        return redirect()->to('/');
    }
}

public function aksi_edit()
{ 
    if(session()->get('level')== 1) {
     $a= $this->request->getPost('lama_durasi');
     $id= $this->request->getPost('id');

       //Yang ditambah ke user
     $where=array('id_durasi'=>$id);
     $data1=array(
        'lama_durasi'=>$a,
        'updated_at'=>date('Y-m-d H:i:s')
    );
     $model=new M_durasi_peminjaman();
     $model->qedit('durasi_peminjaman', $data1, $where);
     return redirect()->to('durasi_peminjaman');

 }else {
    return redirect()->to('/');
}
}

public function delete($id)
{ 
 if(session()->get('level')== 1) {
    $model=new M_durasi_peminjaman();
    $model->deletee($id);
    return redirect()->to('durasi_peminjaman');
}else {
    return redirect()->to('/');
}

}

}