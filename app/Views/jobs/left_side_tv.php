<?= $this->extend('theme-tv') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body no-pad">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="left_side_tv_display">
                                        <div class="row mt-3 mb-3">
                                            <div class="col-12">
                                                <div class="pins-display-wrapper">
                                                    <div class="arrow-center">
                                                        <i>sd</i>
                                                    </div>
                                                    <div class="pins-display no-click">
                                                        <?php

                                                        $k = 0;

                                                        $alphabets = 'A B C D E F G H I J K L M N O P Q R S T U V W X Y Z AA AB';
                                                        $col_array = explode(" ", $alphabets);
                                                        for ($i = 1; $i <= 14; $i++) {
                                                            for ($j = 0; $j < count($col_array); $j++) {
                                                        ?>
                                                                <div id="<?php echo $col_array[$j] . $i; ?>" title="<?php echo $col_array[$j] . $i; ?>" class="pin-box gray-pin"><?php echo $col_array[$j] . $i; ?></div>
                                                                <?php if (($j + 1) % 14 == 0 && ($j / 14) % 2 == 0) : ?>
                                                                    <div class="x-axis-line"></div>
                                                                <?php endif; ?>
                                                            <?php
                                                            } ?>
                                                            <?php if (($i + 1) % 8 == 0) : ?>
                                                                <div class="y-axis-line"></div>
                                                            <?php endif; ?>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="arrow-center">
                                                        <i class="fa fa-arrow-alt-circle-up"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"></div>
                                            <div class="col-md-6  d-flex justify-content-end">
                                                <div class="color-legends background-white d-flex align-items-center">
                                                    <div class="d-flex align-items-baseline m-1"><span class="legend-box green-pin"></span> <label> &nbsp; Correct Position</label></div>
                                                    <div class="d-flex align-items-baseline m-1"><span class="legend-box red-pin"></span> <label> &nbsp; Incorrect Position</label></div>
                                                    <div class="d-flex align-items-baseline m-1"><span class="legend-box orange-pin"></span> <label> &nbsp; Actual Position</label></div>
                                                    <div class="d-flex align-items-baseline m-1"><span class="legend-box gray-pin"></span> <label> &nbsp; Not Placed Any Pin</label></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection() ?>