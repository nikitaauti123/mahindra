<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo lang('Jobs.CompletedList'); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo lang('Jobs.CompletedList'); ?></li>
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
                                <div class="col-6">
                                    <h5 class="card-title"><?php echo lang('Jobs.CompletedList'); ?></h5>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="<?php echo base_url('/admin/jobs/add'); ?>" class="btn btn-primary">Add New Job</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                            <div class="col-md-3 ">
                            <div class="form-group">
                                        <label for="sel1"><?php echo lang('Parts.FromDate'); ?>:</label>
                                             <input type="text" class="form-control" id="f_date" name="f_date" placeholder="Select <?php echo lang('Parts.FromDate'); ?>" >
                                            <div class="input-group-addon  calender-icon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                    </div></div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label for="sel1"><?php echo lang('Parts.PartName'); ?>:</label>
                                        <select name="part_name_filter" id="part_name_filter" class="form-control" required="">
                                            <option value="">All <?php echo lang('Parts.PartName'); ?></option>
                                            <?php
                                            // print_r($s);exit;
                                            foreach ($part as $parts) {
                                                echo '<option value="' . $parts['id'] . '">' . $parts['part_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label for="sel1"><?php echo lang('Parts.PartNo'); ?>:</label>
                                        <select name="part_no_filter" id="part_no_filter" class="form-control">
                                            <option value="">All <?php echo lang('Parts.PartNo'); ?></option>
                                            <?php
                                            // print_r($s);exit;
                                            foreach ($part as $parts) {
                                                echo '<option value="' . $parts['id'] . '">' . $parts['part_no'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label for="sel1"><?php echo lang('Parts.Model'); ?>:</label>
                                        <select name="part_model_filter" id="part_model_filter" class="form-control">
                                            <option value="">All <?php echo lang('Parts.Model'); ?></option>
                                            <?php
                                            // print_r($s);exit;
                                            foreach ($part as $parts) {
                                                echo '<option value="' . $parts['id'] . '">' . $parts['model'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label for="sel1"><?php echo lang('Parts.DieNo'); ?>:</label>
                                        <select name="part_die_no_filter" id="part_die_no_filter" class="form-control">
                                            <option value="">All <?php echo lang('Parts.DieNo'); ?></option>
                                            <?php
                                            // print_r($s);exit;
                                            foreach ($part as $parts) {
                                                echo '<option value="' . $parts['id'] . '">' . $parts['die_no'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="completed_list_tbl" class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th><?php echo lang('Parts.SrNo'); ?></th>
                                                    <th><?php echo lang('Parts.PartName'); ?></th>
                                                    <th><?php echo lang('Parts.PartNo'); ?></th>
                                                    <th><?php echo lang('Parts.Model'); ?></th>
                                                    <th><?php echo lang('Parts.DieNo'); ?></th>
                                                    <th><?php echo lang('Parts.StartTime'); ?></th>
                                                    <th><?php echo lang('Parts.EndTime'); ?></th>
                                                   
                                                    <!-- <th>Actions</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                <th><?php echo lang('Parts.SrNo'); ?></th>
                                                    <th><?php echo lang('Parts.PartName'); ?></th>
                                                    <th><?php echo lang('Parts.PartNo'); ?></th>
                                                    <th><?php echo lang('Parts.Model'); ?></th>
                                                    <th><?php echo lang('Parts.DieNo'); ?></th>
                                                    <th><?php echo lang('Parts.StartTime'); ?></th>
                                                    <th><?php echo lang('Parts.EndTime'); ?></th>
                                                   
                                                   
                                                    <!-- <th>Actions</th> -->
                                                </tr>
                                            </tfoot>
                                        </table>
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