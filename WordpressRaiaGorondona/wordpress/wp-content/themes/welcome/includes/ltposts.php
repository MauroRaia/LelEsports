<?php global $welcome;  if ( $welcome['welcome_latest'] =='1') { ?>
<h4><?php _e('Latest Posts', 'welcome'); ?></h4>
<?php global $welcome; 
$args = array( 
 'ignore_sticky_posts' => true,
 'showposts' => $welcome['latestpostnumber'],
'orderby' => 'date',  );
$the_query = new WP_Query( $args );
 if ( $the_query->have_posts() ) :
while ( $the_query->have_posts() ) : $the_query->the_post();
			 ?>
								<div class="latest-post">
									<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php if ( has_post_thumbnail() ) {the_post_thumbnail('latestpost');} else { ?><img src="<?php global $welcome; echo esc_url($welcome['defaulthumb']['url']) ?>"/><?php } ?></a> 
									 <a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><br />
									 <div class="desc"><?php welcome_excerpt('welcome_excerptlength_index', 'welcome_excerptmore'); ?></div>
									 									 <div class="clear"></div></div>
							<?php endwhile; ?>
							<?php endif; ?>			 <?php wp_reset_postdata(); ?>
			<div style="clear:both;">
			</div>
			
			<?php } ?>	