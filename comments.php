<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?><p>
				
				<?php return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<div id="commentcontainer">
	<h4><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h4> 
	<div id="replies">

	<?php if ($comments) : ?>
  	<ol id="comments">
	<?php foreach ($comments as $comment) : ?>
		<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
			
			<?php if ($comment->comment_approved == '0') : ?>
			<em>Your comment is awaiting moderation.</em>
			<?php endif; ?>
			
			<?php comment_text() ?>
			<?php if(function_exists('get_avatar')) { echo get_avatar($comment, '40'); } ?>
			<cite><?php comment_author_link() ?> on <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('m.d.y') ?></a> (<?php edit_comment_link('e','',''); ?>)</cite>
		</li>

	<?php /* Changes every other comment to a different class */	
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>
	<?php endforeach; /* end for each comment */ ?>
	</ol>

<?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post-> comment_status) : ?> 
	<!-- If comments are open, but there are no comments. -->		
	<?php else : // comments are closed ?>
	<!-- If comments are closed. -->
	<span>Comments are closed.</span>		
	<?php endif; ?>
<?php endif; ?>
</div>
<?php if ('open' == $post-> comment_status) : ?>

<div id="reply">

	<h4>Leave a Reply</h4>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

	<form id="commentform" method="post"action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php">

<?php if ( $user_ID ) : ?>
	<p>
		Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php">
		<?php echo $user_identity; ?></a>.
		<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a>
	</p>

<?php else : ?>
	<p>
		<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
		<label for="author">
			<small>Name <?php if ($req) _e('(required)'); ?></small>
		</label>
	</p>
	<p>
		<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
		<label for="email">
			<small>E-mail <?php if ($req) _e('(required)'); ?></small>
		</label>
	</p>
	<p>
		<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
		<label for="url">
			<small>Website</small>
		</label>
	</p>
	
<?php endif; ?>

<!--
	<p>
		<small>
			<strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?>
		</small>
	</p>
-->
	<p>
		<textarea name="comment" id="comment" cols="35" rows="10" tabindex="4"></textarea>
	</p>
	<p>
		<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	</p>
<?php do_action('comment_form', $post->ID); ?>

	</form>
</div>
<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
</div>