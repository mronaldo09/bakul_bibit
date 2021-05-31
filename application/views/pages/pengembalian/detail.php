<main role="main" class="container">
    <?php $this->load->view('layouts/_alert'); ?>


    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Pengembalian Order #<?= $order->invoice ?>
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
                                            $ongkir = 10000;
                                        } elseif ($order->alamat_kirim == 2) {
                                            $ongkir = 15000;
                                        } elseif ($order->alamat_kirim == 3) {
                                            $ongkir = 25000;
                                        } elseif ($order->alamat_kirim == 0) {
                                            $ongkir = 0;
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
                                            $jumlah = $tambah + 10000;
                                        } elseif ($order->alamat_kirim == 2) {
                                            $tambah = array_sum(array_column($order_detail, "subtotal"));
                                            $jumlah = $tambah + 15000;
                                        } elseif ($order->alamat_kirim == 3) {
                                            $tambah = array_sum(array_column($order_detail, "subtotal"));
                                            $jumlah = $tambah + 25000;
                                        } elseif ($order->alamat_kirim == 0) {
                                            $tambah = array_sum(array_column($order_detail, "subtotal"));
                                            $jumlah = $tambah + 0;
                                        }
                                        ?>
                                        <td class="text-center"><strong>Rp<?= number_format($jumlah, 0, ",", ".") ?>,-</strong></td>
                                        <?php endif;?>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                      
                    </div>
                </div>

            </div>

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
                            <div class="card-footer">
                                <form action="<?= base_url("pengembalian/update/$my_return->id") ?>" method="POST">
                                    <div class="input-group">
                                        <input type="hidden" name="id" value="<?= $my_return->id ?>">
                                        <input type="hidden" name="id_orders" value="<?= $order->id ?>">
                                        <select name="status" id="" class="form-control">
                                            <option value="waiting" <?= $my_return->status == "waiting" ? "selected" : "" ?>>Menunggu</option>
                                            <option value="accepted" <?= $my_return->status == "accepted" ? "selected" : "" ?>>Diterima</option>
                                            <option value="refuse" <?= $my_return->status == "refuse" ? "selected" : "" ?>>Ditolak</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                        </div>
                                    </div>
                                </form>
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