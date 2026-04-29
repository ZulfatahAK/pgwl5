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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

    @include('components.toast')
</body>
</html>
