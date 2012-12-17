<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    $user= $Twitter->get_accountVerify_credentials();
?>

	<p> 
	Username: <strong> <?php echo $user->screen_name; ?> </strong>
	<br />
	Profile Image: <img src="<?php echo $user->profile_image_url; ?>" />
	<br />
	Last Tweet: <strong><?php echo $user->status->textl ?></strong><br/>
	</p>