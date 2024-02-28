<?php

namespace App\Controllers;
use App\Models\M_koleksi_buku;

class Koleksi_buku extends BaseController
{

    public function index()
    {
        if (session()->get('level') == 3) {
            $model = new M_koleksi_buku();

            $idUser = session()->get('id');

            $data['jojo'] = $model->tampilKoleksiBukuByIdUser($idUser);

            $isLiked = [];
            foreach ($data['jojo'] as $riz) {
                $isLiked[$riz->id_buku] = $model->isLiked($riz->id_buku, $idUser);
            }

            $data['isLiked'] = $isLiked;

            $data['title'] = 'Koleksi Buku';
            $data['desc'] = 'Anda dapat melihat Koleksi Buku di Menu ini.';

            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/koleksi_buku/view', $data);
            echo view('hopeui/partial/footer');
        } else {
            return redirect()->to('/');
        }
    }


    public function aksi_tambah_koleksi($id)
    { 
        if(session()->get('level') == 3) {
            $model = new M_koleksi_buku();

            $idUser = session()->get('id');

            // Periksa apakah buku sudah ada dalam koleksi pengguna atau belum
            if (!$model->isLiked($id, $idUser)) {
            // Jika belum, tambahkan buku ke dalam koleksi
                $data1 = array(
                    'buku' => $id,
                    'user' => $idUser
                );
                $model->simpan('koleksi_buku', $data1);
            } else {
            // Jika sudah, hapus buku dari koleksi
                $model->hapusLike($id, $idUser);
            }

        // Arahkan pengguna kembali ke halaman koleksi buku
            return redirect()->to('koleksi_buku');
        } else {
            return redirect()->to('/');
        }
    }
}