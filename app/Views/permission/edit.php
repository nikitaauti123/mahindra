<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo lang('Permission.Edit'); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo lang('Permission.Edit'); ?></li>
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
                                    <h5 class="card-title"><?php echo lang('Permission.Edit'); ?></h5>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="<?php echo base_url('/admin/permissions/list'); ?>" class="btn btn-primary"><?php echo lang('Permission.PermissionList'); ?></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="update_permission" method="post" enctype="multipart/form-data">
                                        <div class="row mt-3 mb-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name"><?php echo lang('Permission.Permission'); ?></label>
                                                    <input type="text" class="form-control" name="permission_id" placeholder="<?php echo lang('Permission.Roles'); ?>">
                                                </div>
                                            </div>
                            </div><div class="row mt-3 mb-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name"><?php echo lang('Permission.Description'); ?></label>
                                                    <input type="text" class="form-control" name="description" placeholder="<?php echo lang('Permission.Description'); ?>">
                                                </div>
                                            </div>
</div>
<div class="row">

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="is_active" class="col-sm-4 control-label"><?php echo lang('Users.IsActive'); ?>?</label>
                                                    <div class="col-sm-8">
                                                        <div class="checkbox">
                                                            <div class="toggle-switch mt-1">
                                                                <label for="cb-switch">
                                                                    <input type="checkbox" id="cb-switch" name="is_active">
                                                                    <span>
                                                                        <small></small>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <input type="hidden" class="" name="id" value="<?php echo $id; ?>">

                                                <button class="btn btn-primary">

                                                    <?php echo lang('Users.Update'); ?>
                                                </button>
                                                <input type="reset" value="<?php echo lang('Reset'); ?>" class="btn btn-primary">

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