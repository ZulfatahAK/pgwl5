<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Peta Yogyakarta - Leaflet</title>



    <!-- Leaflet Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"/>

    @yield('styles')

</head>
<body>
    @include('components/navbar')

    @yield('content')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

    @include('components.toast')
</body>
</html>
