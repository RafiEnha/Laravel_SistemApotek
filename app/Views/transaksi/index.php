<?php

/** @var array<int, array<string, mixed>> $obat */

?>

<?= $this->include('layout/header') ?>

<?= $this->include('layout/sidebar') ?>


<main>

    <div class="container-fluid py-4">


        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">
                    Transaksi Penjualan
                </h2>

                <p class="text-muted mb-0">
                    Buat transaksi penjualan obat.
                </p>

            </div>

        </div>


        <!-- Alert Error -->

        <?php if (session()->getFlashdata('error')): ?>

            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >

                <strong>
                    Transaksi gagal.
                </strong>

                <?= esc(session()->getFlashdata('error')) ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        <?php endif; ?>


        <!-- Transaction Form -->

        <form
            action="/transaksi/store"
            method="post"
            id="transaksiForm"
        >

            <div class="row g-4">


                <!-- Left Content -->

                <div class="col-lg-8">


                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white border-0 p-4">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <h5 class="fw-bold mb-1">
                                        Detail Pesanan
                                    </h5>

                                    <p class="text-muted small mb-0">
                                        Pilih obat dan tentukan jumlah pembelian.
                                    </p>

                                </div>

                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-sm"
                                    id="tambahObat"
                                >
                                    + Tambah Obat
                                </button>

                            </div>

                        </div>


                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table
                                    class="table align-middle mb-0"
                                    id="transaksiTable"
                                >

                                    <thead class="table-light">

                                        <tr>

                                            <th class="ps-4">
                                                Obat
                                            </th>

                                            <th>
                                                Harga
                                            </th>

                                            <th>
                                                Stock
                                            </th>

                                            <th style="width: 120px;">
                                                Jumlah
                                            </th>

                                            <th>
                                                Subtotal
                                            </th>

                                            <th
                                                class="text-center pe-4"
                                                style="width: 80px;"
                                            >
                                                Aksi
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>


                                        <!-- Row Obat -->

                                        <tr class="obat-row">


                                            <!-- Obat -->

                                            <td class="ps-4">

                                                <select
                                                    name="id_obat[]"
                                                    class="form-select obat-select"
                                                    required
                                                >

                                                    <option value="">
                                                        -- Pilih Obat --
                                                    </option>


                                                    <?php foreach ($obat as $item): ?>

                                                        <option
                                                            value="<?= $item['id_obat'] ?>"
                                                            data-price="<?= $item['harga_obat'] ?>"
                                                            data-stock="<?= $item['stock_obat'] ?>"
                                                        >

                                                            <?= esc($item['nama_obat']) ?>

                                                            (<?= esc($item['kode_obat']) ?>)

                                                        </option>

                                                    <?php endforeach; ?>

                                                </select>

                                            </td>


                                            <!-- Harga -->

                                            <td>

                                                <span class="harga-text text-muted">
                                                    -
                                                </span>

                                            </td>


                                            <!-- Stock -->

                                            <td>

                                                <span class="stock-badge">
                                                    -
                                                </span>

                                            </td>


                                            <!-- Jumlah -->

                                            <td>

                                                <input
                                                    type="number"
                                                    name="jumlah[]"
                                                    class="form-control jumlah-input"
                                                    min="1"
                                                    value="1"
                                                    required
                                                >

                                            </td>


                                            <!-- Subtotal -->

                                            <td>

                                                <span class="subtotal-text fw-semibold">
                                                    Rp 0
                                                </span>

                                            </td>


                                            <!-- Delete -->

                                            <td class="text-center pe-4">

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-danger hapus-row"
                                                >
                                                    Hapus
                                                </button>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>


                    <!-- Information -->

                    <div class="card border-0 shadow-sm mt-4">

                        <div class="card-body">

                            <div class="d-flex">

                                <div class="me-3">
                                    <span class="badge text-bg-info">
                                        Info
                                    </span>
                                </div>

                                <div>

                                    <div class="fw-semibold">
                                        Periksa kembali transaksi
                                    </div>

                                    <div class="text-muted small">
                                        Pastikan jumlah obat tidak melebihi
                                        stok yang tersedia sebelum menyimpan.
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>


                <!-- Right Summary -->

                <div class="col-lg-4">


                    <div class="card border-0 shadow-sm sticky-lg-top"
                         style="top: 80px;">

                        <div class="card-body p-4">


                            <h5 class="fw-bold mb-4">
                                Ringkasan Transaksi
                            </h5>


                            <div
                                class="d-flex justify-content-between mb-3"
                            >

                                <span class="text-muted">
                                    Jumlah Item
                                </span>

                                <strong id="jumlahItem">
                                    0
                                </strong>

                            </div>


                            <hr>


                            <div
                                class="d-flex justify-content-between align-items-center"
                            >

                                <span class="fw-semibold">
                                    Total
                                </span>

                                <span
                                    class="fs-4 fw-bold text-primary"
                                    id="totalHarga"
                                >
                                    Rp 0
                                </span>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-primary w-100 mt-4"
                            >
                                Simpan Transaksi
                            </button>

                        </div>

                    </div>


                </div>


            </div>

        </form>

    </div>

