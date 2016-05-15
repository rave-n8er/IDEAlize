<?php


	// Initialize vars.
	$result = $Category = $Title = $Description = $Visibility = $Email = $TnCs = "";
	$errCategory = $errTitle = $errDescription = $errEmail = $errTnC = $errFile = "";

	// Grab posted form data.
    if (isset($_POST["btnSubmit"])) {
        $Category = $_POST['cboCategory'];
        $Title = $_POST['txtTitle'];
        $Description = $_POST['txtDescription'];
        $Visibility = $_POST['rdoVisibility'];
        $Email = $_POST['txtEmail'];
        $TnCs = isset($_POST['chkTnCs']) ? $_POST['chkTnCs'] : null;

		// Validate required fields.
		// Check if txtTitle has been entered.
		if (!$Title) {
			$errTitle = 'Please enter a Title';
		}
		
		// Check if txtDescription has been entered.
		if (!$Description) {
			$errDescription = 'Please enter a Description';
		}
		
		// Check if cboCategory has been selected.
		if (!$Category) {
			$errCategory = 'Please select a Category';
		}
		else {
			if ($Category == '0') {
				$errCategory = 'Please select a Category';
			}
		}

		// Check if chkTnCs has been checked.
		if (!$TnCs) {
			$errTnC = 'Please read and accept the Terms and Conditions before submitting';
		}
		
		// Check if txtEmail has been entered and is valid.
		if (!$Email || !filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			$errEmail = 'Please enter a valid email address';
		}
		
		// Upload file.
		if ($_FILES["filUpload"]["name"] != '') {
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["filUpload"]["name"]);

			if (!move_uploaded_file($_FILES["filUpload"]["tmp_name"], $target_file)) {
				$errFile = "Error uploading your file.";
			}
		}

		// Post away the data.
		if (!$errCategory && !$errTitle && !$errDescription && !$errEmail && !$errTnC && !$errFile) {
		
			// write the data to a database.
			
			// Display a confirmation/post result.
			$result = '<div class="alert alert-success"><h3><span class="glyphicon glyphicon-ok"></span> Your idea has been submitted!</h3><h4>Thank you for sharing your idea with us.</h4></div>';
		} else {
			$result = '<div class="alert alert-danger"><h3><span class="glyphicon glyphicon-warning-sign"></span> Sorry, something went wrong.</h3> <h4>Please correct input errors, and try again.</h4></div>';
        }
		
	}

?>


<!doctype html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>IDEAlize</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!--
    [if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]
    -->
    <!--Bootstrap-->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
    <!--Latest jQuery Core Library-->
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <!--Bootstrap-->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!--My CSS file-->
    <link rel="stylesheet" href="idealize.css"/>
  </head>
  <body>

    <div class="container">
      <div class="row">
        <div class="col-lg-10 col-lg-offset-2">
          <div class="col-md-10 center-block">
			<br/>
            
			<h3>IDEAlize - Solidify Your Ideas!</h3>
			<br/>
			
            <p class="required small">* = Indicates required fields</p>
			<br/>
			
            <!--begin HTML Form-->
            <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

              <div class="form-group">
                <label for="cboCategory" class="col-sm-4 control-label">
                  <span class="required">*</span>&nbsp;Category:
                </label>
                <div class="col-sm-8">
                  <select class="form-control" id="cboCategory" name="cboCategory" >
				    <option value="0" <?php echo $Category == '0' ? 'selected="selected"' : ''; ?> >Select a Category</option>
				    <option value="1" <?php echo $Category == '1' ? 'selected="selected"' : ''; ?> >Incremental</option>
				    <option value="2" <?php echo $Category == '2' ? 'selected="selected"' : ''; ?> >Disruptive</option>
				    <option value="3" <?php echo $Category == '3' ? 'selected="selected"' : ''; ?> >Radical</option>
				  </select>
				  <?php echo "<p class='text-danger'>$errCategory</p>";?>
                </div>
              </div>

              <div class="form-group">
                <label for="txtTitle" class="col-sm-4 control-label">
                  <span class="required">*</span>&nbsp;Idea Title:
                </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="txtTitle" name="txtTitle" placeholder="Title" value="<?php echo $Title;?>"/>
				  <?php echo "<p class='text-danger'>$errTitle</p>";?>
                </div>
              </div>

              <div class="form-group">
                <label for="txtDescription" class="col-sm-4 control-label">
                  <span class="required">*</span>&nbsp;Describe Your Idea:
                </label>
                <div class="col-sm-8">
                  <textarea class="form-control" rows="12" id="txtDescription" name="txtDescription" placeholder="Description"><?php echo $Description;?></textarea>
				  <?php echo "<p class='text-danger'>$errDescription</p>";?>
                </div>
              </div>

              <div class="form-group">
                <label for="filUpload" class="col-sm-4 control-label">
                  Add a Picture/Diagram:
                </label>
                <div class="col-sm-8">
                  <input type="file" class="form-control" id="filUpload" name="filUpload" accept="image/gif, image/jpeg, image/png" />
				  <?php echo "<p class='text-danger'>$errFile</p>";?>
                </div>
              </div>

              <div class="form-group">
                <label for="rdoVisibility" class="col-sm-4 control-label">
                  This Idea Is:
                </label>
                <div class="col-sm-8">
					<input type="radio" name="rdoVisibility" value="pub" checked> Public<br>
					<input type="radio" name="rdoVisibility" value="pvt"> Private<br>
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="col-sm-4 control-label">
                  <span class="required">*</span>&nbsp;Your Email:
                </label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="you@domain.com" value="<?php echo $Email;?>"/>
				  <?php echo "<p class='text-danger'>$errEmail</p>";?>
                </div>
              </div>

              <div class="form-group">
                <label for="chkTnCs" class="col-sm-4 control-label">
                  <span class="required">*</span>&nbsp;I accept the <a href="terms.html" alt="Read our Terms and Conditions here" target="_blank">T's &amp; C's</a>:
                </label>
                <div class="col-sm-8">
					<input type="checkbox" id="chkTnCs" name="chkTnCs" value="YES">
				    <?php echo "<p class='text-danger'>$errTnC</p>";?>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-4 col-sm-4 col-sm-offset-4">
				  <br/>
                  <button type="submit" id="btnSubmit" name="btnSubmit" class="btn-lg btn-primary btn-block">Submit</button>
                </div>
              </div>

 			  <div class="form-group">
			    <div class="col-sm-10 col-sm-offset-2">
					<br/>
					<br/>
					<?php echo $result;?>
			    </div>
			  </div> 
            </form>
            <!--end Form-->

          </div>
          <!--end col block-->
        </div>
        <!--end col block-->
      </div>
      <!--end row-->
    </div>
    <!--end container-->

  </body>
</html>