<div id="comments">
<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ( __('Please do not load this page directly. Thanks!','minerva') );
if ( post_password_required() ) { ?>

<p class="nocomments">
  <?php echo __('This post is password protected. Enter the password to view comments.','minerva');?>
</p>
<?php
	return;
}

// Show the comments
if ( have_comments() ) : ?>
<h4><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h4>
<ol class="commentlist" id="singlecomments">
  <?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
</ol>

<?php // Begin Trackbacks ?>
<?php foreach ($comments as $comment) : ?>
<?php if ($comment->comment_type == "trackback" || $comment->comment_type == "pingback" || ereg("<pingback />", $comment->comment_content) || ereg("<trackback />", $comment->comment_content)) { ?>
<?php if (!$runonce) { $runonce = true; ?>

<h3><?php echo __('Trackbacks','minerva');?></h3>
<ol id="trackbacklist">
  <?php } ?>
  <li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>"> <cite>
    <?php comment_author_link() ?>
    </cite> </li>
  <?php } ?>
  <?php endforeach; ?>
  <?php if ($runonce) { ?>
</ol>
<?php } ?>
<?php // End Trackbacks ?>

<div class="clear" id="pagination">
  <?php previous_comments_link(__('&laquo;Older Comments','minerva')); ?>
  <?php next_comments_link(__('Newer Comments&raquo;','minerva')); ?>
</div>

<?php else : // this is displayed if there are no comments so far ?>
<?php if ('open' == $post->comment_status) : ?>
<?php else : ?>
<p class="nocomments">
  <?php echo __('Comments are closed.','minerva');?>
</p>
<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post-> comment_status) : ?>
<div id="cancel-comment-reply">
  <?php cancel_comment_reply_link(__('Cancel Reply','minerva')); ?>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
  <?php echo __('You must be','minerva');?><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"> <?php echo __('logged in','minerva');?>  </a>  <?php echo __('to post a comment','minerva');?>
  <?php else : ?>
  
  <div id="respond">
  <div id="commentform-wrap">	
    <h4><?php echo __('Leave a Reply','minerva');?></h4>
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comment-form">
    <fieldset>
    <?php if ( $user_ID ) : ?>
    <?php echo __('Logged in as','minerva');?>
      <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> &bull; <a href=" <?php echo wp_logout_url($redirect); ?>">
      <?php echo __('Log out &raquo;','minerva');?></a></p>
    <?php else : ?>
      <div>
        <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="25" tabindex="1"  class="requiredField" />
        <label for="author"><?php echo __('Name','minerva'); if($req) : ?><em>*</em><?php endif; ?></label>
      </div>
      <div>
        <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="25" tabindex="2" class="requiredField"  />
        <label for="email"><?php echo __('Email','minerva'); if($req) : ?> <em>*</em><?php endif; ?></label>
      </div>
      <div>
        <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="25" tabindex="3" class="requiredField"  />
        <label for="url"><?php echo __('Website','minerva');?></label>
      </div>
    <?php endif; ?>
    <?php comment_id_fields(); ?>
    <input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" />
      <div>
      </div>
      <textarea name="comment" id="comment" cols="40" rows="10" tabindex="4" class="textarea"></textarea>
      <?php if (get_option("comment_moderation") == "1") { ?>
      <?php echo __('Please note: comment moderation is enabled and may delay your comment. There is no need to resubmit your comment.','minerva');?>
      <?php } ?>
      <input name="submit" type="submit" id="submit"  class="comment-submit" tabindex="5" value="<?php echo __('Submit','minerva'); ?>" />
      <?php do_action('comment_form', $post->ID); ?>
    </fieldset>
    </form>
  </div>
  </div>
<?php endif; ?>
<?php endif; ?>
</div>