<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo lang('Users.UsersList'); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo lang('Users.UsersList'); ?></li>
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
                            <div class="col-6 text-right">
                                <h5 class="card-title"><?php echo lang('Users.UsersList'); ?></h5>
                            </div>
                           
                                   
                                    <div class="col-6 text-right">
                                        <a href="<?php echo base_url('/admin/users/add'); ?>" class="btn btn-primary" ><?php echo lang('Users.AddNewUsers'); ?></a>
                                    </div>
                                    </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="users_list_tbl" class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr><th><?php echo lang('Users.SrNo'); ?></th>
                                                    <th><?php echo lang('Users.ProfilePhoto'); ?></th>
                                                    <th><?php echo lang('Users.FirstName'); ?></th>
                                                    <th><?php echo lang('Users.LastName'); ?></th>
                                                    <th><?php echo lang('Users.Email'); ?></th>
                                                    <th><?php echo lang('Users.PhoneNumber'); ?></th>
                                                    <th><?php echo lang('Users.UserName'); ?></th>
                                                    <th><?php echo lang('Users.EmployeeId'); ?></th>
                                                    <th><?php echo lang('Roles.Roles'); ?></th>
                                                   
                                                    <th><?php echo lang('Users.IsActive'); ?>?</th>
                                                    <th><?php echo lang('Users.CreatedDate'); ?></th>
                                                    <th><?php echo lang('Users.UpdatedDate'); ?></th>
                                                    <th><?php echo lang('Users.Actions'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                            <tr><th><?php echo lang('Users.SrNo'); ?></th>
                                                    <th><?php echo lang('Users.ProfilePhoto'); ?></th>
                                                    <th><?php echo lang('Users.FirstName'); ?></th>
                                                    <th><?php echo lang('Users.LastName'); ?></th>
                                                    <th><?php echo lang('Users.Email'); ?></th>
                                                    <th><?php echo lang('Users.PhoneNumber'); ?></th>
                                                    <th><?php echo lang('Users.UserName'); ?></th>
                                                    <th><?php echo lang('Users.EmployeeId'); ?></th>
                                                    <th><?php echo lang('Roles.Roles'); ?></th>
                                                    <th><?php echo lang('Users.IsActive'); ?>?</th>
                                                    <th><?php echo lang('Users.CreatedDate'); ?></th>
                                                    <th><?php echo lang('Users.UpdatedDate'); ?></th>
                                                    <th><?php echo lang('Users.Actions'); ?></th>
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