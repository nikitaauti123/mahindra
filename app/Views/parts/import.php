<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo lang('Parts.Imports'); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo lang('Parts.Imports'); ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row" id="">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title"><?php echo lang('Parts.Imports'); ?></h5>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="<?php echo base_url('/admin/parts/list'); ?>" class="btn btn-primary"><?php echo lang('Parts.PartList'); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="drop_file_zone" ondrop="upload_file(event, 'bulk_import_parts')" ondragover="return false">
                                        <div id="drag_upload_file">
                                            <p>Drop file here</p>
                                            <p>or</p>
                                            <p>
                                                <input type="button" id="drag_upload_btn" value="Select File" onclick="file_explorer('bulk_import_parts');" />
                                            </p>
                                            <input type="file" id="selectfile" />
                                        </div>
                                        <div id="drag_upload_msg" style="display:none; text-align:center;">Please wait processing...</div>
                                    </div>
                                </div>
                                <br>
                                <i>Notes: <br> 1. .CSV, .xls, .xlsx files format allowed to upload. <br> 2. Export roles for sample. <br> 3. Please do not change the column header row in the exported file. <br> 4. Duplicate roles will be ignore.</i>
                                <div class="img-content"></div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.box -->
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