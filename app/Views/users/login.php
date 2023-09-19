<?= $this->extend('users/login-default') ?>

<?= $this->section('content') ?>
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="../../index2.html" ><img src="<?php echo base_url('assets/img/Mahindra_Logo.jpg'); ?>" /></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg"><?php echo lang('Login.SignInMsg'); ?></p>

            <form action="" id="login_form" method="post">
                <div class="input-group mb-3">
                    <input type="text" required="true" name="username" class="form-control" placeholder="<?php echo lang('Login.EmailPhone'); ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" required="true" name="password" class="form-control" placeholder="<?php echo lang('Login.Password'); ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                <?php echo lang('Login.Remember'); ?>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" id="login_btn" class="btn btn-primary btn-block"> <span class="button__text"><?php echo lang('Login.SignIn'); ?></span> </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <!-- <div class="social-auth-links text-center mt-2 mb-3">
                <a href="#" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                </a>
            </div> -->
            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="forgot-password.html"><?php echo lang('Login.ForgotPwd'); ?></a>
            </p>
            <!-- <p class="mb-0">
                <a href="register.html" class="text-center"><?php echo lang('Login.Membership'); ?></a>
            </p> -->
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->
<?= $this->endSection() ?>