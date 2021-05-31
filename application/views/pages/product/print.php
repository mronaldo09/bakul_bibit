

<!DOCTYPE html>
<html>
<head>
    <title>Print order</title>
</head>
<body>
    <h3>Laporan stok produk Bakul Bibit Lampung</h3>
    <br>
    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Jumlah stok</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 0;
                            foreach ($content as $row) : $no++ ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td>
                                        <p>
                                            <img src="<?= $row->image ? base_url("images/product/$row->image") : base_url("images/product/default.jpg") ?>" alt="" height="50">
                                            <?= $row->title ?>
                                        </p>
                                    </td>
                                    <td>Rp<?= number_format($row->price, 0, ",", ".") ?>,-</td>
                                    <td><?= $row->is_avaiable ? "Tersedia" : "Kosong" ?></td>
                                    <td><?= $row->jumlah_stok ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

    
    <script>
        window.print();
    </script>
</body>
</html>