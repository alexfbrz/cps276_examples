<?php

get_header();

if(have_posts()) : 
	while(have_posts()) : the_post(); ?>

	<article class="post">
		
	<!-- CHECK TO SEE IF WE HAVE CHILDREN OR GET THE PARENT POST -->
	<?php if(has_children() || $post->post_parent > 0){ ?>


		<nav class="site-nav children-links clearfix">

			<!-- DISPLAY THE PARENT LINK AND LINK BACK TO THE PARENT PAGE -->
			<span class="parent-link"><a href="<?php echo get_the_permalink(get_top_ancestor_id())?>"><?php echo get_the_title(get_top_ancestor_id()) ?></a></span>

			<!-- GO THOUGH ALL THE CHILD LINKS FOR THAT PARENT AND DISPLAY THEM.  ALSO THE TITLE_LI IS SET TO AN EMPTY STRING SO THAT A EMPTY BULLET POINT WILL NOT BE SHOWN. -->
			<ul>
			<?php
				$args = array(
					'child_of' => get_top_ancestor_id(),
					'title_li' => ''
				);

				wp_list_pages($args); 

			 ?>
			</ul>
		</nav>

		<?php } ?>

		<h2 class="page"><?php the_title(); ?></h2>

		<?php the_content(); ?>
	</article>

	<?php endwhile;

	else :
		echo '<p>No content found</p>';

	endif;

get_footer();
?>

