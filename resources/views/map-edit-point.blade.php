@extends('layouts.template')

@section('styles')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<!-- Leaflet Draw CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    <style>
    body {
        width:100%;
        height:100%;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }
    #map {
        height:calc(100vh - 56px);
        width: 100%;
    }
</style>
@endsection
@section('content')
<div id="map"></div>
<!-- Modal Form Edit-->
<div class="modal" tabindex="-1" id="modalInputPoint">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('point.update', $id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
      <div class="modal-body">
       <div class="mb-3">
  <label for="name" class="form-label">Name</label>
  <input type="text" class="form-control" id="name" name="name" placeholder="Fill name here">
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
   <input class="form-control" type="file" id="image" name="image"
    onchange="document.getElementById('preview-image').src = window.URL.createObjectURL(this.files[0])">
    </div>
    <div class="mb-3">
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
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<!-- Leaflet Draw JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<!-- Terraformer JS -->
<script src="https://unpkg.com/@terraformer/wkt"></script>
<!-- jQuery JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    var map = L.map('map').setView([-7.7956, 110.3695], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var boyolali = L.marker([-7.5333, 110.6000]).bindPopup('Boyolali');
    var banyuwangi = L.marker([-8.2192, 114.3691]).bindPopup('Banyuwangi');
    var gunungkidul = L.marker([-7.9800, 110.6167]).bindPopup('Gunungkidul');
    var solo = L.marker([-7.579459740152691, 110.88899287785242]).bindPopup('Solo');
     // Menggabungkan semua marker
    var group = L.featureGroup([boyolali, banyuwangi, gunungkidul, solo]).addTo(map);

    // Landing map otomatis menyesuaikan semua marker
    map.fitBounds(group.getBounds());

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

       //show modal point input//
       $('#name').val(properties.name);
       $('#description').val(properties.description);
       $('#geometry').val(objectGeometry);
       $('#preview-image').attr('src', "{{asset('storage/images') }}/" + properties.image);

		$('#modalInputPoint').modal('show');
	});
});

//Points Layer

var points = L.geoJSON(null, {
    onEachFeature: function(feature, layer) {
        drawnItems.addLayer(layer);


        var properties = feature.properties;
        var objectGeometry = Terraformer.geojsonToWKT(feature.geometry);

        layer.on({


            click: function (e) {
            $('#name').val(properties.name);
            $('#description').val(properties.description);
            $('#geometry').val(objectGeometry);
            $('#preview-image').attr('src', "{{asset('storage/images') }}/" + properties.image);

            $('#modalInputPoint').modal('show');

            }
        });
    }
});

// ✅ letakkan di luar
$.getJSON("{{ route('geojson.point', $id) }}", function (data) {
    points.addData(data);
    map.addLayer(points);
});
</script>
@endsection
