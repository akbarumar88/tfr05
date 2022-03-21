<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap-select.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('front/img/app-logo.jpg') }}" type="image/x-icon">
    <title>{{ $judul }}</title>
    <!-- Font Awesome Script -->
    <script src="https://kit.fontawesome.com/bc14fa0285.js" crossorigin="anonymous"></script>
    <script src="{{ asset('front/js/jquery-3.6.0.min.js') }}"></script>
</head>

<body>

    @include('partials.navbar')

    <div>
        @yield('content')
    </div>

    {{-- Footer Content --}}
    <div id="footer" class="bg-light pt-4 pb-4">
        <h6 class="text-dark text-center m-0">Copyright <?= date('Y') ?> Pemrograman Framework Kelompok 2.</h6>
    </div>
</div>
</div>
<!-- Closing Tag Container -->

<script src="<?= asset('front/js/popper.min.js') ?>"></script>
<script src="<?= asset('front/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= asset('front/js/bootstrap-select.min.js') ?>"></script>
<script src="<?= asset('front/js/script.js') ?>"></script>
</body>

</html>