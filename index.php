<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>

<!-- Page Content -->
<div class="container" style="background-image: url('https://picsum.photos/1920/1080'); background-size: cover; background-repeat: no-repeat;">
    <div class="row">
        <!-- categorie ici -->
        <div class="col-md-9">
            <div class="row carousel-holder">
                <div class="col-md-12">
                    <!-- pour swipe -->
                    <?php include(TEMPLATE_FRONT . DS . "slider.php") ?>
                </div>
            </div>

            <div class="row">
                <?php get_products(); ?>
            </div> <!-- End here(row) -->
            <?php include_once('bloc_recommended.php'); ?>
            <?php include_once('bloc_favorite.php'); ?>
        </div>
    </div>
</div>
<!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>









   







    