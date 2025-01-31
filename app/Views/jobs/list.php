<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo lang('Jobs.List'); ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo lang('Jobs.List'); ?></li>
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
                                        <h5 class="card-title"><?php echo lang('Jobs.List'); ?></h5>                                       
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="<?php echo base_url('/admin/jobs/add'); ?>" class="btn btn-primary" ><?php echo lang('Jobs.AddNewJob'); ?> </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="jobs_list_tbl" class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo lang('Jobs.SrNo'); ?></th>
                                                        <th><?php echo lang('Jobs.PartNo'); ?> </th>
                                                        <th><?php echo lang('Jobs.PartName'); ?></th>
                                                        <th><?php echo lang('Jobs.Model'); ?></th>
                                                        <th><?php echo lang('Jobs.Pins'); ?></th>
                                                        <th><?php echo lang('Jobs.DieNo'); ?> </th>
                                                        <th><?php echo lang('Jobs.Status'); ?></th>
                                                        <th><?php echo lang('Jobs.StartTime'); ?></th>
                                                        <th><?php echo lang('Jobs.EndTime'); ?></th>
                                                        <th><?php echo lang('Jobs.Actions'); ?></th>
                                                    </tr>             
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                    <th><?php echo lang('Jobs.SrNo'); ?></th>
                                                        <th><?php echo lang('Jobs.PartNo'); ?> </th>
                                                        <th><?php echo lang('Jobs.PartName'); ?></th>
                                                        <th><?php echo lang('Jobs.Model'); ?></th>
                                                        <th><?php echo lang('Jobs.Pins'); ?></th>
                                                        <th><?php echo lang('Jobs.DieNo'); ?> </th>
                                                        <th><?php echo lang('Jobs.Status'); ?></th>
                                                        <th><?php echo lang('Jobs.StartTime'); ?></th>
                                                        <th><?php echo lang('Jobs.EndTime'); ?></th>
                                                        <th><?php echo lang('Jobs.Actions'); ?></th>
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