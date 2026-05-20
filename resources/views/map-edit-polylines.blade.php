@extends('layouts.template')

@section('styles')
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    {{-- Leaflet Draw CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    <style>
        /* Menghilangkan margin bawaan browser dan memastikan tinggi penuh */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        /* Membuat peta memenuhi seluruh layar */
        #map {
            height: 100vh;
            width: 100vw;
        }
    </style>
@endsection

@section('content')
    {{-- Pastikan hanya ada SATU div dengan id="map" di seluruh halaman --}}
    <div id="map"></div>

    {{-- Modal form edit --}}
    <div class="modal" tabindex="-1" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polylines.update', $id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Fill name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geometry" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry" name="geometry" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image" onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image" class="img-thumbnail" width="400">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @include('components.navbar')

    {{-- Bootstrap JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- Leaflet Draw JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    {{-- Terraformer JS --}}
    <script src="https://unpkg.com/@terraformer/wkt"></script>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // Set view default ke koordinat tengah (Boyolali)
        var map = L.map('map').setView([-7.5333, 110.6000], 12);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        /* Digitize Function */
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: false,
            edit: {
                featureGroup: drawnItems,
                edit: true,
                remove: false
            }
        });

        map.addControl(drawControl);

        map.on('draw:edited', function(e) {
            var layers = e.layers;

            layers.eachLayer(function(layer) {
                var drawnJSONObject = layer.toGeoJSON();
                console.log(drawnJSONObject);

                var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);
                console.log(objectGeometry);

                // layer properties
                var properties = drawnJSONObject.properties;
                console.log(properties);

                drawnItems.addLayer(layer);

                //mengisi form edit dengan data dari layer yang diedit
                $('#name').val(properties.name);
                $('#description').val(properties.description);
                $('#geometry').val(objectGeometry);
                $('#preview-image').attr('src', "{{ asset('storage/images/') }}/" + properties.image);

                //menampilkan modal form edit
                $('#modalEdit').modal('show');
            });
        });

        //GeoJSON Polylines Layer
        var polylines = L.geoJSON(null, {
            // Style

            // onEachFeature
            onEachFeature: function (feature, layer) {
                drawnItems.addLayer(layer); // Menambahkan layer yang sudah di-draw ke dalam drawnItems agar bisa diedit

                var properties = feature.properties;
                var objectGeometry = Terraformer.geojsonToWKT(feature.geometry);

                layer.on({
                    click: function (e) {
                //mengisi form edit dengan data dari layer yang diedit
                $('#name').val(properties.name);
                $('#description').val(properties.description);
                $('#geometry').val(objectGeometry);
                $('#preview-image').attr('src', "{{ asset('storage/images/') }}/" + properties.image);

                //menampilkan modal form edit
                $('#modalEdit').modal('show');
                    },
                });
            },
        });

        $.getJSON("{{ route('geojson.polyline', $id) }}",
            function (data) {
                polylines.addData(data); // Menambahkan data ke dalam GeoJSON Point Sarana Prasarana
                map.addLayer(polylines); // Menambahkan GeoJSON Point Sarana Prasarana ke dalam peta
                map.fitBounds(polylines.getBounds());
            });

    </script>
@endsection
