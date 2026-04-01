@extends('layouts.template')

@section('styles')

    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }
   
</style>
@endsection
@section('content')
<div class="container mt-3">
<div class="card"> 
    <div class="card-header">
        <h3>Tabel Data</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Yusuf</td>
                    <td>Boyolali</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Hardika</td>
                    <td>Banyuwangi</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Zulfatah</td>
                    <td>Gunungkidul</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Norman</td>
                    <td>Solo</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection