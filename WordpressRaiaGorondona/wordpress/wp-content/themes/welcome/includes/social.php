<ul class="spicesocialwidget">
	<?php global $welcome; ?>
	<?php if( $welcome[ 'welcome_fb' ] ) : ?>
		<li class="facebook">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcome_fb' ] );?>" target="_blank" title="facebook"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
	<?php if( $welcome[ 'welcome_gp' ] ) : ?>
		<li class="googleplus">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcome_gp' ] );?>" target="_blank" title="googleplus"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
	<?php if( $welcome[ 'welcome_pinterest' ] ) : ?>
		<li class="pinterest">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcome_pinterest' ] );?>" target="_blank" title="pinterest"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
	<?php if( $welcome[ 'welcome_tw' ] ) : ?>
		<li class="twitter">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcome_tw' ] );?>" target="_blank" title="twitter"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
	<?php if( $welcome[ 'welcome_rss' ] ) : ?>
		<li class="rss">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcome_rss' ] );?>" target="_blank" title="rss"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
	<?php if( $welcome[ 'welcome_skype' ] ) : ?>
		<li class="skype">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcome_skype' ] );?>" target="_blank" title="Skype"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
	<?php if( $welcome[ 'welcomeimeo' ] ) : ?>
		<li class="vimeo">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcomeimeo' ] );?>" target="_blank" title="vimeo"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
	<?php if( $welcome[ 'welcome_dribbble' ] ) : ?>
		<li class="dribbble">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcome_dribbble' ] );?>" target="_blank" title="dribble"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
	<?php if( $welcome[ 'welcome_flickr' ] ) : ?>
		<li class="flickr">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcome_flickr' ] );?>" target="_blank" title="flickr"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
	<?php if( $welcome[ 'welcome_in' ] ) : ?>
		<li class="linkedin">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcome_in' ] );?>" target="_blank" title="linkedin"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
	<?php if( $welcome[ 'welcome_youtube' ] ) : ?>
		<li class="youtube">
			<a rel="nofollow" href="<?php echo esc_url( $welcome[ 'welcome_youtube' ] );?>" target="_blank" title="youtube"></a>
		</li>
	<?php else : ?>
	<?php endif; ?>
</ul>