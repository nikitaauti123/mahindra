<?php

/**  
 * This is view file for add jobs
 * 
 * PHP version 7
 *
 * @category JobsApiController_Class
 * @package  JobsApiController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
 echo $this->extend('theme-default'); ?>


<?php  echo $this->section('content') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo lang('Jobs.Add'); ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">
                                <?php echo lang('Left-sidebar.Menu.Home'); ?>
                        </a></li>
                            <li class="breadcrumb-item active">
                                <?php echo lang('Jobs.Add'); ?>
                        </li>
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
                                    <div class="col-4">
                                        <h5 class="card-title">
                                            <?php echo lang('Jobs.Add'); ?>
                                        </h5>                                       
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="digital-clock">00:00:00</div>
                                    </div>
                                    <div class="col-4 text-right">
                                            <a href="javascript:void(0)" 
                                            class="btn btn-primary" id="start_time">
                                                Start 
                                            </a>
                                            <a href="javascript:void(0)" 
                                            class="btn btn-secondary"  
                                            id="stop_time">
                                                Stop 
                                            </a>
                                        <a 
                                        href="<?php
                                         echo base_url('/admin/jobs/list');  ?>"
                                         class="btn btn-primary" >Jobs List</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-md-12">
                                            <form id="start_jobs_data">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="part_name">
                                                                Part Name</label>
                                                            <select name="part_name" 
                                                            id="part_name" 
                                                            class="form-control">
                                                                <option value="">
                                                                     - Select -
                                                                     </option>
                                                                <?php
                                                                foreach ($parts as $part):?>
                                                                <option value="<?php
                                                                echo $part['id'];
                                                                ?>">
                                                                    <?php 
                                                                     echo $part['part_name']; ?>
                                                            </option>
                                                                    <?php
                                                                endforeach;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="part_name">
                                                                Part No
                                                            </label>
                                                            <input type="text"
                                                             class="form-control"
                                                              name="part_no" 
                                                              placeholder="Part No" >
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="part_name">
                                                                Model
                                                            </label>
                                                            <input type="text" 
                                                            class="form-control" 
                                                            name="model"
                                                            placeholder="Model" >
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="part_name">
                                                                Bed No
                                                            </label>
                                                            <input type="text" 
                                                            class="form-control"
                                                             name="bed_no"
                                                             placeholder="Bed No" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3 mb-3">
                                                    <div class="col-12">
                                                        <div 
                                                        class="pins-display-wrapper">
                                                            <div 
                                                            class="pins-display">
                                                                <?php 

                                                                $k=0;
                                                                
                                                                $alphabets = 'A B C D E F G H I J K L M N O P Q R S T U V W X Y Z ' .
                                                                'AA AB';
                                                                  $col_array = explode(" ", $alphabets); 
                                                                for ($i=1; $i<=14; $i++) {
                                                                    for ($j=0; $j<count($col_array); $j++) {
                                                                        ?>
                                                                    <div id="pin[<?php echo $k++; ?>]" title="<?php echo $col_array[$j].$i; ?>" class="pin-box gray-pin">
                                                                    <?php echo $col_array[$j].$i; ?>
                                                                </div>
                                                                         <?php
                                                                            if (($j+1)%14 == 0 && ($j/14)%2 == 0 ):
                                                                                ?>
                                                            <div class="x-axis-line">                                                            
                                                                 </div> 
                                                                                <?php 
                                                                            endif;
                                                                            ?>   
                                                                        <?php 
                                                                    } ?>
                                                                        <?php if(($i+1)%8 == 0  ):?>
                                                                        <div class="y-axis-line">
                                                                        </div> 
                                                                        <?php endif; ?> 
                                                                        <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <input type="hidden"
                                                         class=""
                                                          name="is_active"  value="1">                                                        
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
<?php 
echo  $this->endSection() 
?>