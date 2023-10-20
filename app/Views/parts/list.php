<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo lang('Parts.List'); ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo lang('Parts.List'); ?></li>
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
                                    <div class="col-3">
                                        <h5 class="card-title"><?php echo lang('Parts.List'); ?></h5>                                       
                                    </div>
                                    <div class="col-3 text-right">
                                        <a href="<?php echo base_url('/admin/parts/import'); ?>" class="btn btn-primary" ><?php echo lang('Parts.Imports'); ?></a>
                                    </div>
                                    <div class="col-xs-3 col-md-2">
                                <button type="button" id="part-export" class="btn btn-primary"><i class="fa fa-file-excel-o"></i>&nbsp;Export</button>
                            </div>
                                    <div class="col-3 text-right">
                                        <a href="<?php echo base_url('/admin/parts/add'); ?>" class="btn btn-primary" >Add New Part</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="parts_list_tbl" class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th>Sr.No</th>
                                                        <th>Part No</th>
                                                        <th>Part Name</th>
                                                        <th>Model</th>
                                                        <th>Pins</th>
                                                        <th>Die No</th>
                                                        <th>Is Active?</th>
                                                        <th>Created Date</th>
                                                        <th>Updated Date</th>
                                                        <th>Actions</th>
                                                    </tr>             
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Sr.No</th>
                                                        <th>Part No</th>
                                                        <th>Part Name</th>
                                                        <th>Model</th>
                                                        <th>Pins</th>
                                                        <th>Die No</th>
                                                        <th>Is Active?</th>
                                                        <th>Created Date</th>
                                                        <th>Updated Date</th>
                                                        <th>Actions</th>
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