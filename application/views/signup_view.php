
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Signup</title>
    <meta name="description" content="">
    <meta name="sanjid" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  <link href="<?php echo base_url()."css/bootstrap.min.css" ?>" rel="stylesheet" />
  <link href="<?php echo base_url()."css/my_style.css" ?>" rel="stylesheet" />
  <script src="<?php echo base_url()."js/jquery.min.js" ?>"> </script>

  </head>

  <body style="padding-top:40px;">

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <?php echo anchor('welcome/index', 'iouovo', 'class="brand"'); ?>
          <ul class="nav">
            <li class="active"><?php echo anchor('welcome/dashboard','Home');?></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="fill-gray-backround">
      <div class="container">

        <div class="content">
          <div class="page-header">
            <h1>iouovo <small>Smarter way to track contributions, payments and debts</small></h1>
          </div>
          <div class="row">
            <div class="login-form">
              <div class="error-message">
                <?php echo form_error('email_signup'); ?>
                <?php echo form_error('password_signup'); ?>
                <?php echo form_error('password_signup2'); ?>
                <?php echo form_error('recaptcha_response_field'); ?>
              </div>
        			<?php $attributes = array('class' => 'form-stacked'); ?>
        			<?php echo form_open('welcome/signup',$attributes); ?>
          			<label for="email_signup">Email</label>
          			<input id="email_signup" type="email" name="email_signup" value="<?php echo set_value('email_signup'); ?>" class="span5"/>
                <br><br>
          			<label for="password_signup">Password</label>
          			<input id="password_signup" type="password" name="password_signup" value="" class="span5"/>
                <br><br>
                <label for="password_signup2">Confirm Password</label>
                <input id="password_signup2" type="password" name="password_signup2" value="" class="span5"/>
                <br><br>

                <!-- IMPORTANT: during validation, CAPTCHA should be validated before other fields -->

                <?php echo $recaptcha; ?>
                <br>
                <button type="submit" value="Submit" class="btn">Create Account</button>
        			</form>
            </div>
          </div>
        </div>

        <footer>
          <p>&copy; Middle Earth 2011</p>
        </footer>

      </div> <!-- /container -->
    </div>
  </body>
</html>
