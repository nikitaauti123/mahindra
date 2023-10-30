<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo lang('Users.Edit'); ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo lang('Users.Edit'); ?></li>
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
                                        <h5 class="card-title"><?php echo lang('Users.Add'); ?></h5>                                       
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
                                            <form id="add_users" method="post" enctype="multipart/form-data">
                                              
                                                <div class="row mt-3 mb-3">
                                                <div class="col-4">
                                                <div class="form-group">
                                                    <label for="first_name"><?php echo lang('Users.FirstName'); ?><span class="red_text">*</span></label>
                                                    <input type="text" class="form-control" name="first_name" placeholder=" <?php echo lang('Users.FirstName'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="last_name"><?php echo lang('Users.LastName'); ?><span class="red_text">*</span></label>
                                                    <input type="text" class="form-control" name="last_name" placeholder="<?php echo lang('Users.LastName'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="email"><?php echo lang('Users.Email'); ?><span class="red_text">*</span></label>
                                                    <input type="text" class="form-control" name="email" placeholder="<?php echo lang('Users.Email'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="phone_number"><?php echo lang('Users.PhoneNumber'); ?><span class="red_text">*</span></label>
                                                    <input type="text" class="form-control" name="phone_number" placeholder="<?php echo lang('Users.PhoneNumber'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="username"><?php echo lang('Users.UserName'); ?><span class="red_text">*</span></label>
                                                    <input type="text" class="form-control" name="username" placeholder="<?php echo lang('Users.UserName'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="employee_id"><?php echo lang('Users.EmployeeId'); ?><span class="red_text">*</span></label>
                                                    <input type="text" class="form-control" name="employee_id" placeholder="<?php echo lang('Users.EmployeeId'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="password"><?php echo lang('Users.Password'); ?><span class="red_text">*</span></label>
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo lang('Users.Password'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="employee_id"><?php echo lang('Users.ConfirmPassword'); ?><span class="red_text">*</span></label>
                                                    <input type="password" class="form-control" name="confirm_password" placeholder="<?php echo lang('Users.ConfirmPassword'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role"><?php echo lang('Users.Role'); ?><span class="red_text">*</span></label>
                                            <select name="role_id" id="role_id" class="form-control" >
                                            <option value="">All <?php echo lang('Users.Role'); ?></option>
                                            <?php
                                        foreach ($role as $roles) {
                                              echo '<option value="' . $roles['id'] . '">' . $roles['name'] . '</option>';
                                            }
                                            ?>
                                        </select>  </div>
                                    </div>
                                          
                                                <div class="col-4">
                                                    <div class="form-group">
                                            <label for="is_active" class="col-sm-4 control-label"><?php echo lang('Users.IsActive'); ?>?</label>
                                            <div class="col-sm-8">
                                                <div class="checkbox">
                                                <div class="toggle-switch mt-1">
                                                                <label for="cb-switch">
                                                                    <input type="checkbox" id="cb-switch" name="is_active" >
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