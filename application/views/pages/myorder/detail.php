<main role="main" class="container">
    <?php $this->load->view('layouts/_alert'); ?>

    <div class="row">
        <div class="col-md-3">
            <?php $this->load->view('layouts/_menu'); ?>

        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Detail Order #<?= $order->invoice ?>
                    <div class="float-right">
                        <?php $this->load->view('layouts/_status', ["status" => $order->status]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <p>Tanggal: <?= str_replace("-", "/", date("d-m-Y", strtotime($order->date))) ?></p>
                    <p>Nama: <?= $order->name ?></p>
                    <p>Telepon: <?= $order->phone ?></p>
                    <p>Alamat: <?= $order->address ?></p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Subtotal</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_detail as $row) : ?>
                                <tr>
                                    <td>
                                        <p><img src="<?= $row->image ? base_url("/images/product/$row->image") : base_url("/images/product/default.jpg") ?>" alt="" height="50"><strong><?= $row->title ?></strong></p>
                                    </td>
                                    <td class="text-center">Rp<?= number_format($row->price, 0, ",", ".") ?>,-</td>

                                    <td class="text-center"><?= $row->qty ?></td>

                                    <td class="text-center">Rp<?= number_format($row->subtotal, 0, ",", ".") ?>,-</td>

                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3"><strong>Ongkos kirim:</strong></td>

                                <?php if (array_sum(array_column($order_detail, "subtotal")) >= 150000) : ?>
                                    <td><strong>Tidak ada</strong></td>
                                <?php else : ?>
                                    <?php
                                    if ($order->alamat_kirim == 1) {
                                        $ongkir = 20000;
                                    } elseif ($order->alamat_kirim == 2) {
                                        $ongkir = 22000;
                                    } elseif ($order->alamat_kirim == 3) {
                                        $ongkir = 23000;
                                    } elseif ($order->alamat_kirim == 0) {
                                        $ongkir = 0;
                                    } elseif ($order->alamat_kirim == 4) {
                                        $ongkir = 25000;
                                    } elseif ($order->alamat_kirim == 5) {
                                        $ongkir = 26000;
                                    }
                                    ?>

                                    <td class="text-center">Rp<?= number_format($ongkir, 0, ",", ".") ?>,-</td>
                                <?php endif; ?>

                            </tr>
                            <tr>
                                <td colspan="3"><strong>Total:</strong></td>
                                <?php if (array_sum(array_column($order_detail, "subtotal")) >= 150000) : ?>
                                    <td><strong>Rp<?= number_format(array_sum(array_column($order_detail, "subtotal"))) ?>,-</strong></td>
                                <?php else : ?>
                                    <?php if ($order->alamat_kirim == 1) {
                                        $tambah = array_sum(array_column($order_detail, "subtotal"));
                                        $jumlah = $tambah + 20000;
                                    } elseif ($order->alamat_kirim == 2) {
                                        $tambah = array_sum(array_column($order_detail, "subtotal"));
                                        $jumlah = $tambah + 22000;
                                    } elseif ($order->alamat_kirim == 3) {
                                        $tambah = array_sum(array_column($order_detail, "subtotal"));
                                        $jumlah = $tambah + 23000;
                                    } elseif ($order->alamat_kirim == 0) {
                                        $tambah = array_sum(array_column($order_detail, "subtotal"));
                                        $jumlah = $tambah + 0;
                                    } elseif ($order->alamat_kirim == 4) {
                                        $tambah = array_sum(array_column($order_detail, "subtotal"));
                                        $jumlah = $tambah + 25000;
                                    }elseif ($order->alamat_kirim == 5) {
                                        $tambah = array_sum(array_column($order_detail, "subtotal"));
                                        $jumlah = $tambah + 26000;
                                    }
                                    ?>
                                    <td class="text-center"><strong>Rp<?= number_format($jumlah, 0, ",", ".") ?>,-</strong></td>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <a class="btn btn-primary" href="<?= base_url("/myorder/print/$order->invoice") ?>">Print</strong></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <?php if ($order->status == "waiting") : ?>
                    <div class="card-footer">
                        <a href="<?= base_url("/myorder/confirm/$order->invoice") ?>" class="btn btn-success">Konfirmasi Pembayaran</a>
                    </div>
                <?php elseif ($order->status == "delivered" && !$my_return) : ?>
                    <div class="card-footer">
                        <a href="<?= base_url("/myreturn/confirm/$order->invoice") ?>" class="btn btn-success">Pengembalian barang</a>
                    </div>
                <?php endif; ?>
            </div>
            <br>
            <?php if (isset($orders_confirm)) : ?>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                Bukti Transfer
                            </div>
                            <div class="card-body">
                                <p>No Rekening: <?= $orders_confirm->account_number ?></p>
                                <p>Atas Nama: <?= $orders_confirm->account_name ?></p>
                                <p>Nominal: Rp<?= number_format($orders_confirm->nominal, 0, ",", ".") ?>,-</p>
                                <p>Catatan: <?= $orders_confirm->note ?></p>
                                <a href="<?= base_url("/images/confirm/$orders_confirm->image") ?>" class="btn btn-primary" Download>Download</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="<?= base_url("/images/confirm/$orders_confirm->image") ?>" alt="" height="200">
                    </div>
                </div>
            <?php endif; ?>
            <br>
            <?php if (isset($my_return)) : ?>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                Permohonan pengembalian
                            </div>
                            <div class="card-body">
                                <p>Keluhan: <?= $my_return->note ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="<?= base_url("/images/pengembalian/$my_return->image") ?>" alt="" height="200">
                        <br>
                        <br>
                        <a href="<?= base_url("/images/pengembalian/$my_return->image") ?>" class="btn btn-warning" Download>Download</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</main>