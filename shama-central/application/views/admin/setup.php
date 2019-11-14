<!DOCTYPE html>
<html>
<head>
	<title>Setup</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/setup.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
		
		<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>/js/setup.js"></script>

</head>
<body>
	<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
      <div class="wizard card-like">
        <form action="#">
          <div class="wizard-header">
            <div class="row">
              <div class="col-xs-12">
                <h1 class="text-center">
                  Welcome to an amazing Experience
                  <br>
                  <small>Provide us some details to get you started
                  </small>
                </h1>
                <hr />
                <div class="steps text-center">
                  <div class="wizard-step active"></div>
                  <div class="wizard-step"></div>
                  <div class="wizard-step"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="wizard-body">
            <div class="step initial active">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" class="form-control" id="firstname">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password">
                  </div>
                </div>
              </div>
            </div>
            <div class="step">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" class="form-control" id="firstname">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="repeatEmail">Repeat Email address:</label>
                    <input type="email" class="form-control" id="repeatEmail">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="repeatPassword">Repeat Password:</label>
                    <input type="password" class="form-control" id="repeatPassword">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="repeatPassword">Repeat Password:</label>
                    <input type="password" class="form-control" id="repeatPassword">
                  </div>
                </div>
              </div>
            </div>
            <div class="step">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" class="form-control" id="firstname">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="repeatEmail">Repeat Email address:</label>
                    <input type="email" class="form-control" id="repeatEmail">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="repeatPassword">Repeat Password:</label>
                    <input type="password" class="form-control" id="repeatPassword">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="repeatPassword">Repeat Password:</label>
                    <input type="password" class="form-control" id="repeatPassword">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="wizard-footer">
            <div class="row">
              <div class="col-xs-6 pull-left block-center">
                <button id="wizard-prev" style="display:none" type="button" class="btn btn-irv btn-irv-default">
                  Previous
                </button>
              </div>
              <div class="col-xs-6 pull-right text-center">
                <button id="wizard-next" type="button" class="btn btn-irv">
                  Next
                </button>
              </div>
              <div class="col-xs-6 pull-right block-center">
                <button id="wizard-subm" style="display:none" type="button" class="btn btn-irv">
                  Submit
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>