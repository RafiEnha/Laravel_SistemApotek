<?php

/** @var array<int, array<string, mixed>> $obat */
/** @var string|null $search */
/** @var string $sort */
/** @var string $order */

?>

<?= $this->include('layout/header') ?>

<?= $this->include('layout/sidebar') ?>


<main>

    <div class="container-fluid p-4">


        <!-- Page Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">
                    Data Obat
                </h2>

                <p class="text-muted mb-0">
                    Kelola data obat yang tersedia di apotek.
                </p>

            </div>


            <a
                href="/obat/create"
                class="btn btn-primary">
                + Tambah Obat
            </a>

        </div>



        <!-- Search & Filter -->

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <form
                    action="/obat"
                    method="get">

                    <div class="row g-3 align-items-end">


                        <!-- Search -->

                        <div class="col-md-5">

                            <label
                                for="search"
                                class="form-label fw-semibold">
                                Cari Nama Obat
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="search"
                                name="search"
                                value="<?= esc($search ?? '') ?>"
                                placeholder="Cari nama obat...">

                        </div>



                        <!-- Sort -->

                        <div class="col-md-3">

                            <label
                                for="sort"
                                class="form-label fw-semibold">
                                Urutkan Berdasarkan
                            </label>

                            <select
                                name="sort"
                                id="sort"
                                class="form-select">

                                <option
                                    value="id_obat"
                                    <?= $sort === 'id_obat' ? 'selected' : '' ?>>
                                    ID Obat
                                </option>

                                <option
                                    value="nama_obat"
                                    <?= $sort === 'nama_obat' ? 'selected' : '' ?>>
                                    Nama Obat
                                </option>

                                <option
                                    value="harga_obat"
                                    <?= $sort === 'harga_obat' ? 'selected' : '' ?>>
                                    Harga
                                </option>

                                <option
                                    value="stock_obat"
                                    <?= $sort === 'stock_obat' ? 'selected' : '' ?>>
                                    Stock
                                </option>

                            </select>

                        </div>



                        <!-- Order -->

                        <div class="col-md-2">

                            <label
                                for="order"
                                class="form-label fw-semibold">
                                Urutan
                            </label>

                            <select
                                name="order"
                                id="order"
                                class="form-select">

                                <option
                                    value="ASC"
                                    <?= $order === 'ASC' ? 'selected' : '' ?>>
                                    Ascending
                                </option>

                                <option
                                    value="DESC"
                                    <?= $order === 'DESC' ? 'selected' : '' ?>>
                                    Descending
                                </option>

                            </select>

                        </div>



                        <!-- Buttons -->

                        <div class="col-md-2 d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary flex-grow-1">
                                Terapkan
                            </button>

                            <a
                                href="/obat"
                                class="btn btn-outline-secondary">
                                Reset
                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>



        <!-- Table -->

        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="px-4">
                                    ID
                                </th>

                                <th>
                                    Kode Obat
                                </th>

                                <th>
                                    Nama Obat
                                </th>

                                <th>
                                    Satuan
                                </th>

                                <th>
                                    Harga
                                </th>

                                <th>
                                    Stock
                                </th>

                                <th class="text-center px-4">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (empty($obat)): ?>

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center py-5 text-muted">
                                        Data obat tidak ditemukan.
                                    </td>

                                </tr>

                            <?php else: ?>


                                <?php foreach ($obat as $item): ?>

                                    <tr>


                                        <!-- ID -->

                                        <td class="px-4 fw-semibold">

                                            <?= esc($item['id_obat']) ?>

                                        </td>


                                        <!-- Kode -->

                                        <td>

                                            <span class="badge text-bg-secondary">

                                                <?= esc($item['kode_obat']) ?>

                                            </span>

                                        </td>


                                        <!-- Nama -->

                                        <td class="fw-semibold">

                                            <?= esc($item['nama_obat']) ?>

                                        </td>


                                        <!-- Satuan -->

                                        <td>

                                            <?= esc($item['satuan_obat']) ?>

                                        </td>


                                        <!-- Harga -->

                                        <td>

                                            Rp
                                            <?= number_format(
                                                $item['harga_obat'],
                                                0,
                                                ',',
                                                '.'
                                            ) ?>

                                        </td>


                                        <!-- Stock -->

                                        <td>

                                            <?php

                                            $stock = (int) $item['stock_obat'];

                                            ?>

                                            <?php if ($stock <= 10): ?>

                                                <span class="badge text-bg-danger">
                                                    <?= $stock ?>
                                                </span>

                                            <?php elseif ($stock <= 30): ?>

                                                <span class="badge text-bg-warning">
                                                    <?= $stock ?>
                                                </span>

                                            <?php else: ?>

                                                <span class="badge text-bg-success">
                                                    <?= $stock ?>
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- Aksi -->

                                        <td class="px-4">

                                            <div
                                                class="d-flex justify-content-center gap-2">

                                                <a
                                                    href="/obat/edit/<?= $item['id_obat'] ?>"
                                                    class="btn btn-sm btn-primary">
                                                    Edit
                                                </a>


                                                <a
                                                    href="/obat/<?= $item['id_obat'] ?>/penjualan"
                                                    class="btn btn-sm btn-success">
                                                    Detail
                                                </a>


                                                <form
                                                    action="/obat/delete/<?= $item['id_obat'] ?>"
                                                    method="post"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus obat ini?')">

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-danger">
                                                        Hapus
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>


                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        <!-- Information -->

        <div class="mt-3 text-muted small">

            Menampilkan

            <strong>
                <?= count($obat) ?>
            </strong>

            data obat.

            <?php if (!empty($search)): ?>

                Hasil pencarian:

                <strong>
                    "<?= esc($search) ?>"
                </strong>

            <?php endif; ?>

        </div>


    </div>

</main>


<?= $this->include('layout/footer') ?>