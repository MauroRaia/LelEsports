<div class="gap"></div>
<div id="pagenavi" class="clearfix">
	<?php if( 'welcome_pagination' ) { welcome_pagination(); } else { ?>
		<?php next_posts_link('<span class="alignleft">&nbsp; &laquo; Older posts</span>') ?>
		<?php previous_posts_link('<span class="alignright">Newer posts &raquo; &nbsp;</span>') ?>
	<?php } ?>
</div> <!-- end div #pagenavi --><p></p>
<div class="gap"></div>
		<?php global $welcome;  echo '<div id="footerads">' . $welcome[ 'footerads' ] .'</div>' ;?>	