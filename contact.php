<?php
/*
Template Name: Contact
*/
?>


<?php 
//If the form is submitted
if(isset($_POST['submitted'])) {

	//Check to see if the honeypot captcha field was filled in
	if(trim($_POST['checking']) !== '') {
		$captchaError = true;
	} else {
	
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$nameError = 'You forgot to enter your name.';
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}
		
		//Check to make sure that the name field is not empty
		if(trim($_POST['phone']) === '') {
			$phoneError = 'You forgot to enter your phone.';
			$hasError = true;
		} else {
			$phone = trim($_POST['phone']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$emailError = 'You forgot to enter your email address.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		//Check to make sure comments were entered	
		if(trim($_POST['comments']) === '') {
			$commentError = 'You forgot to enter your comments.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}
			
		//If there is no error, send the email
		if(!isset($hasError)) {

			$emailTo = get_option('admin_email');
			$subject = 'Contact Form Submission from '.$name;
			$sendCopy = trim($_POST['sendCopy']);
			$body = "Nombre: $name \n\nEmail: $email \n\nTelefono: $phone \n\nMensaje: $comments";
			$headers = 'From: Contact Form <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			mail($emailTo, $subject, $body, $headers);

			if($sendCopy == true) {
				$subject = 'You emailed Your Name';
				$headers = 'From: Your Name <noreply@somedomain.com>';
				mail($email, $subject, $body, $headers);
			}

			$emailSent = true;

		}
	}
} ?>


<?php get_header(); ?>

<div class="hfeed main_content">
	<div class="main_content_inner">
	
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<h2>
					<?php the_title(); ?>
				</h2>
				<div class="entry clearfix">
					<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
					<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
				</div>
			</div>
			<?php endwhile; else: ?>
			<?php endif; ?> 
			
			<div class="clearfix">
			
         	<?php if(isset($emailSent) && $emailSent == true) { ?>
			<div class="thanks">
				<?php /*?><p>Su comentario fue enviado exitosamente. Muy pronto nos pondremos en contacto con usted.</p><?php */?>
				<p>Your email was successfully sent. I will be in touch soon.</p>
			</div>
		
			<?php } else { ?>
			
			<?php if(isset($hasError) || isset($captchaError)) { ?>
				<?php /*?><p class="error">No se pudo enviar su comentario. Vuelva a intentarlo por favor.<p><?php */?>
				<p class="error">There was an error submitting the form.<p>
			<?php } ?>
		
			<form id="contact_form" action="<?php the_permalink(); ?>" method="post" class="clearfix contact_form">
				
				<fieldset class="form_left">
					
					<dl class="clearfix">
						<dt><label for="contactName">Nombre*</label></dt>
						<dd><input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required text" />
						<?php if($nameError != '') { ?>
							<span class="error"><?=$nameError;?></span> 
						<?php } ?>
						</dd>
					</dl>
					
					<dl class="clearfix">
						<dt><label for="email">Email*</label></dt>
						<dd><input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required text email" />
						<?php if($emailError != '') { ?>
							<span class="error"><?=$emailError;?></span>
						<?php } ?></dd>
					</dl>
					
					<dl class="clearfix">
						<dt><label for="phone">Tel&eacute;fono*</label></dt>
						<dd><input type="text" name="phone" id="phone" value="<?php if(isset($_POST['phone']))  echo $_POST['phone'];?>" class="required text" />
						<?php if($phoneError != '') { ?>
							<span class="error"><?=$phoneError;?></span>
						<?php } ?></dd>
					</dl>
						
					<dl class="clearfix">
						<dt><label for="comments">Mensaje</label></dt>
						<dd><textarea name="comments" id="comments" rows="20" cols="30" class="required"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
						<?php if($commentError != '') { ?>
							<span class="error"><?=$commentError;?></span> 
						<?php } ?></dd>
					</dl>
					
					<p class="text_required">(*) Campos obligatorios</p>

					<input type="hidden" name="submitted" id="submitted" value="true" />
					
					<div class="clearfix">
						<p class="enviar float_right">	
							<button type="submit">Enviar</button>
						</p>
					</div>
				
				</fieldset>
				
				
				
			</form>
				
			<?php } ?>
			
			</div>     
			
	</div>  
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
	