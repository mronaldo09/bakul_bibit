<!-- Page Header -->
<header class="masthead mb-5 bg-dark text-white pt-3 pb-3 text-center">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>ARTIKEL</h1>
                </div>
            </div>
        </div>
    </div>
</header>

<main role="main" class="container">
    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

            <?php foreach ($content as $row) : ?>
                <div class="post-preview">
                    <a href="<?= base_url("readarticle/detail/$row->slug") ?>">
                        <h2 class="post-title"><?php echo $row->title; ?></h2>
                    </a>
                    <div>
                        <p class="post-meta"> <?php echo substr($row->description, 0, 50); ?> </p>
                    </div>
                    <br>
                </div>
                <hr>
            <?php endforeach; ?>

            <nav aria-label="Page navigation example">
                <?= $pagination ?>
            </nav>

        </div>
    </div>
</main>