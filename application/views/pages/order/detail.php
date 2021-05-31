<main role="main" class="container">
    <?php $this->load->view('layouts/_alert'); ?>


    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="row mb-3">
                <div class="col-md-12">
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
                                        <?php if(array_sum(array_column($order_detail, "subtotal")) >= 150000):?>
                                        <td><strong>Tidak ada</strong></td>
                                        <?php else:?>
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
                                        <?php endif;?>
                                    </tr>
                                    <tr>
                                    <td colspan="3"><strong>Total:</strong></td>
                                        <?php if(array_sum(array_column($order_detail, "subtotal")) >= 150000):?>
                                        <td><strong>Rp<?= number_format(array_sum(array_column($order_detail, "subtotal"))) ?>,-</strong></td>
                                        <?php else:?>
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
                                        <?php endif;?>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <div class="card-footer">
                            <form action="<?= base_url("order/update/$order->id") ?>" method="POST">
                                <div class="input-group">
                                    <input type="hidden" name="id" value="<?= $order->id ?>">
                                    <select name="status" id="" class="form-control">
                                        <option value="waiting" <?= $order->status == "waiting" ? "selected" : "" ?>>Menunggu Pembayaran</option>
                                        <option value="paid" <?= $order->status == "paid" ? "selected" : "" ?>>Dibayar</option>
                                        <option value="delivered" <?= $order->status == "delivered" ? "selected" : "" ?>>Dikirim</option>
                                        <option value="cancel" <?= $order->status == "cancel" ? "selected" : "" ?>>Dibatalkan</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

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
        </div>
    </div>

</main>