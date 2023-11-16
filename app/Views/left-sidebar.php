<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?php echo base_url('assets/img/Mahindra_Logo_hor.jpg'); ?>" alt="Mahindra Logo" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Mahindra</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
       <!--  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url('assets/dist_list/img/user2-160x160.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin User</a>
            </div>
        </div>
 -->
        <!-- SidebarSearch Form -->
       <!--  <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <?php  
        $current_page_url = current_page_url();
        ?>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="<?php echo base_url('/admin/dashboard'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'admin/dashboard'?'active':''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                        <?php echo lang('Left-sidebar.Menu.Dashboard'); ?>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isset($current_page_url['segment'][0]) && $current_page_url['segment'][0]=='admin' && in_array($current_page_url['segment'][1], ['jobs']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            <?php echo lang('Left-sidebar.Menu.Jobs'); ?>
                            <i class="fas fa-angle-left right"></i>
                            <!-- <span class="badge badge-info right">5</span> -->
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('/jobs/left_job'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'jobs/left_job'?'active':''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('Left-sidebar.Menu.StartJobLeft'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/jobs/right_job'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'jobs/right_job'?'active':''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('Left-sidebar.Menu.StartJobRight'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/jobs/left_side_tv'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'jobs/left_side_tv'?'active':''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('Left-sidebar.Menu.StartLeftTV'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/jobs/right_side_tv'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'jobs/right_side_tv'?'active':''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('Left-sidebar.Menu.StartRightTV'); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isset($current_page_url['segment'][0]) && $current_page_url['segment'][0]=='admin' && in_array($current_page_url['segment'][1], ['parts']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-car"></i>
                        <p>
                            <?php echo lang('Left-sidebar.Menu.Parts'); ?>
                            <i class="fas fa-angle-left right"></i>
                            <!-- <span class="badge badge-info right">5</span> -->
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('/admin/parts/list'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'admin/parts/list'?'active':''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('Left-sidebar.Menu.Parts'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/admin/parts/add'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'admin/parts/add'?'active':''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('Left-sidebar.Menu.AddPart'); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>   
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isset($current_page_url['segment'][0]) && $current_page_url['segment'][0]=='admin' && in_array($current_page_url['segment'][1], ['reports']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            <?php echo lang('Left-sidebar.Menu.Reports'); ?>
                            <i class="fas fa-angle-left right"></i>
                            <!-- <span class="badge badge-info right">5</span> -->
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!--<li class="nav-item">
                        <a href="<?php //echo base_url('/admin/jobs/job_history'); ?>" class="nav-link <?php //echo $current_page_url['path'] == 'admin/parts/list'?'active':''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php //echo lang('Left-sidebar.Menu.JobsHistory'); ?></p>
                        </a>
                        </li>-->
                        <li class="nav-item">
                            <a href="<?php echo base_url('/admin/reports/completed_jobs_list'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'admin/reports/completed_jobs_list'?'active':''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('Left-sidebar.Menu.JobsCompleted'); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php echo isset($current_page_url['segment'][0]) && $current_page_url['segment'][0]=='admin' && in_array($current_page_url['segment'][1], ['users', 'roles', 'parmissions']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            <?php echo lang('Left-sidebar.Menu.Users'); ?>
                            <i class="fas fa-angle-left right"></i>
                            <!-- <span class="badge badge-info right">1</span> -->
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('/admin/users/list'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'admin/users/list'?'active':''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('Left-sidebar.Menu.Users'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/admin/roles/list'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'admin/roles/list'?'active':''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('Left-sidebar.Menu.Roles'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/admin/permissions/list'); ?>" class="nav-link <?php echo $current_page_url['path'] == 'admin/permissions/list'?'active':''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo lang('Left-sidebar.Menu.Permissions'); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>               
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>