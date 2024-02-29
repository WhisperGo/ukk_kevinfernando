<?php

namespace App\Controllers;
use App\Models\M_ulasanbuku;

class Ulasan_buku extends BaseController
{

    public function index($id)
    {
        if (session()->get('level') == 3) {
            $model = new M_ulasanbuku();

        // Ambil data ulasan berdasarkan id_buku
            $data['ulasan'] = $model->getUlasanByIdBuku($id);

            $data['title'] = 'Ulasan Buku';
            $data['desc'] = 'Anda dapat melihat Ulasan Buku di Menu ini.';
            $data['id'] = $id;

        // Ambil data gambar berdasarkan id_buku
            $gambar_baru = $model->getIdBuku($id);
            $data['gambar_baru'] = $gambar_baru;

            $data['rating']=$model->tampil('rating');

            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/ulasan_buku/view', $data);
            echo view('hopeui/partial/footer');
        } else {
            return redirect()->to('/');
        }
    }

    public function aksi_create()
    { 
        if (session()->get('level') == 3) {
            $a = $this->request->getPost('rating');
            $b = $this->request->getPost('isi_ulasan');
            $id = $this->request->getPost('id');

            // Data yang akan disimpan
            $data1 = array(
                'BukuID' => $id,
                'UserID' => session()->get('id'),
                'Ulasan' => $b,
                'Rating' => $a
            );

            // Simpan data ke dalam database
            $model = new M_ulasanbuku();
            $model->simpan('ulasanbuku', $data1);

            return redirect()->to('ulasan_buku/' . $id);
        } else {
            return redirect()->to('/');
        }
    }
}