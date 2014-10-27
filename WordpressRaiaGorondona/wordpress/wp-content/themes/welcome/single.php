<?php get_header(); ?>
<div id="page">
		<div id="page-inner" class="clearfix">	
		<div id="singlecontent"><?php welcome_breadcrumbs(); ?>
			<?php if(have_posts()) : ?>
			<?php while(have_posts())  : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/Article">
			<h1 class="entry-title" itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
			<div id="metad">
				<span class="postmeta_box">
				<?php get_template_part('/includes/postmeta'); ?><?php edit_post_link('Edit', ' &#124; ', ''); ?>
				</span>
			</div>
			<div class="entry clearfix">
				<?php global $welcome;  echo ($welcome['singleads']);?>
				<?php the_content(); ?> 
			<div class="gap"></div>
				<?php  if (get_the_tags()) :?> <span class="tags"><?php if("the_tags")	$before = '';
					$seperator = ''; // blank instead of comma
					$after = ''; the_tags("",$before, $seperator, $after ); ?>
					</span>
				<?php endif;?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'welcome' ), 'after' => '</div>' ) ); ?>
			</div> 
			<div class="gap"></div>
				<?php global $welcome;  if($welcome['authorfile']) : ?><?php get_template_part('/includes/author'); ?><?php endif; ?>
				<?php global $welcome; if( $welcome['postnavi']) : ?>
			<div id="single-nav" class="clearfix">
				<div id="single-nav-left"><i class="fa fa-arrow-circle-o-left"></i><?php previous_post_link(' <strong>%link</strong>'); ?></div>
			<div id="single-nav-right"><?php next_post_link('<strong>%link</strong> '); ?><i class="fa fa-arrow-circle-right"></i></div>
			</div>
				<?php endif;?>
				<!-- END single-nav -->
		<div class="comments">
			<?php comments_template(); ?>
		</div> <!-- end div .comments -->
	</article>
			<?php endwhile; ?>
			<?php else : ?>
		<div class="post">
			<h3><?php _e('404 Error&#58; Not Found', 'welcome' ); ?></h3>
		</div>
			<?php endif; ?>
			<?php global $welcome;  echo '<div id="footerads">' . $welcome[ 'footerads' ] .'</div>' ;?>
		</div> <!-- end div #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>