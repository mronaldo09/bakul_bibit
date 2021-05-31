<main role="main" class="container">
    <?php $this->load->view("layouts/_alert"); ?>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card mb-3">
                <div class="card-header">
                    <span>Artikel</span>
                    <a href="<?= base_url('article/create') ?>" class="btn btn-sm btn-secondary">Tambah</a>

                    <div class="float-right">
                        <?= form_open(base_url("article/search"), ["method" => "POST"]) ?>
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control form-control-sm text-center" placeholder="Cari" value="<?= $this->session->userdata("keyword") ?>">
                            <div class="input-group-append">
                                <button class="btn btn-info btn-sm" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="<?= base_url("article/reset") ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eraser"></i>
                                </a>
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Description</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 0;
                            foreach ($content as $row) : $no++ ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row->title ?></td>
                                    <td><?= $row->slug ?></td>
                                    <td><?= substr($row->description, 0, 15) . " ..." ?></td>
                                    <td>

                                        <?= form_open("article/delete/$row->id", ["method" => "POST"]) ?>
                                        <?= form_hidden("id", $row->id) ?>

                                        <a href="<?= base_url("article/edit/$row->id") ?>" class="btn btn-sm"><i class="fas fa-edit text-info"></i></a>

                                        <button class="btn btn-sm" type="submit" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                        <?= form_close() ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <?= $pagination ?>
                    </nav>

                </div>
            </div>
        </div>
    </div>

</main>