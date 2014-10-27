<h4><?php _e('Popular post', 'welcome'); ?></h4>
<?php global $welcome;
	$args = array( 
	'ignore_sticky_posts' => true,
	'showposts' => 5,
	'orderby' => 'comment_count',  );
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
?>
<div class="popularpost">
	<?php if ( has_post_thumbnail() ) {the_post_thumbnail('popularpost');} else { ?><img src="<?php global $welcome; echo esc_url($welcome['defaulthumb']['url']) ?>" width="75px" height="75px"/>
	<?php } ?>
	<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><br />
	<div class="clear"></div>
</div>			
	<?php endwhile; ?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
<div style="clear:both;"></div>