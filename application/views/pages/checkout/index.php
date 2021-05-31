<main role="main" class="container">
    <?php $this->load->view("layouts/_alert"); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Formulir Alamat Pengiriman
                </div>
                <div class="card-body">
                    <form action="<?= base_url("/checkout/create") ?>" method="POST">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama penerima" value="<?= $input->name ?>">
                            <?= form_error("name") ?>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="address" id="" cols="30" rows="5" class="form-control"><?= $input->address ?></textarea>
                            <?= form_error("address") ?>
                        </div>
                        <div class="form-group">
                            <label for="">Kota/Kabupaten</label>
                            <select name="alamat_kirim" class="form-control" id="tujuan" onchange="proses()" required>
        
                                <option selected>-- Pilih daerah kirim --</option>
                                
                                <!-- 5 opsi ongkir -->
                                <option value="1">Lampung Barat</option>
                                <option value="1">Lampung Selatan</option>
                                <option value="1">Lampung Timur</option>
                                <option value="1">Lampung Tengah</option>
                                <option value="1">Mesuji</option>
                                <option value="1">Pesawaran</option>
                                <option value="1">Lampung Utara</option>
                                <option value="1">Pesisir Barat</option>
                                <option value="1">Pringsewu</option>
                                <option value="1">Tanggamus</option>
                                <option value="1">Tulang Bawang</option>
                                <option value="1">Tulang Bawang Barat</option>
                                <option value="1">Waykanan</option>
                                <option value="1">Metro</option>
                                
                                <option value="1">Jakarta barat</option>
                                <option value="1">Jakarta selatan</option>
                                <option value="1">Jakarta pusat</option>
                                <option value="1">Jakarta timur</option>
                                <option value="1">Jakarta utara</option>
                                
                                <option value="2">Tangerang</option>
                                <option value="3">Serang</option>
                                <option value="3">Cilegon</option>
                                
                                <option value="5">Prabumulih</option>
                                <option value="4">Palembang</option>
                                <option value="5">Pagar Alam</option>
                                <option value="5">Lubuk Linggau</option>
                                <option value="5">Lahat</option>
            
                            </select>
                            <?= form_error("alamat_kirim") ?>
                        </div>
                        <div class="form-group">
                            <label for="">Ongkir</label>
                            <?php if(array_sum(array_column($cart, "subtotal")) >= 150000): ?>
                            <input type="text" class="form-control" value="Gratis ongkir" readonly>
                            <?php else: ?>
                            <input type="text" class="form-control" name="harga" id="harga" readonly>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="">Telepon</label>
                            <input type="text" class="form-control" name="phone" placeholder="Masukkan nomor telpon penerima" value="<?= $input->phone ?>">
                            <?= form_error("phone") ?>
                        </div>

                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="col md-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            Cart
                        </div>

                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart as $row) : ?>
                                        <tr>
                                            <td><?= $row->title ?></td>
                                            <td><?= $row->qty ?></td>
                                            <td>Rp<?= number_format($row->price, 0, ",", ".") ?>,-</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Subtotal</td>
                                            <td>Rp<?= number_format($row->subtotal, 0, ",", ".") ?>,-</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th>Rp<?= number_format(array_sum(array_column($cart, "subtotal")), 0, ",", ".") ?>,-</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
    function proses(){
        var harga=document.getElementById("tujuan").value;

                if(harga == 1){
                    document.getElementById("harga").value="Rp.20.000";
                }else if(harga == 2){
                    document.getElementById("harga").value="Rp.22.000";
                }else if(harga == 3){
                    document.getElementById("harga").value="Rp.23.000";
                }else if(harga == 4){
                    document.getElementById("harga").value="Rp.25.000";
                }else if(harga == 5){
                    document.getElementById("harga").value="Rp.26.000";
                }
    }
</script>