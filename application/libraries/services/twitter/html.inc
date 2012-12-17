<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Twitter OAuth in PHP</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <style type="text/css">
      img {border-width: 0}
      * {font-family:'Lucida Grande', sans-serif;}
    </style>
  </head>
  <body>
    <div>
      <h2>Welcome to a Twitter OAuth PHP example.</h2>

      <p>This site is a basic showcase of Twitters OAuth authentication method. If you are having issues try <a href='./clearsessions.php'>clearing your session</a>.</p>

      <p>
        Links:
        <a href='http://github.com/abraham/twitteroauth'>Source Code</a> &amp;
        <a href='http://wiki.github.com/abraham/twitteroauth/documentation'>Documentation</a> |
        Contact @<a href='http://twitter.com/abraham'>abraham</a>
      </p>
      <hr />
      <?php if (isset($menu)) { ?>
        <?php echo $menu; ?>
      <?php } ?>
    </div>
    <?php if (isset($status_text)) { ?>
      <?php echo '<h3>'.$status_text.'</h3>'; ?>
    <?php } ?>
    <p>
      <pre>
        <?php /* print_r($content); */ ?>
      </pre>
    </p>
    <? echo $output; ?>
    
    <img src="<? echo $content->profile_image_url; ?>" />
   
    <p>welcome <? echo $content->screen_name; ?></p>
    
    <? 
	
/* 	var_dump($connection->get('version/favorites'));     */
/*     var_dump() */
/*     var_dump($content->id); */
	
    $favorites = $connection->get('favorites', array(/* "user_id" => 84832050, */ "count" => 100 )); 
	    
    foreach($favorites as $index=>$post) : ?>
	    <div class="post tweet">
		    <? echo $index +1; ?>
		    
		    <? echo $post->created_at; ?>
		    <p><? echo $post->user->screen_name; ?></p>
		    <p><? echo $post->text; ?></p>
		    <? echo $post->source; ?>
		    <p>post id = <? echo $post->id_str; ?></p>
	    </div>
	    <hr/>
	    
    <? endforeach; ?>
    
    
  </body>
</html>
