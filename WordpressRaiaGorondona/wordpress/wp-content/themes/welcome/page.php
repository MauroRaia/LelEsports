<?php get_header(); ?>
	<!-- BEGIN PAGE -->
	<div id="page">
    <div id="page-inner" class="clearfix">
		<div id="pagecont">
			<?php if(have_posts()) : ?><?php while(have_posts())  : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/Article">	
					<h1 class="entry-title" itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
					<div id="metad">
						<span class="postmeta_box">
							<?php get_template_part('/includes/postmeta'); ?><?php edit_post_link('Edit', ' &#124; ', ''); ?>
						</span>
					</div>
					<div class="entry" class="clearfix">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'welcome' ), 'after' => '</div>' ) ); ?>
					</div> <!-- end div .entry -->
						<?php global $welcome;  if($welcome[ 'flowshare' ]) : ?><?php get_template_part('/includes/share'); ?><?php endif; ?>
						<div class="gap"></div>
						<?php global $welcome;  if($welcome[ 'authorfile' ]) : ?><?php get_template_part('/includes/author'); ?><?php endif; ?>
					<div class="comments">
						<?php comments_template(); ?>
					</div> <!-- end div .comments -->
				</article> <!-- end div .post -->
			<?php endwhile; ?>
			<?php else : ?>
		<div class="post">
			<h3><?php _e('404 Error&#58; Not Found', 'welcome'); ?></h3>
		</div>
			<?php endif; ?>
			<?php global $welcome;  echo '<div id="footerads">' . $welcome[ 'footerads' ] .'</div>' ;?>							
		</div> <!-- end div #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>