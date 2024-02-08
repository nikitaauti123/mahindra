<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo lang('Notification.List'); ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo lang('Notification.List'); ?></li>
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
                                        <h5 class="card-title"><?php echo lang('Notification.List'); ?></h5>                                       
                                    </div>
                                   </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <form action="" id="notification_form">
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <input type="hidden" name="uri_segment" id="uri_segment" value="<?php if(!empty($job_action_id)){ echo $job_action_id;}?>">
                                            <label for="sel1"><?php echo lang('Parts.FromDate'); ?>:</label>
                                            <input type="text" class="form-control" id="from_date_notification" name="from_date" placeholder="Select <?php echo lang('Parts.FromDate'); ?>">
                                            <div class="input-group-addon  calender-icon">
                                                <i class="fa fa-calendar  notification-calender"></i>
                                            </div>
                                        </div>
                                    </div>                       
                                 
                                   
                                </div>
                            </form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="notification_list_tbl" class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo lang('Notification.SrNo'); ?></th>
                                                        <th><?php echo lang('Notification.die_no'); ?> </th>
                                                        <th><?php echo lang('Notification.msg'); ?></th>
                                                        <th><?php echo lang('Notification.created_date'); ?></th>
                                                        <th><?php echo lang('Notification.status'); ?></th>                                                        
                                                        <th><?php echo lang('Notification.Action'); ?></th>
                                                    </tr>             
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                    <th><?php echo lang('Notification.SrNo'); ?></th>
                                                        <th><?php echo lang('Notification.die_no'); ?> </th>
                                                        <th><?php echo lang('Notification.msg'); ?></th>
                                                        <th><?php echo lang('Notification.created_date'); ?></th>
                                                        <th><?php echo lang('Notification.status'); ?></th>
                                                        <th><?php echo lang('Notification.Action'); ?></th>
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