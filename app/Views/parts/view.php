<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo lang('Parts.View'); ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><?php echo lang('Left-sidebar.Menu.Home'); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo lang('Parts.View'); ?></li>
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
                                        <h5 class="card-title"><?php echo lang('Parts.View'); ?></h5>                                       
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="<?php echo base_url('/admin/parts/list'); ?>" class="btn btn-primary" >Parts List</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-md-12">
                                            <form id="update_parts_data">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="part_name">Part Name</label> : <?php if(!empty($single['part_name'])) { echo 
                                                           $single['part_name'];}else{ echo "-";};?>
                                                          </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="part_name">Part No</label> : 
                                                            <?php if(!empty($single['part_no'])) { echo 
                                                           $single['part_no'];}else{
                                                           echo "-";
                                                           };?> </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="part_name">Model</label> : 
                                                            <?php if(!empty($single['model'])) { echo 
                                                           $single['model'];}else{
                                                            echo "-";
                                                           }?></div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="die_no">Die No</label> : 
                                                            <?php if(!empty($single['die_no'])) { echo 
                                                           $single['die_no'];}else{
                                                            echo "-";
                                                           };?></div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="die_no">Is active</label> : 
                                                                <?php if(!empty($single)) { if($single['is_active']==1){ echo "Yes";}else{
                                                        echo "No";?>
                                                     <?php }}  ?></div>
                             </div>
                                                </div>
                                                <div class="row mt-3 mb-3">
                                                    <div class="col-12">
                                                        <div class="pins-display-wrapper no-click" >
                                                        <div class="arrow-center">
                                                                <i>sd</i>
                                                            </div>
                                                            <div class="pins-display">
                                                                <?php 

                                                                $k=0;
                                                                
                                                                $alphabets = 'A B C D E F G H I J K L M N O P Q R S T U V W X Y Z AA AB';
                                                                $col_array = explode(" ", $alphabets); 
                                                                    for($i=1; $i<=14; $i++) { 
                                                                        for($j=0; $j<count($col_array); $j++) {
                                                                    ?>
                                                                        <div id="pin[<?php echo $k++; ?>]" title="<?php echo $col_array[$j].$i; ?>" class="pin-box gray-pin"><?php echo $col_array[$j].$i; ?></div>
                                                                        <?php if(($j+1)%14 == 0 && ($j/14)%2 == 0 ): ?>
                                                                            <div class="x-axis-line"></div> 
                                                                        <?php endif; ?>   
                                                                    <?php 
                                                                        } ?>
                                                                        <?php if(($i+1)%8 == 0  ): ?>
                                                                            <div class="y-axis-line"></div> 
                                                                        <?php endif; ?> 
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <div class="arrow-center">
                                                                <i class="fa fa-arrow-alt-circle-up"></i>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <input type="hidden" class="" name="id" value="<?php echo $id; ?>">
                                                        <!-- <input type="text" class="" name="is_active" value="1"> -->
                                                        
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