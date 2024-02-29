<?php

namespace App\Controllers;
use App\Models\M_koleksipribadi;

class Koleksi_buku extends BaseController
{

    public function index()
    {
        if (session()->get('level') == 3) {
            $model = new M_koleksipribadi();

            $idUser = session()->get('id');

            $data['jojo'] = $model->tampilKoleksiBukuByIdUser($idUser);

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
            $model = new M_buku();
            $idUser = session()->get('id');

            // Periksa apakah buku sudah ada dalam koleksi pengguna atau belum
            if (!$model->isLiked($id, $idUser)) {
            // Jika belum, tambahkan buku ke dalam koleksi
                $data1 = array(
                    'UserID' => $idUser,
                    'BukuID' => $id
                );
                $model->simpan('koleksipribadi', $data1);
            } else {
            // Jika sudah, hapus buku dari koleksi
                $model->hapusLike($id, $idUser);
            }

        // Arahkan pengguna kembali ke halaman koleksi buku
            return redirect()->to('buku/peminjam');
        } else {
            return redirect()->to('/');
        }
    }
}