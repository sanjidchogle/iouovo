
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  <link href="<?php echo base_url()."css/bootstrap.min.css" ?>" rel="stylesheet" />
  <link href="<?php echo base_url()."css/my_style.css" ?>" rel="stylesheet" />
  <script src="<?php echo base_url()."js/jquery.min.js" ?>"> </script>

  </head>

  <body style="padding-top:40px;" class="fill-gray-background">

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <?php echo anchor('welcome/index', 'iouovo', 'class="brand"'); ?>
          <ul class="nav">
            <li class="active"><?php echo anchor('welcome/index','Home');?></li>
          </ul>
        </div>

      </div>

    </div>
    <div class="fill-hero-unit">
    <div class="container">
      <div class="hero-unit hero1">
        <h1><img src="<?php echo base_url()."img/iouovo2-blue3.png" ?>" alt="iouovo" /></h1>
        <p>iouovo is a system for managing shared expenses, debts, and payments among group of friends.<br>
        Its free, quick and extremely simple.
        </p>
        <p><a class="btn primary large">Learn more »</a></p>
      </div>      
    </div>
    </div>
    <div class="fill-gray-backround">
    <div class="container">

      <div class="content">
        <div class="row">
          <div class="span5">
            <div class="center-aligned">
            <?php $attributes = array('class'=>"form-stacked"); ?>
            <?php echo form_open('welcome/login',$attributes); ?>
            <fieldset>
              <legend>Sign in</legend>
              <label for ="email">Email</label>
              <input name="email" id="email" type="email">
              <br><br>
              <label for ="password">Password</label>
              <input name="password" id="password" type="password">
              <br><br>
              <button class="btn" type="submit">Sign In</button>
            </fieldset>
            </form>
            </div> <!--- center aligned-->
            </div> <!--- span8-->

          <div class="span5 offset6">
            <?php $attributes = array('class'=>"form-stacked"); ?>
            <?php echo form_open('welcome/signup',$attributes); ?>
            <fieldset >
              <legend>New to iouovo? Join now</legend>
              <label for ="email_signup">Email</label>
              <input name="email_signup" id="email_signup" type="email">
              <br><br>
              <label for ="password_signup">Password</label>
              <input name="password_signup" id="password_signup" type="password">
              <br><br>
              <label for ="password_signup2">Confirm Password</label>
              <input name="password_signup2" id="password_signup2" type="password">
              <br><br>
              <button class="btn" type="submit">Sign Up</button>
            </fieldset>
            </form>
            </div> <!-- span8-->


        </div ><!--- row-->

      </div> <!--- content-->

      <footer>
      <p>&copy; Middle Earth 2011</p>
      </footer>
    </div> <!-- /container -->
    </div> <!-- /fill-gray-backround -->

  </body>
</html>
