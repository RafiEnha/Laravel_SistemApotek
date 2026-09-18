<?php

/** @var array<string, mixed> $transaksi */
/** @var array<int, array<string, mixed>> $details */

?>

<?= $this->include('layout/header') ?>

<?= $this->include('layout/sidebar') ?>


<style>

    .receipt-wrapper {
        padding: 30px 15px;
    }

    .receipt {
        max-width: 520px;
        margin: 0 auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        padding: 30px;
    }

    .receipt-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .receipt-header h2 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .receipt-meta {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .receipt-table {
        width: 100%;
    }

    .receipt-table th,
    .receipt-table td {
        padding: 8px 0;
        vertical-align: top;
    }

    .receipt-table thead {
        border-bottom: 1px dashed #adb5bd;
    }

    .receipt-table tbody tr:not(:last-child) {
        border-bottom: 1px dashed #dee2e6;
    }

    .receipt-total {
        border-top: 2px solid #212529;
        margin-top: 15px;
        padding-top: 15px;
    }

    .receipt-footer {
        text-align: center;
        margin-top: 25px;
        color: #6c757d;
    }

    @media print {

        body {
            background: white !important;
        }

        .app-navbar,
        .app-sidebar,
        .no-print {
            display: none !important;
        }

        .receipt-wrapper {
            padding: 0;
        }

        .receipt {
            max-width: none;
            width: 100%;
            box-shadow: none;
            border-radius: 0;
            padding: 0;
        }

    }

</style>


<main>

    <div class="container-fluid receipt-wrapper">


        <div class="receipt">


            <!-- Header -->

            <div class="receipt-header">

                <h2>
                    SISTEM APOTEK
                </h2>

                <div class="receipt-meta">
                    Struk Penjualan Obat
                </div>

            </div>


            <hr>


            <!-- Transaction Information -->

            <div class="row mb-3">

                <div class="col-6">

                    <div class="text-muted small">
                        No. Transaksi
                    </div>

                    <div class="fw-semibold">
                        #<?= esc($transaksi['id_transaksi']) ?>
                    </div>

                </div>


                <div class="col-6 text-end">

                    <div class="text-muted small">
                        Tanggal
                    </div>

                    <div class="fw-semibold">

                        <?= date(
                            'd/m/Y H:i',
                            strtotime(
                                $transaksi['tanggal_transaksi']
                            )
                        ) ?>

                    </div>

                </div>

            </div>


            <!-- Items -->

            <table class="receipt-table">

                <thead>

                    <tr>

                        <th>
                            Obat
                        </th>

                        <th
                            class="text-center"
                            style="width: 60px;"
                        >
                            Qty
                        </th>

                        <th
                            class="text-end"
                            style="width: 110px;"
                        >
                            Subtotal
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php foreach ($details as $detail): ?>

                        <tr>

                            <td>

                                <div class="fw-semibold">

                                    <?= esc(
                                        $detail['nama_obat']
                                    ) ?>

                                </div>

                                <div class="small text-muted">

                                    <?= esc(
                                        $detail['satuan_obat']
                                    ) ?>

                                    × Rp

                                    <?= number_format(
                                        $detail['harga'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </div>

                            </td>


                            <td class="text-center">

                                <?= esc(
                                    $detail['jumlah']
                                ) ?>

                            </td>


                            <td class="text-end">

                                Rp
                                <?= number_format(
                                    $detail['subtotal'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>


            <!-- Total -->

            <div class="receipt-total">

                <div
                    class="d-flex justify-content-between align-items-center"
                >

                    <span class="fw-semibold">
                        Total
                    </span>

                    <span class="fs-4 fw-bold">

                        Rp
                        <?= number_format(
                            $transaksi['total'],
                            0,
                            ',',
                            '.'
                        ) ?>

                    </span>

                </div>

            </div>


            <!-- Footer -->

            <div class="receipt-footer">

                <div class="fw-semibold mb-1">
                    Terima kasih atas pembelian Anda
                </div>

                <div class="small">
                    Simpan struk ini sebagai bukti transaksi.
                </div>

            </div>


            <!-- Actions -->

            <div class="no-print mt-4">

                <div class="d-grid gap-2">

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="window.print()"
                    >
                        Cetak Struk
                    </button>


                    <a
                        href="/transaksi"
                        class="btn btn-outline-primary"
                    >
                        Transaksi Baru
                    </a>


                    <a
                        href="/obat"
                        class="btn btn-outline-secondary"
                    >
                        Kembali ke Data Obat
                    </a>

                </div>

            </div>


        </div>

    </div>

</main>


<?= $this->include('layout/footer') ?>