</main>


<script>

const tableBody =
    document.querySelector('#transaksiTable tbody');

const tambahButton =
    document.getElementById('tambahObat');

const transaksiForm =
    document.getElementById('transaksiForm');

const totalHargaElement =
    document.getElementById('totalHarga');

const jumlahItemElement =
    document.getElementById('jumlahItem');


function formatRupiah(value)
{
    return new Intl.NumberFormat(
        'id-ID',
        {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }
    ).format(value);
}


function updateRow(row)
{
    const select =
        row.querySelector('.obat-select');

    const jumlahInput =
        row.querySelector('.jumlah-input');

    const hargaText =
        row.querySelector('.harga-text');

    const stockBadge =
        row.querySelector('.stock-badge');

    const subtotalText =
        row.querySelector('.subtotal-text');


    const selectedOption =
        select.options[select.selectedIndex];


    if (
        !selectedOption ||
        !selectedOption.value
    ) {

        hargaText.textContent = '-';

        stockBadge.textContent = '-';

        stockBadge.className = 'stock-badge';

        subtotalText.textContent = 'Rp 0';

        jumlahInput.removeAttribute('max');

        return;

    }


    const harga =
        parseFloat(
            selectedOption.dataset.price
        );

    const stock =
        parseInt(
            selectedOption.dataset.stock
        );


    hargaText.textContent =
        formatRupiah(harga);


    stockBadge.textContent =
        stock;


    if (stock <= 10) {

        stockBadge.className =
            'badge text-bg-danger stock-badge';

    } else if (stock <= 30) {

        stockBadge.className =
            'badge text-bg-warning stock-badge';

    } else {

        stockBadge.className =
            'badge text-bg-success stock-badge';

    }


    jumlahInput.max = stock;


    let jumlah =
        parseInt(jumlahInput.value) || 0;


    if (jumlah > stock) {
        jumlah = stock;
        jumlahInput.value = stock;
    }


    const subtotal =
        harga * jumlah;


    subtotalText.textContent =
        formatRupiah(subtotal);
}


function updateTotal()
{
    const rows =
        document.querySelectorAll('.obat-row');

    let total = 0;

    let jumlahItem = 0;


    rows.forEach(function (row) {

        const select =
            row.querySelector('.obat-select');

        const jumlahInput =
            row.querySelector('.jumlah-input');


        if (!select.value) {
            return;
        }


        const selectedOption =
            select.options[select.selectedIndex];


        const harga =
            parseFloat(
                selectedOption.dataset.price
            ) || 0;


        const jumlah =
            parseInt(
                jumlahInput.value
            ) || 0;


        total += harga * jumlah;

        jumlahItem += jumlah;

    });


    totalHargaElement.textContent =
        formatRupiah(total);


    jumlahItemElement.textContent =
        jumlahItem;
}


function updateAll()
{
    document
        .querySelectorAll('.obat-row')
        .forEach(function (row) {

            updateRow(row);

        });

    updateTotal();
}


function tambahRow()
{
    const firstRow =
        document.querySelector('.obat-row');

    const newRow =
        firstRow.cloneNode(true);


    newRow.querySelector('.obat-select').value =
        '';

    newRow.querySelector('.jumlah-input').value =
        '1';


    tableBody.appendChild(newRow);

    updateAll();
}


tambahButton.addEventListener(
    'click',
    function () {

        tambahRow();

    }
);


tableBody.addEventListener(
    'change',
    function (event) {

        if (
            event.target.classList.contains(
                'obat-select'
            )
        ) {

            const row =
                event.target.closest('.obat-row');

            updateRow(row);

            updateTotal();

        }

    }
);


tableBody.addEventListener(
    'input',
    function (event) {

        if (
            event.target.classList.contains(
                'jumlah-input'
            )
        ) {

            const row =
                event.target.closest('.obat-row');

            updateRow(row);

            updateTotal();

        }

    }
);


tableBody.addEventListener(
    'click',
    function (event) {

        if (
            event.target.classList.contains(
                'hapus-row'
            )
        ) {

            const rows =
                document.querySelectorAll(
                    '.obat-row'
                );


            if (rows.length > 1) {

                event.target
                    .closest('.obat-row')
                    .remove();

                updateTotal();

            }

        }

    }
);


transaksiForm.addEventListener(
    'submit',
    function (event) {

        const rows =
            document.querySelectorAll('.obat-row');

        let valid = true;


        rows.forEach(function (row) {

            const select =
                row.querySelector('.obat-select');

            const jumlahInput =
                row.querySelector('.jumlah-input');


            if (!select.value) {
                valid = false;
                return;
            }


            const selectedOption =
                select.options[
                    select.selectedIndex
                ];


            const stock =
                parseInt(
                    selectedOption.dataset.stock
                );


            const jumlah =
                parseInt(
                    jumlahInput.value
                );


            if (jumlah > stock) {

                valid = false;

                alert(
                    'Jumlah obat melebihi stock yang tersedia.'
                );

            }

        });


        if (!valid) {
            event.preventDefault();
        }

    }
);


updateAll();

</script>


<?= $this->include('layout/footer') ?>