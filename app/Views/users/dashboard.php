<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo lang('Left-sidebar.Menu.Dashboard'); ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo lang('Left-sidebar.Menu.Dashboard'); ?></li>
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
                    <div class="col-3">
                        <div class="form-group">
                            <label for="from_date">Date</label>
                            <input type="text" id="from_date_dashboard" name="from_date_dashboard" class="form-control" value="<?php echo date('d-m-Y'); ?>">
                        </div>
                    </div>
                    <div class="col-9 text-right">
                        <div class="form-group mt-3">
                            <a href="<?php echo base_url('admin/jobs/add'); ?>" class="btn btn-primary"><?php echo lang('Jobs.AddNewJob'); ?> </a>
                        </div>
                    </div>
                </div>
                <!-- Info boxes -->
                <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                <a href="<?=base_url();?>admin/jobs/list">
                      
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="fas fa-list"></i>
                                
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo lang('Dashboard.TotalJobs'); ?></span>
                                <span class="info-box-number" id="total_job">
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div></a>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="<?=base_url();?>admin/reports/completed_jobs_list">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-calendar-check"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo lang('Dashboard.TotCas'); ?></span>
                                <span class="info-box-number"  id="total_completed_jobs">
                                   
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-primary elevation-1">
                                <i class="fas fa-clock"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo lang('Dashboard.JobACFLeft'); ?></span>
                                <span class="info-box-number" id="JobACFLeft">
                                    6.5 hrs</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-info elevation-1">
                                <i class="fas fa-clock"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo lang('Dashboard.JobACFRight'); ?></span>
                                <span class="info-box-number" id="JobACFRight">
                                    6.5 hrs</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <!-- <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-cogs"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php //echo lang('Dashboard.OutTAT'); ?></span>
                                <span class="info-box-number">760</span>
                            </div>
                            /.info-box-content
                        </div>
                        /.info-box
                    </div> -->
                    <!-- /.col -->
                    <!-- <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1">
                                <i class="fas fa-bug"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php //echo lang('Dashboard.TotPen'); ?></span>
                                <span class="info-box-number">2,000</span>
                            </div>
                            /.info-box-content
                        </div>
                        /.info-box
                    </div> -->
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                
                

                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <div class="col-md-8">
                        <!-- TABLE: Latest Cases -->
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Latest Jobs</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table id="dashboard_list_tbl" class="table m-0">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('Dashboard.PartNo')?></th>
                                                <th><?php echo lang('Dashboard.PartName')?></th>
                                                <th><?php echo lang('Dashboard.Status')?></th>
                                                <th><?php echo lang('Dashboard.Actions')?></th>
                                            </tr>
                                        </thead>
                                        
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a> -->
                                <a href="<?=base_url()?>admin/reports/completed_jobs_list" class="btn btn-sm btn-secondary float-right">View All Jobs</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-4">
                        <!-- RECENT ACTIVITY LIST -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recent Activity</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                    <li class="item">
                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">  <span class="part-no"></span>
                                               
                                            <span class="badge badge-warning float-right start-time"></span></a>
                                            <span class="product-description process">
                                            </span>
                                        </div>
                                    </li>
                                    <!-- /.item -->
                                    <!-- <li class="item">
                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">PT7429
                                                <span class="badge badge-info float-right">13/09/2023 11:24 AM</span></a>
                                            <span class="product-description">
                                                Updated Job
                                            </span>
                                        </div>
                                    </li> -->
                                    <!-- /.item -->
                                    <!-- <li class="item">
                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">
                                                JB1848 <span class="badge badge-danger float-right">
                                                13/09/2023 10:11 AM
                                                </span>
                                            </a>
                                            <span class="product-description">
                                            Issue Job
                                            </span>
                                        </div>
                                    </li> -->
                                    <!-- /.item -->
                                    <!-- <li class="item">
                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">PT9842
                                                <span class="badge badge-success float-right">13/09/2023 09:25 AM</span></a>
                                            <span class="product-description">
                                            Completed Job     
                                            </span>
                                        </div>
                                    </li> -->
                                    <!-- /.item -->
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <!-- <div class="card-footer text-center">
                                <a href="javascript:void(0)" class="uppercase">View All</a>
                            </div> -->
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?= $this->endSection() ?>