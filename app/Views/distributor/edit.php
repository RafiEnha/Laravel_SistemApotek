<?php

/** @var array<string, mixed> $distributor */

$title = 'Edit Distributor';

?>

<?= $this->include('layout/header') ?>

<?= $this->include('layout/sidebar') ?>


<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>


<style>

    .map-container {
        height: 450px;
        border-radius: 10px;
        overflow: hidden;
    }

    #map {
        width: 100%;
        height: 100%;
    }

    .coordinate-input {
        font-family: monospace;
    }

</style>


<main>

    <div class="container-fluid py-4">



        <div class="mb-4">

            <h2 class="fw-bold mb-1">
                Edit Distributor
            </h2>

            <p class="text-muted mb-0">
                Perbarui informasi distributor dan lokasi distributor.
            </p>

        </div>


        <form
            action="/distributor/update/<?= esc($distributor['id_distributor']) ?>"
            method="post"
        >

            <div class="row g-4">



                <div class="col-lg-5">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white border-0 p-4">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <h5 class="fw-bold mb-1">
                                        Informasi Distributor
                                    </h5>

                                    <p class="text-muted small mb-0">
                                        Ubah data distributor.
                                    </p>

                                </div>


                                <span class="badge text-bg-secondary">

                                    ID
                                    <?= esc(
                                        $distributor['id_distributor']
                                    ) ?>

                                </span>

                            </div>

                        </div>


                        <div class="card-body p-4">



                            <div class="mb-4">

                                <label
                                    class="form-label fw-semibold"
                                >
                                    ID Distributor
                                </label>

                                <input
                                    type="text"
                                    class="form-control bg-light"
                                    value="<?= esc(
                                        $distributor['id_distributor']
                                    ) ?>"
                                    readonly
                                >

                            </div>



                            <div class="mb-4">

                                <label
                                    for="nama_distributor"
                                    class="form-label fw-semibold"
                                >
                                    Nama Distributor
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="nama_distributor"
                                    name="nama_distributor"
                                    value="<?= esc(
                                        $distributor['nama_distributor']
                                    ) ?>"
                                    maxlength="255"
                                    required
                                >

                            </div>



                            <div class="mb-4">

                                <label
                                    for="alamat_distributor"
                                    class="form-label fw-semibold"
                                >
                                    Alamat Distributor
                                </label>

                                <textarea
                                    class="form-control"
                                    id="alamat_distributor"
                                    name="alamat_distributor"
                                    rows="5"
                                    required
                                ><?= esc(
                                    $distributor['alamat_distributor']
                                ) ?></textarea>

                            </div>



                            <div class="mb-3">

                                <label
                                    for="latitude"
                                    class="form-label fw-semibold"
                                >
                                    Latitude
                                </label>

                                <input
                                    type="text"
                                    class="form-control coordinate-input bg-light"
                                    id="latitude"
                                    name="latitude"
                                    value="<?= esc(
                                        $distributor['latitude']
                                    ) ?>"
                                    readonly
                                    required
                                >

                            </div>



                            <div class="mb-4">

                                <label
                                    for="longitude"
                                    class="form-label fw-semibold"
                                >
                                    Longitude
                                </label>

                                <input
                                    type="text"
                                    class="form-control coordinate-input bg-light"
                                    id="longitude"
                                    name="longitude"
                                    value="<?= esc(
                                        $distributor['longitude']
                                    ) ?>"
                                    readonly
                                    required
                                >

                            </div>



                            <div class="alert alert-info">

                                <div class="fw-semibold mb-1">
                                    Mengubah lokasi
                                </div>

                                <div class="small">
                                    Klik lokasi lain pada peta atau
                                    geser marker untuk mengubah posisi
                                    distributor.
                                </div>

                            </div>



                            <div class="d-flex gap-2">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Simpan Perubahan
                                </button>

                                <a
                                    href="/distributor"
                                    class="btn btn-outline-secondary"
                                >
                                    Batal
                                </a>

                            </div>


                        </div>

                    </div>

                </div>



                <div class="col-lg-7">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white border-0 p-4">

                            <h5 class="fw-bold mb-1">
                                Lokasi Distributor
                            </h5>

                            <p class="text-muted small mb-0">
                                Lokasi saat ini ditandai dengan marker.
                            </p>

                        </div>


                        <div class="card-body p-3">

                            <div class="map-container">

                                <div id="map"></div>

                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </form>

    </div>

</main>



<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
></script>


<script>


const initialLatitude =
    parseFloat(
        <?= json_encode($distributor['latitude']) ?>
    );

const initialLongitude =
    parseFloat(
        <?= json_encode($distributor['longitude']) ?>
    );



const map = L.map('map').setView(
    [
        initialLatitude,
        initialLongitude
    ],
    15
);



L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }
).addTo(map);



function updateCoordinates(latitude, longitude)
{
    document.getElementById('latitude').value =
        latitude.toFixed(6);

    document.getElementById('longitude').value =
        longitude.toFixed(6);
}



const marker = L.marker(
    [
        initialLatitude,
        initialLongitude
    ],
    {
        draggable: true
    }
).addTo(map);



marker.on(
    'dragend',
    function () {

        const position =
            marker.getLatLng();

        updateCoordinates(
            position.lat,
            position.lng
        );

    }
);



map.on(
    'click',
    function (event) {

        marker.setLatLng(
            event.latlng
        );

        updateCoordinates(
            event.latlng.lat,
            event.latlng.lng
        );

    }
);

</script>


<?= $this->include('layout/footer') ?>