<? 
	
	return;
	
?>
	<div class="grey spacer">
	    <? if (session_id()) : ?>
	        
	        <a class="bold" href="/index.php/signout">Sign Out</a>
	        
	        <p>session-id: <? echo session_id(); ?></p>
	        	
			<p>instagram acces token: <? echo ($_SESSION['instagram_access_token']);?></p>
	    		
			<p>twitter acces token: <? var_dump ($_SESSION['access_token']);?></p>
	    
	    <? endif; ?>
	    
	</div>

	<div class="wrapper grid-width lightgrey">
    
			<div class="wall">		

				<div class="posts">
					
											    
					
					<? if( ($_SESSION['instagram_access_token']) ): ?>
						<? foreach ($instagrams as $fav) :?>
							<? /* this will have its own template - specific to teh service(model) ? */ ?>
							<article class="spacer c1_3">	
								<span>Created Date <? echo date("d M Y", $fav->getCreatedTime() ); ?></span>
							    
                                <img src="<? echo $fav->getStandardRes()->url; ?>" />	
                                <span class="right"><? echo $fav->getUser(); ?></span>
                                
							</article>
							
						<? endforeach; ?>
					<? endif; ?>
					
					
				</div>
	
			</div>
		<? //include_once( __DIR__ . '/template.php'); ?>	
		</div>