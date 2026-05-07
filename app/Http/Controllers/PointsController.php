<?php

namespace App\Http\Controllers;

use App\Models\pointsModel;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    public function __construct()
    {
        $this->points = new pointsModel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validasi Input
        $request->validate(
            [
                'geometry_point' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            ],
            [
                'geometry_point.required' => 'Field geometry point harus diisi.',
                'name.required' => 'Field nama harus diisi.',
                'name.string' => 'Field nama harus berupa string.',
                'name.max' => 'Field nama tidak boleh lebih dari 255 karakter.',
                'description.required' => 'Field deskripsi harus diisi.',
                'image.image' => 'Field gambar harus berupa gambar.',
                'image.mimes' => 'File gambar harus berformat jpeg, png, atau jpg.',
                'image.max' => 'Ukuran gambar tidak boleh lebih dari 2048kb.',

            ]
        );

        //Create directory for images if it doesn't exist

        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);}

        if ($request->hasFile('image'))
            {$image = $request->file('image');
                $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
                $image->move('storage/images', $name_image);
            }
            else {
                $name_image = null;
            }

        $data = [
            'geom' => $request->geometry_point,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image
        ];

        if (!$this->points->create($data)) {
            return redirect()->route('peta') ->with('error', 'Gagal menyimpan data point.');
        }

        return redirect()->route('peta') ->with('success', 'Data point berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = $this->points->find($id)->image;

        if (!$this->points->destroy($id)) {
            return redirect()->route('peta') ->with('error', 'Gagal menghapus data point.');
        }

        if ($image != null) {
            if (file_exists('storage/images/' . $image)) {
                unlink('storage/images/' . $image);
            }
        }
        return redirect()->route('peta') ->with('success', 'Data point berhasil dihapus.');
    }
}
