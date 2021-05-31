<!DOCTYPE html>
<html><head>
    <title>Document</title>
</head><body>
<table>
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($content as $row) : ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url("order/detail/$row->id") ?>"><strong>#<?= $row->invoice ?></strong></a>
                                </td>
                                <td><?= str_replace("-", "/", date("d-m-Y", strtotime($row->date))) ?></td>
                                <td>Rp<?= number_format($row->total, 0, ",", ".") ?>,-</td>
                                <td>
                                    <?php $this->load->view('layouts/_status', ["status" => $row->status]);?>
                                </td>
                            </tr>

                        <?php endforeach ?>
                        </tbody>
                    </table>
</body></html>