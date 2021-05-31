<main role="main" class="container">
<?php $this->load->view('layouts/_alert'); ?>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                  <span>Pengembalian</span>
                 

                  <div class="float-right">
                  
                  </div>
                </div>
                <div class="card-body">
                      <table class="table mt-5">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($pengembalian as $row) : ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url("pengembalian/detail/$row->id") ?>"><strong>#<?= $row->invoice ?></strong></a>
                                </td>
                                <td><?= $row->note ?></td>
                                <td>
                                    <?= $row->status ?>
                                </td>
                            </tr>

                        <?php endforeach ?>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                      <?= $pagination; ?>
                    </nav>
                    
                </div>
              </div>
        </div>        
    </div>  

</main>