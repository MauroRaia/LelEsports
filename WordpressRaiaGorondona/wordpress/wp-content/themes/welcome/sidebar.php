<div id="sidebar">
<?php global $welcome;  if($welcome['popular']) : ?><?php echo "<div class='box'>"; get_template_part('/includes/popular');  echo"</div>"; ?><?php endif; ?>
<?php global $welcome;  if($welcome['welcome_latest']) : ?><?php echo "<div class='box'>"; get_template_part('/includes/ltposts'); echo"</div>"; ?><?php endif; ?>
	<?php if (!dynamic_sidebar('Sidebar Right') ) : ?>				
		<?php endif; ?>	</div>	<!-- end div #sidebar -->