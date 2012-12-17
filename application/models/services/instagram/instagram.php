<?php 	
	if( $_SESSION['instagram_access_token'] ) {
	
		require( __DIR__ . '/_SplClassLoader.php' );
	    $loader = new SplClassLoader( 'Instagram', dirname( APPPATH . 'libraries/PHP-Instagram-API-master/Instagram' ) );
	    $loader->register();
		
		$instagram = new Instagram\Instagram;
		$instagram->setAccessToken( $_SESSION['instagram_access_token'] );
		
		$user = $instagram->getCurrentUser();
		$instagrams = $user->getLikedMedia();
	}
	
	else {
?>
	<a href="<?php echo APPPATH . 'libraries/PHP-Instagram-API-master/Examples/index.php' ?>">connect with instagram</a>
<?php } ?>
