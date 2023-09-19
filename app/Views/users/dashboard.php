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
                            <input type="text" id="from_date" class="form-control" value="<?php echo date('d-m-Y'); ?>">
                        </div>
                    </div>
                    <div class="col-9 text-right">
                        <div class="form-group mt-3">
                            <a href="<?php echo base_url('admin/jobs/add'); ?>" class="btn btn-primary">Start New Job</a>
                        </div>
                    </div>
                </div>
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-calendar-check"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo lang('Dashboard.TotCas'); ?></span>
                                <span class="info-box-number">
                                    1209
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="fas fa-cogs"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo lang('Dashboard.InTAT'); ?></span>
                                <span class="info-box-number">41,410</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-cogs"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo lang('Dashboard.OutTAT'); ?></span>
                                <span class="info-box-number">760</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1">
                                <i class="fas fa-bug"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo lang('Dashboard.TotPen'); ?></span>
                                <span class="info-box-number">2,000</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
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
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>Part No</th>
                                                <th>Part Name</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="#">PT9842</a></td>
                                                <td>LEFT DOOR</td>
                                                <td><span class="badge badge-success">Completed</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#00a65a" data-height="20"><button class="btn btn-primary">View</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">PT1848</a></td>
                                                <td>RIGHT DOOR</td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#f39c12" data-height="20"><button class="btn btn-primary">View</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">PT7429</a></td>
                                                <td>FRONT PANEL</td>
                                                <td><span class="badge badge-danger">Issue</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#f56954" data-height="20"><button class="btn btn-primary">View</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">PT7429</a></td>
                                                <td>BACK PANEL</td>
                                                <td><span class="badge badge-info">Processing</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#00c0ef" data-height="20"><button class="btn btn-primary">View</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">PT1848</a></td>
                                                <td>LEFT SIDE PANEL</td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#f39c12" data-height="20"><button class="btn btn-primary">View</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">PT7429</a></td>
                                                <td>RIGTH SIDE PANEL</td>
                                                <td><span class="badge badge-danger">Issue</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#f56954" data-height="20"><button class="btn btn-primary">View</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">PT9842</a></td>
                                                <td>BACK DOOR</td>
                                                <td><span class="badge badge-success">Completed</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#00a65a" data-height="20"><button class="btn btn-primary">View</button></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a> -->
                                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Jobs</a>
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
                                            <a href="javascript:void(0)" class="product-title">PT9842
                                                <span class="badge badge-warning float-right">13/09/2023 12:24 AM</span></a>
                                            <span class="product-description">
                                                Completed Job
                                            </span>
                                        </div>
                                    </li>
                                    <!-- /.item -->
                                    <li class="item">
                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">PT7429
                                                <span class="badge badge-info float-right">13/09/2023 11:24 AM</span></a>
                                            <span class="product-description">
                                                Updated Job
                                            </span>
                                        </div>
                                    </li>
                                    <!-- /.item -->
                                    <li class="item">
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
                                    </li>
                                    <!-- /.item -->
                                    <li class="item">
                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">PT9842
                                                <span class="badge badge-success float-right">13/09/2023 09:25 AM</span></a>
                                            <span class="product-description">
                                            Completed Job     
                                            </span>
                                        </div>
                                    </li>
                                    <!-- /.item -->
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="javascript:void(0)" class="uppercase">View All</a>
                            </div>
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