<main role="main" class="container">

    <div class="row">
        <div class="col-md-3">
            <?php $this->load->view('layouts/_menu'); ?>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Permohonan Pengembalian #<?= $order->invoice ?>
                    <div class="float-right">
                        <?php $this->load->view('layouts/_status', ["status" => $order->status]); ?>
                    </div>
                </div>
                <?= form_open_multipart($form_action, ["method" => "POST"])  ?>
                <?=
                form_hidden('id_orders', $order->id);
                ?>
                <?=
                form_hidden('status', 'waiting');
                ?>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Pengembalian</label>
                        <input type="text" class="form-control" value="<?= $order->invoice ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Keluhan</label>
                        <textarea name="note" id="" cols="30" rows="5" class="form-control">-</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Bukti</label> <br>
                        <input type="file" name="image" id="">
                        <?php if ($this->session->flashdata("image_error")) : ?>
                            <small class="form-text text-danger"><?= $this->session->flashdata("image_error") ?></small>
                        <?php endif; ?>
                        <?php if ($input->image) : ?>
                            <img src="<?= base_url("/images/confirm/$input->image") ?>" alt="" height="150">
                        <?php endif ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Kirim</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</main>