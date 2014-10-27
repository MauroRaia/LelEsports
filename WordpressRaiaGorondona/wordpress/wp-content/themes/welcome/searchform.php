<form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<div>
	<input type="text" value="<?php _e('Search', 'welcome'); ?>" name="s" id="s" onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search';}" />
		<input type="submit" id="searchsubmit" value="<?php _e('Go', 'welcome'); ?>" />
	</div>
</form>
