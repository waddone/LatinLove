<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myLoginLabel">LOGIN</h4>
    </div>
    <div class="modal-body" id="log_content">
        <?
        //$alert_message           = $_SESSION['alert_modal'];
        //$_SESSION['alert_modal'] = "";unset($_SESSION['alert_modal']);
        //$old_post                = unserialize($_SESSION['old_post']);
        //$_SESSION['old_post']    = "";unset($_SESSION['old_post']);
        ?>
        <form method="post" action="/" id="loginForm">
            <input type="hidden" name="from_what_form" value="login">
            <input type="hidden" name="version" value="newLayout">
            <div class="form-group">
                <input class="form-control" type="text" name="login_email" value="" placeholder="e-mail address" />
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="login_password" value="" placeholder="password"  />
            </div>
            <div class="row">
                <div class="col-xs-12 terms_and_cond">
                    <div class="form-group">
                        <div class="checkbox">
                            <input type="checkbox" class="styled-checkbox" name="remember_me" value="remember_me" />
                            <label for="styled-checkbox-2">remember me</label>
                        </div>
                    </div>
                </div>
                <?//if (!is_null($alert_message)):?>
                    <div class="col-md-12 alert_modal">
                        <?// if(count($alert_message) > 1) {
                            //foreach ($alert_message as $alert_message_r) { echo $alert_message_r.'<br/>'; }
                        //} if(count($alert_message) == 1) {
                        //    echo $alert_message;
                        //} ?>
                    </div>
                <?// endif; ?>
                <div class="col-xs-12">
                    <div class="form-group text-center margin_btn_10">
                        <br/>
                        <button type="submit" class="btn btn-default-new-layout btn-small-white-register-login">
                            LOGIN       
                        </button>
                    </div>
                    <div class="row oder_fb">            
                        <div class="col-xs-5 line_befor_oder_fb"></div>
                        <div class="col-xs-2 text-center">
                            OR
                        </div>
                        <div class="col-xs-5 line_after_oder_fb"></div>
                    </div>
                                   
                </div>
            </div>
        </form>
    </div>
    <div class="modal-body" id="reset_content">
        <div class="form-group text-center terms_and_cond">
            
            <div class="collapse" id="collapsepassword">
                <div class="well">      
                    <form method="POST" action="/">
                        <input type="hidden" name="from_what_form" value="forgot">
                        <input type="hidden" name="version" value="newLayout">
                        <p>forgot password?</p>
                        <div class="form-group">
                            <input type="email" name="forgot_password_email" class="form-control" id="exampleInputEmail1" placeholder="e-mail address">
                        </div>
                        <button type="submit" class="btn btn-default-new-layout btn-small-white">SEND</button> 
                    </form>
                </div>
            </div>
            <br/>
            <a type="button" data-toggle="collapse" data-target="#collapsepassword" aria-expanded="false" aria-controls="collapsepassword" id="switch_txt_login">forgot password?</a>
            
        </div>
    </div>
    <div class="modal-footer">
        <?//=get_translation("switch_to_register_text"); ?> <a class="RegisterForm" id="RegisterForm_load" onclick="loadLoginForm(this.className); return false"><?//=get_translation("switch_to_register"); ?></a>
    </div>
</div>