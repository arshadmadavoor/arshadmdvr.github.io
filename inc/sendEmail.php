<?php
/*
|--------------------------------------------------------------------------
| Form Process
|--------------------------------------------------------------------------
*/
if(isset($_POST['submitted'])) {

  if(trim($_POST['contactName']) === '') {
		$nameError = 'Please enter your name.';
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}

	if(trim($_POST['email']) === '')  {
		$emailError = 'Please enter your email address.';
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	if(trim($_POST['comments']) === '') {
		$commentError = 'Please enter a message.';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}
	
	if( $_POST['robot'] != '9' ) {
		$robotError = 'Are you a robot ? 4 + 5 = ?';
		$hasError = true;
	} else {
		$robot = trim($_POST['robot']);
	}

	if(!isset($hasError)) {
		$emailTo = 'arshadmdvr@gmail.com';
		$subject = 'Contact Form from '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}
	
}
?>

<?php
/*
|--------------------------------------------------------------------------
| Form
|--------------------------------------------------------------------------
*/
?>

<?php if(isset($emailSent) && $emailSent == true) { ?>
	<h3><?php echo 'Thanks, your email was sent successfully.'; ?></h3>
<?php } else { ?>
	<form action="" id="contactform" method="post">
		<p>
			<input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField" />
			<?php if($nameError != '') { ?>
				<label for="contactName"><span class="error"><?php echo $nameError; ?></span></label>
			<?php } else { ?>
				<label for="contactName"><?php echo 'Name'; ?></label>
			<?php } ?>
		</p>
		<p>
			<input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" />
			<?php if($emailError != '') { ?>
				<label for="email"><span class="error"><?php echo $emailError;?></span></label>
			<?php } else { ?>	
				<label for="email"><?php echo 'Email'; ?></label>
			<?php } ?>
		</p>
		<p>
			<?php if($commentError != '') { ?>
				<span class="error"><?php echo $commentError;?></span><br />
			<?php } ?>
			<textarea name="comments" id="commentsText" rows="10" cols="30" class="required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
		</p>
		
		<p>
			<input type="text" name="robot" id="robot" value="<?php if(isset($_POST['robot']))  echo $_POST['robot'];?>" class="required requiredField robot" />
			<?php if($robotError != '') { ?>
				<label for="robot"><span class="error"><?php echo $robotError;?></span></label>
			<?php } else { ?>	
				<label for="robot"><?php echo 'Antispam: How much is 4 + 5 ?'; ?></label>
			<?php } ?>
		</p>
		
		<p>
			<input type="submit" id="submit" value="<?php echo 'Send Email' ?>" />
		</p>
	</ul>
	<input type="hidden" name="submitted" id="submitted" value="true" />
	</form>
<?php } ?>
