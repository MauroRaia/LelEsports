<?php if(has_post_thumbnail()) : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div id="metad"><span class="postmeta_box">
			<?php get_template_part('/includes/postmeta'); ?>
			</span>
		</div>	
	<div class="thumbnail">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if ( has_post_thumbnail() ) {the_post_thumbnail('defaultthumb');} else { ?><img src="<?php global $welcome; echo esc_url($welcome['defaulthumb']['url']) ?>" />
		<?php } ?>  </a><a href="<?php the_permalink(); ?>"><div class="info"></div></a>		
	</div> 		
	<div class="entry"><?php welcome_excerpt('welcome_excerptlength_index', 'welcome_excerptmore'); ?></div>
		<a href="<?php the_permalink();?> "><span class='readmore'><?php _e('Read More', 'welcome'); ?> <i class='fa fa-arrow-circle-right'></i></span></a>
    </article>
<?php else : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div id="metad"><span class="postmeta_box">		<?php get_template_part('/includes/postmeta'); ?></span></div>
		<div class="thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php if ( has_post_thumbnail() ) {the_post_thumbnail('defaultthumb');} else { ?><img src="<?php global $welcome; echo esc_url($welcome['defaulthumb']['url']) ?>" width="715" height="428" /><?php } ?>  </a> <a href="<?php the_permalink(); ?>"><div class="info"></div></a> </div>
		<div class="entry"><?php welcome_excerpt('welcome_excerptlength_index', 'welcome_excerptmore'); ?></div>
		<a href="<?php the_permalink();?> "><span class='readmore'><?php _e('Read More', 'welcome'); ?> <i class='fa fa-arrow-circle-right'></i></span></a>
	</article>
<?php endif; ?>
