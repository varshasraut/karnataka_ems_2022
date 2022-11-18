	<div id="login_block" style="display: block;">	
        <div class="title_login">
			<span>LOGIN</span>
			<img src="<?php echo base_url()?>images/Login_03.png" style="border:0" alt="Medi Stores" title="Medi Stores" width="" height="" />
		</div>
			<div class="login_inner">
			<div class="" id="show_errors">
					
				</div>
		   <div class="page-content">
					
				
				<?php echo form_open('home/do_login'); ?>
                    
					<div class="username">
						<div class="input input_username">
							<input type="text" class="filter_required" name="username" value="" placeholder="Username" data-errors="{filter_required:' Username should not be blank.'}" >
						</div>
					</div>
					<div class="username">
						<div class="input input_password">
							<input type="password" class="filter_required" name="password" placeholder="Password" data-errors="{filter_required:' Password should not be blank.'}">
						</div>
					</div>
					
					<div class="rememberme_forget">
						<input type="checkbox" name="remember_me" id="rememberme" />
						<label for="rememberme" class="rememberme">Remember me</label>
					
						<a data-href="<?php echo base_url()?>home/forgot_password" class="parent_login login onpage_popup" data-popupheight="316" data-popupwidth="380" data-qr="output_position=login_block" >Forget Password</a>
					</div>
					<div class="submit_login">
						<input class="form-xhttp-request" data-href="<?php echo base_url();?>home/do_login" data-qr="output_position=content" type="button" name="login_submit" value="Login" />
					</div>
				</form>
					
			</div>
			</div>
    </div>	