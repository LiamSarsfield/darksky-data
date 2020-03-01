<div class="modal show position-relative d-block register-login-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login or register</h5>
            </div>
            <div class="modal-body">
                <nav>
                    <ul class="nav nav-tabs register-login-tabs" id="myTab" role="tablist">
                        <li class="nav-item login-tab">
                            <a class="nav-link active" id="tab-register-tab" data-toggle="tab" href="#tab-login" role="tab-login" aria-controls="login"
                               aria-selected="true">Login</a>
                        </li>
                        <li class="nav-item register-tab">
                            <a class="nav-link" id="tab-register-tab" data-toggle="tab" href="#tab-register" role="tab-register" aria-controls="register"
                               aria-selected="false">Register</a>
                        </li>
                    </ul>
                </nav>
                <div class="tab-content" id="myTabContent">
                    <section class="tab-pane fade show active" id="tab-login" role="tabpanel" aria-labelledby="tab-login">
                        <form method="post" id="login_form" class="validate-on-submit">
                            <input type="hidden" name="action" value="login">
                            <div class="form-group">
                                <?= form_error('login_email') ?>
                                <label for="login_email">Email*</label>
                                <input type="email" name="login_email" class="form-control validate[required, custom[email]]" id="login_email" aria-describedby="emailHelp"
                                       placeholder="Enter email"
                                       autocomplete="email" value="<?php echo set_value('login_email'); ?>">
                            </div>
                            <div class="form-group">
                                <?= form_error('login_password') ?>
                                <label for="login_password">Password*</label>
                                <input name="login_password" type="password" class="form-control validate[required,minSize[8]]" id="login_password" placeholder="Password"
                                       autocomplete="current-password">
                            </div>
                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary col-sm-4 mx-auto">Login</button>
                            </div>
                        </form>
                    </section>
                    <section class="tab-pane fade" id="tab-register" role="tabpanel" aria-labelledby="tab-register">
                        <form method="post" class="validate-on-submit">
                            <input type="hidden" name="action" value="register">
                            <div class="form-group row">
                                <?= form_error('register_first_name') ?>
                                <div class="col-sm-6">
                                    <label for="register_first_name">First name*</label>
                                    <input type="text" name="register_first_name" class="form-control validate[required]" id="register-first_name" placeholder="Enter first name"
                                           autocomplete="first_name" value="<?php echo set_value('register_first_name'); ?>">
                                </div>
                                <div class="col-sm-6">
                                    <?= form_error('register_last_name') ?>
                                    <label for="register_last_name">Last name*</label>
                                    <input type="text" name="register_last_name" class="form-control validate[required]" id="register-last_name" placeholder="Enter last name"
                                           autocomplete="last_name" value="<?php echo set_value('register_last_name'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <?= form_error('register_username') ?>
                                <label for="register_username">Username*</label>
                                <input type="text" name="register_username" class="form-control validate[required]" id="register-username" placeholder="Enter username"
                                       autocomplete="email" value="<?php echo set_value('register_username'); ?>">
                            </div>
                            <div class="form-group">
                                <?= form_error('register_email') ?>
                                <label for="register_email">Email*</label>
                                <input type="email" name="register_email" class="form-control validate[required,custom[email]]" id="register-email" aria-describedby="emailHelp"
                                       placeholder="Enter email" autocomplete="email" value="<?php echo set_value('register_email'); ?>">
                            </div>
                            <div class="form-group">
                                <?= form_error('register_password') ?>
                                <label for="register_password">Password* - min length: 8</label>
                                <input name="register_password" type="password" class="form-control validate[required,minSize[8]]" id="register-password"
                                       placeholder="Enter password" autocomplete="current-password">
                            </div>
                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary mx-auto col-sm-4">Register</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
