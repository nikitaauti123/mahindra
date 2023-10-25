<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo lang('Users.Add'); ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo lang('Users.Add'); ?></li>
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
                                        <h5 class="card-title"><?php echo lang('Roles.Add'); ?></h5>                                       
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="<?php echo base_url('/admin/users/list'); ?>" class="btn btn-primary" ><?php echo lang('Users.UsersList'); ?></a>
                                    </div>
                                    </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-md-12">
                                            <form id="add_roles" method="post" enctype="multipart/form-data">
                                              
                                                <div class="row mt-3 mb-3">
                                          
                                           
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="name"><?php echo lang('Roles.Roles'); ?><span class="red_text">*</span></label>
                                                    <input type="text" class="form-control" name="name" placeholder="<?php echo lang('Roles.Roles'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-4" for="role"><?php echo lang('Roles.Permission'); ?><span class="red_text">*</span></label>
                                                <div class="col-md-8 form-group">
                                                    <div class="permision-list  ">
                                                        <input type="checkbox" class="form-check-input" id="select_all">&nbsp;<b>Select All</b>
                                                        <?php foreach ($permission as $perm) { ?>
                                                            <div><input type="checkbox" class="form-check-input" value="<?php echo $perm['id']; ?>" name="permission_id[]" id="permission_id[]">&nbsp;<?php echo $perm['permission_id']; ?></div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                            
                                                <div class="col-4">
                                                    <div class="form-group">
                                            <label for="is_active" class="col-sm-4 control-label"><?php echo lang('Users.IsActive'); ?>?</label>
                                            <div class="col-sm-8">
                                                <div class="checkbox">
                                                <div class="toggle-switch">
                                                                <label for="cb-switch">
                                                                    <input type="checkbox" id="cb-switch"  name="is_active" >
                                                                    <span>
                                                                        <small></small>
                                                                    </span>
                                                                </label>
                                                            </div>
  </div>
                                            </div>
                                        </div></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                    <button class="btn btn-primary">
                                                      
                                                         <?php echo lang('Users.Add'); ?>
                                                        </button>  
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