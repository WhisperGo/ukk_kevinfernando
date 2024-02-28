<?php

namespace App\Controllers;
use App\Models\M_buku;

class Buku_digital extends BaseController
{

    public function index()
    {
        if (session()->get('level') == 1 || session()->get('level') == 2  || session()->get('level') == 3) {
            $model = new M_buku();

            $on = 'buku.KategoriBuku=KategoriBuku.KategoriID';
            $data['jojo'] = $model->join2digital('buku', 'KategoriBuku', $on);

            $data['title'] = 'Data Buku Digital';
            $data['desc'] = 'Anda dapat melihat Data Buku Digital di Menu ini.';

            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/buku_digital/view', $data);
            echo view('hopeui/partial/footer');
        } else {
            return redirect()->to('/');
        }
    }

    public function create()
    {
        if (session()->get('level') == 1 || session()->get('level') == 2) {
            $model=new M_buku();

            $data['title'] = 'Data Buku';
            $data['desc'] = 'Anda dapat menambah Data Buku di Menu ini.';      
            $data['subtitle'] = 'Tambah Buku';

            $data['kategori'] = $model->tampil('KategoriBuku');

            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/buku_digital/create', $data);
            echo view('hopeui/partial/footer');
        }else {
            return redirect()->to('/');
        }
    }

    public function aksi_create()
    { 
        if (session()->get('level') == 1 || session()->get('level') == 2) {
            $a = $this->request->getPost('judul_buku');

            $cover_buku = $this->request->getFile('cover_buku');
            $file_buku = $this->request->getFile('file_buku');

            if ($cover_buku->isValid() && !$cover_buku->hasMoved()) {
                $ext = $cover_buku->getClientExtension();
                $imageName = 'cover_' . session()->get('id') . '_' . time() . '.' . $ext;
                $cover_buku->move('cover', $imageName);
            } else {
                $imageName = 'default.jpg';
            }

            if ($file_buku->isValid() && !$file_buku->hasMoved()) {
                $ext = $file_buku->getClientExtension();
                $bookName = 'buku_' . session()->get('id') . '_' . time() . '.' . $ext;
                $file_buku->move('file_buku', $bookName);
            } else {
            // Handle jika file tidak valid atau gagal dipindahkan
                return redirect()->back()->withInput()->with('error', 'Gagal mengunggah file buku.');
            }

            // Data yang akan disimpan
            $data1 = array(
                'judul_buku' => $a,
                'cover_buku' => $imageName,
                'KategoriBuku' => '10',
                'stok_buku' => '1',
                'file_buku' => $bookName
            );

            // Simpan data ke dalam database
            $model = new M_buku();
            $model->simpan('buku', $data1);

            return redirect()->to('buku_digital');
        } else {
            return redirect()->to('/');
        }
    }

    public function delete($id)
    { 
        if (session()->get('level') == 1 || session()->get('level') == 2) {
            $model=new M_buku();
            $model->deletee($id);
            return redirect()->to('buku_digital');
        }else {
            return redirect()->to('/');
        }
    }

    // ------------------------------------- PEMINJAM -------------------------------------------

    public function peminjam()
    {
        if (session()->get('level') == 3) {
            $model = new M_buku();

            $idUser = session()->get('id');

            $on = 'buku.KategoriBuku=KategoriBuku.KategoriID';
            $data['jojo'] = $model->join2digital('buku', 'KategoriBuku', $on);

            foreach ($data['jojo'] as $riz) {
                $riz->isLiked = $model->isLiked($riz->id_buku, $idUser);
            }

            $data['title'] = 'Data Buku Digital';
            $data['desc'] = 'Anda dapat melihat Data Buku Digital di Menu ini.';

            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/buku_digital/view_peminjam', $data);
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
                    'buku' => $id,
                    'user' => $idUser
                );
                $model->simpan('koleksi_buku', $data1);
            } else {
            // Jika sudah, hapus buku dari koleksi
                $model->hapusLike($id, $idUser);
            }

        // Arahkan pengguna kembali ke halaman koleksi buku
            return redirect()->to('buku_digital/peminjam');
        } else {
            return redirect()->to('/');
        }
    }

}