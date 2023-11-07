<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo lang('Jobs.Add'); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo lang('Jobs.Add'); ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-4">
                                    <h5 class="card-title"><?php echo lang('Jobs.Add'); ?></h5>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="digital-clock" style="display: none;">00:00:00</div>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="<?php echo base_url('/admin/jobs/list'); ?>" class="btn btn-primary"><?php echo lang('Jobs.JobsList'); ?></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="start_jobs_data_left">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <div class="col-3">
                                                <?php 

                                                $hide_start = '';
                                                $hide_stop = 'display:none';
                                                $hide_details = 'display:none';
                                                
                                                if(is_array($jobs) && count($jobs)>0) {
                                                    $hide_start = 'display:none';
                                                    $hide_stop = '';
                                                    $hide_details = '';
                                                }
                                                
                                                ?>
                                                <div class="form-group d-flex align-items-center justify-content-center">
                                                    <div class="m-1" id="start_time_left_parent" style="<?php echo $hide_start; ?>">
                                                        <select class="form-control" id="part_left_id" name="part_left_id" class="from-control">
                                                            <option value="">Select <?php echo lang('Jobs.PartName'); ?></option>
                                                            <?php
                                                            if (!empty($parts)) {
                                                                foreach ($parts as $part) {
                                                                    echo '<option value="' . $part['id'] . '">' . $part['part_name'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" id="update_id_left" name="update_id_left" value="<?php if(is_array($jobs) && count($jobs)>0) { echo $jobs[0]['part_id']; }?>" >
                                                    <div class="m-1" >
                                                        <a href="javascript:void(0)" class="btn btn-primary start_time_left" id="start_time" style="<?php echo $hide_start; ?>">
                                                            Start
                                                        </a>
                                                    </div>
                                                    <div class="m-1" >
                                                        <a href="javascript:void(0)" class="btn btn-secondary end_time_left" id="stop_time" style="<?php echo $hide_stop; ?>">
                                                            Stop
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row" id="display_part-details" style="<?php echo  $hide_details; ?>">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="part_name"><?php echo lang('Jobs.PartName'); ?></label> :
                                                    <span class="part_name"></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="part_name"><?php echo lang('Jobs.PartNo'); ?></label> :
                                                    <span id="part_no"></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="part_name"><?php echo lang('Jobs.Model'); ?></label> :
                                                    <span id="model"></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="part_name"><?php echo lang('Jobs.DieNo'); ?></label> :
                                                    <span id="die_no"></span>
                                                </div>
                                            </div>
                                        </div>
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
                                                                <div id="pin[<?php echo $k++; ?>]" title="<?php echo $col_array[$j] . $i; ?>" class="pin-box gray-pin"><?php echo $col_array[$j] . $i; ?></div>
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
                                                    <div class="d-flex align-items-baseline m-1"><span class="legend-box green-pin"></span> <label> - Correct Position</label></div>
                                                    <div class="d-flex align-items-baseline m-1"><span class="legend-box red-pin"></span> <label> - Incorrect Position</label></div>
                                                    <div class="d-flex align-items-baseline m-1"><span class="legend-box orange-pin"></span> <label> - Actual Position</label></div>
                                                    <div class="d-flex align-items-baseline m-1"><span class="legend-box gray-pin"></span> <label> - Not Placed Any Pin</label></div>
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
                    <!-- <div class="card-footer">
                            </div> -->
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- /.row -->
</div><!--/. container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection() ?>