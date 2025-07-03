<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DiskonModel();
    }

    public function index()
    {
        $data = [
            'diskon' => $this->model->findAll(),
            'title' => 'Manajemen Diskon'
        ];

        return view('v_diskon', $data);
    }

    public function create()
    {
        $rules = [
            'tanggal' => [
                'rules' => 'required|is_unique[diskon.tanggal]',
                'errors' => [
                    'required' => 'Tanggal wajib diisi.',
                    'is_unique' => 'Diskon pada tanggal ini sudah ada.',
                ]
            ],
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nominal diskon wajib diisi.',
                    'numeric' => 'Nominal harus berupa angka.',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('failed', $this->validator->getErrors());
        }

        $this->model->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
        ]);

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('/diskon')->with('success', 'Diskon berhasil dihapus.');
        }

        return redirect()->to('/diskon')->with('failed', 'Gagal menghapus diskon.');
    }

    public function update($id)
    {
        $rules = [
            'tanggal' => [
                'rules' => 'required|is_unique[diskon.tanggal,id,' . $id . ']',
                'errors' => [
                    'required' => 'Tanggal wajib diisi.',
                    'is_unique' => 'Tanggal diskon sudah digunakan oleh entri lain.',
                ]
            ],
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nominal wajib diisi.',
                    'numeric' => 'Nominal harus berupa angka.',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('failed', $this->validator->getErrors());
        }

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
        ];

        $this->model->update($id, $data);

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil diperbarui.');
    }

}
