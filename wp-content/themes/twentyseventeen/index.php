
<?php
  $tweets = getTweets(10,"altmanagerhq",['exclude_replies' => true,'result_type'=>'recent','tweet_mode'=>'extended']);

  $data;
  $data2;
  $tweet_date;
  $count = 1;
  foreach($tweets as $key) {
  $data[$count-1]=$key[full_text];
  $tweet_date[$count-1]=$key[created_at];
  $count++;
  }


  $extracted;
  $index=0;

  foreach ($data as $key => $value) {
  if(preg_match("/([$]+)(.*)(SIGNAL)+/s", $value)){


  $data2 = preg_split("/[\s,]+/", $value,4);

  unset($data2[0]);
  unset($data2[2]);
  $data2 = array_merge($data2);

  //---------name
  $extracted[$index][0]=$data2[0];

  // ------ P/V
  if(preg_match("/Price/i", $data2[1]))
  $extracted[$index][1]="Price";
  else
  $extracted[$index][1]="Volume";

  // ------ U/D
  if(preg_match("/up/i", $data2[1]))
  $extracted[$index][2]="Up";
  else
  $extracted[$index][2]="Down";

  //--- 1H value
  $data3 = preg_split("/1H \(/", $data2[1],2);
  $extracted[$index][3]=preg_split("/%\)/",$data3[1],2)[0];

  //--- 4H value
  $data3 = preg_split("/4H \(/", $data2[1],2);
  $extracted[$index][4]=preg_split("/%\)/",$data3[1],2)[0];

  //change
  $data3 = preg_split("/[Price:|Voume:]+/", $data3[1],2);
  $data3 = preg_split("/[(BTC \->)|(BTC)|(USDT \->)|(USDT)|(ETH \->)|(ETH)]+/", $data3[1],5);

  $extracted[$index][5]=$data3[1];
  $extracted[$index][6]=$data3[3];

  // ---- 1D value
  $data3 = preg_split("/1D \(/", $data2[1],2);
  $extracted[$index][7]=preg_split("/%\)/",$data3[1],2)[0];
  // ---- 1D %
  if($extracted[$index][1]=="Volume"){
  $data3 = preg_split("/( - )+/", $data3[1],2);
  $extracted[$index][8]=preg_split("/[(BTC)|(USDT)|(ETH)]+/",$data3[1],2)[0];
  }else
  $extracted[$index][8]="-";

  //---- 7D value
  $data3 = preg_split("/7D \(/", $data2[1],2);
  $extracted[$index][9]=preg_split("/%\)/",$data3[1],2)[0];
  //---- 7D %
  if($extracted[$index][1]=="Volume"){
  $data3 = preg_split("/( - )+/", $data3[1],2);
  $extracted[$index][10]=preg_split("/[(BTC)|(USDT)|(ETH)]+/",$data3[1],2)[0];
  }else
  $extracted[$index][10]="-";

  $index++;
  }

  }
  $index = 0;
  foreach ($extracted as $row){
  $dt = $tweet_date[$index];

  $postTitle = $row[0].' '.$row[1].' '.$row[2].' Signal';

  $posts = get_posts(['meta_key' => 'tweet_dateTime', 'meta_value' => $dt]);

       if (count($posts) == 0){
          $post = array(
                'post_status' => 'publish',
                'post_title' => $postTitle,
                'post_content' => "
                <table style='border: 1px solid black'>
                <tr><td>1H: </td><td>".$row[3]."%</td></tr>
                <tr><td>4H: </td><td>".$row[4]."%</td></tr>
                <tr><td>".$row[1].": </td><td>".$row[5]." -> ".$row[6]."</td></tr> 
                <tr><td>1D: </td><td>(".$row[7]."%) - ".$row[8]."</td></tr>
                <tr><td>7D: </td><td>(".$row[9]."%) - ".$row[10]."</td></tr>
                </table>"
              );
              $post_id = wp_insert_post($post);
              add_post_meta($post_id,"tweet_dateTime",$dt,true);
   
          $index++;

    }

  }
?>
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

<div class="wrap">
	<?php if ( is_home() && ! is_front_page() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php single_post_title(); ?></h1>
		</header>
	<?php else : ?>
	<header class="page-header">
		<h2 class="page-title"><?php _e( 'Posts', 'twentyseventeen' ); ?></h2>
	</header>
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post();

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
