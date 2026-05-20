<?php

namespace App\Http\Controllers;
use App\Models\polygonsModel;
use Illuminate\Http\Request;

class PolygonsController extends Controller
{
    public function __construct()
    {
        $this->polygons = new polygonsModel();
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
        $request->validate(
            [
                'geometry_polygon' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            ],
            [
                'geometry_polygon.required' => 'Field geometry polygon harus diisi.',
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
                $name_image = time() . "_polygons." . strtolower($image->getClientOriginalExtension());
                $image->move('storage/images', $name_image);
            }
            else {
                $name_image = null;
            }

        $data = [
            'geom' => $request->geometry_polygon,
            'name' => $request->name,
            'description' => $request->description,
             'image' => $name_image
        ];

        $this->polygons->create($data);

        return redirect()->route('peta');
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
        $data = [
            'title' => 'Edit Polygons',
            'id' => $id,
            'polygon' => $this->polygons->find($id)
        ];
        return view('map-edit-polygon', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
        [
            'geometry' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ],
        [
            'geometry.required' => 'Field geometry point harus diisi.',
            'name.required' => 'Field nama harus diisi.',
            'name.string' => 'Field nama harus berupa string.',
            'name.max' => 'Field nama tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Field deskripsi harus diisi.',
            'image.image' => 'Field gambar harus berupa gambar.',
            'image.mimes' => 'File gambar harus berformat jpeg, png, atau jpg.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2048kb.',
        ]
    );

    if (!is_dir('storage/images')) {
        mkdir('./storage/images', 0777);
    }

    $image_old = $this->polygons->find($id)->image;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
        $image->move('storage/images', $name_image);

        // Hapus gambar lama
        if ($image_old != null) {
            if (file_exists('storage/images/' . $image_old)) {
                unlink('storage/images/' . $image_old);
            }
        }
    } else {
        $name_image = $image_old;
    }

    $data = [
        'geom' => $request->geometry,
        'name' => $request->name,
        'description' => $request->description,
        'image' => $name_image
    ];

    if (!$this->polygons->find($id)->update($data)) {
        return redirect()->route('peta')->with('error', 'Gagal memperbarui data polygon.');
    }

    return redirect()->route('peta')->with('success', 'Data polygon berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                $image = $this->polygons->find($id)->image;

        if (!$this->polygons->destroy($id)) {
            return redirect()->route('peta') ->with('error', 'Gagal menghapus data polygons.');
        }

        if ($image != null) {
            if (file_exists('storage/images/' . $image)) {
                unlink('storage/images/' . $image);
            }
        }
        return redirect()->route('peta') ->with('success', 'Data polygons berhasil dihapus.');//
    }
}
