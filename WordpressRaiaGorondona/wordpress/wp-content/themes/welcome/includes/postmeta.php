<i class="fa fa-calendar-o"></i><?php welcome_post_meta_data(get_the_author_meta( 'ID' )); ?>
<span itemprop="articleSection"><i class="fa fa-bullhorn"></i><?php the_category(', '); ?></span>
<?php if ( comments_open() ) : ?><i class="fa fa-comments"></i><?php comments_popup_link( __( 'No Comment', 'welcome' ), __( '1 Comment', 'welcome' ), __( '% Comments', 'welcome' ) ); ?><?php endif; ?>