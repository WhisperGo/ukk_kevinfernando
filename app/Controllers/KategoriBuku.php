<?php

namespace App\Controllers;
use App\Models\M_kategoribuku;

class KategoriBuku extends BaseController
{

    public function index()
    {
        if (session()->get('level') == 1) {
            $model = new M_kategoribuku();
            $data['jojo'] = $model->tampil('kategoribuku');
            $data['title'] = 'Kategori Buku';
            $data['desc'] = 'Anda dapat melihat Kategori Buku di Menu ini.';

            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/KategoriBuku/view', $data);
            echo view('hopeui/partial/footer');
        } else {
            return redirect()->to('/');
        }
    }

    public function create()
    {
        if(session()->get('level')== 1) {
            $model=new M_kategoribuku();
            $data['title'] = 'Kategori Buku';
            $data['desc'] = 'Anda dapat menambah Kategori Buku di Menu ini.';      
            $data['subtitle'] = 'Tambah Kategori Buku';      
            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/KategoriBuku/create', $data);
            echo view('hopeui/partial/footer');
        }else {
            return redirect()->to('/');
        }
    }

    public function aksi_create()
    { 
        if(session()->get('level')== 1) {
            $a = $this->request->getPost('NamaKategori');

            // Yang ditambah ke user
            $data1 = array(
                'NamaKategori' => $a,
            );
            $model = new M_kategoribuku();
            $model->simpan('KategoriBuku', $data1);

            return redirect()->to('KategoriBuku');
        } else {
            return redirect()->to('/');
        }
    }


    public function edit($id)
    { 
        if(session()->get('level')== 1) {
            $model=new M_kategoribuku();
            $where=array('KategoriID'=>$id);
            $data['jojo']=$model->getWhere('KategoriBuku',$where);
            $data['title'] = 'Kategori Buku';
            $data['desc'] = 'Anda dapat mengedit Kategori Buku di Menu ini.';      
            $data['subtitle'] = 'Edit Kategori Buku';      
            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/KategoriBuku/edit', $data);
            echo view('hopeui/partial/footer');
        }else {
            return redirect()->to('/');
        }
    }

    public function aksi_edit()
    { 
        if(session()->get('level')== 1) {
         $a = $this->request->getPost('NamaKategori');
         $id= $this->request->getPost('id');

        // Yang ditambah ke user
         $data1 = array(
            'NamaKategori' => $a,
            'updated_at' => date('Y-m-d H:i:s'),
        );
         $where=array('KategoriID'=>$id);
         $model=new M_kategoribuku();
         $model->qedit('KategoriBuku', $data1, $where);

         return redirect()->to('KategoriBuku');
     }else {
        return redirect()->to('/');
    }
}

public function delete($id)
{ 
    if(session()->get('level')== 1) {
        $model=new M_kategoribuku();
        $model->deletee($id);
        return redirect()->to('KategoriBuku');
    }else {
        return redirect()->to('/');
    }
}
}