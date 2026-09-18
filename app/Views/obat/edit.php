<?php

/** @var array<string, mixed> $obat */

$title = 'Edit Obat';

?>

<?= $this->include('layout/header') ?>

<?= $this->include('layout/sidebar') ?>


<main>

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="mb-4">

            <h2 class="fw-bold mb-1">
                Edit Obat
            </h2>

            <p class="text-muted mb-0">
                Ubah informasi obat yang tersedia di sistem.
            </p>

        </div>


        <!-- Form -->

        <div class="row">

            <div class="col-lg-8 col-xl-7">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <form
                            action="/obat/update/<?= $obat['id_obat'] ?>"
                            method="post">

                            <!-- ID -->

                            <div class="mb-3">

                                <label
                                    class="form-label fw-semibold">
                                    ID Obat
                                </label>

                                <input
                                    type="text"
                                    class="form-control bg-light"
                                    value="<?= esc($obat['id_obat']) ?>"
                                    readonly>

                            </div>


                            <!-- Kode Obat -->

                            <div class="mb-3">

                                <label
                                    for="kode_obat"
                                    class="form-label fw-semibold">
                                    Kode Obat
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="kode_obat"
                                    name="kode_obat"
                                    value="<?= esc($obat['kode_obat']) ?>"
                                    maxlength="45"
                                    required>

                            </div>


                            <!-- Nama Obat -->

                            <div class="mb-3">

                                <label
                                    for="nama_obat"
                                    class="form-label fw-semibold">
                                    Nama Obat
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="nama_obat"
                                    name="nama_obat"
                                    value="<?= esc($obat['nama_obat']) ?>"
                                    maxlength="255"
                                    required>

                            </div>


                            <!-- Satuan -->

                            <div class="mb-3">

                                <label
                                    for="satuan_obat"
                                    class="form-label fw-semibold">
                                    Satuan Obat
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="satuan_obat"
                                    name="satuan_obat"
                                    value="<?= esc($obat['satuan_obat']) ?>"
                                    maxlength="45"
                                    required>

                            </div>


                            <!-- Harga -->

                            <div class="mb-3">

                                <label
                                    for="harga_obat"
                                    class="form-label fw-semibold">
                                    Harga Obat
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        Rp
                                    </span>

                                    <input
                                        type="number"
                                        class="form-control"
                                        id="harga_obat"
                                        name="harga_obat"
                                        value="<?= esc($obat['harga_obat']) ?>"
                                        min="0"
                                        step="0.01"
                                        required>

                                </div>

                            </div>


                            <!-- Stock -->

                            <div class="mb-4">

                                <label
                                    for="stock_obat"
                                    class="form-label fw-semibold">
                                    Stock Obat
                                </label>

                                <input
                                    type="number"
                                    class="form-control"
                                    id="stock_obat"
                                    name="stock_obat"
                                    value="<?= esc($obat['stock_obat']) ?>"
                                    min="0"
                                    required>

                            </div>


                            <!-- Buttons -->

                            <div class="d-flex gap-2">

                                <button
                                    type="submit"
                                    class="btn btn-primary">
                                    Simpan Perubahan
                                </button>

                                <a
                                    href="/obat"
                                    class="btn btn-outline-secondary">
                                    Batal
                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>


<?= $this->include('layout/footer') ?>