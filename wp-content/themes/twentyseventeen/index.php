<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<style type="text/css">
	.post-filters button{
		line-height: .7em;
		padding: 10px;
	}
	.post-filters br{
		display: none;
	}
	.post-filters select{
		height: 1.8em;
		padding: 0 5px;
	}

	@media screen and ( max-width: 38em ) and ( min-width: 20em ) {
		.post-filters{
			text-align: left;
			line-height: 2em;
		}
		.post-filters br{
			display: block;
		}		
	}
</style>

<div class="wrap">
	<?php if ( is_home() && ! is_front_page() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php single_post_title(); ?></h1>
		</header>
	<?php else : ?>
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			
<div class='post-filters' align="center">
	<form method="GET">
	Time Filter:
	<select name="time_filter">
		<option value='recent_first'>Recent First</option>
		<option value='oldest_first'>Oldest First</option>
	</select>
	<br>
	Coin Filter:
	
<?php 
	echo '<select name="coin_filter">';
  // Add custom option as default
  echo '<option value="all">ALL</option>';

  // Get categories as array
  $categories = get_categories( 'category' );
  foreach ( $categories as $category ) :

    // Check if current term ID is equal to term ID stored in database
    $selected = ( $stored_category_id ==  $category->term_id  ) ? 'selected' : '';

    echo '<option value="' . $category->name . '" ' . $selected . '>' . $category->name . '</option>';

  endforeach;

echo '</select>';
?>
<!--		
	<select name="coin_filter">
		<option value='all'>All</option>
		<option value='STRAT'>STRAT</option>
	</select>
	Posts Per Page:
		<select name='posts_per_page'>
			<option value='10'>10</option>
			<option value='20'>20</option>
			<option value='30'>30</option>
		</select>

-->
<br>
	<button type="submit">Filter</button>
</form>

</div><hr><br>
			<?php
	$the_query = new WP_Query( array('orderby'=>'post_date','order' => 'DESC') );

if(isset($_GET)){
	if($_GET["time_filter"]=="recent_first"){
		if($_GET["coin_filter"]=="all")
			$the_query = new WP_Query( array('orderby'=>'post_date','order' => 'DESC') );
		else
			$the_query = new WP_Query( array('orderby'=>'post_date','order' => 'DESC','category_name' => $_GET["coin_filter"]) );
	}elseif ($_GET["time_filter"]=="oldest_first") {
		$the_query = new WP_Query( array('orderby'=>'post_date','order' => 'ASC') );
	}
}

			
			if ( $the_query->have_posts()) :

				/* Start the Loop */
				while ( $the_query->have_posts() ) : $the_query->the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/post/content', get_post_format() );

				endwhile;

				the_posts_pagination( array(
					'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
				) );

			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
