<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package sapid
 */
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

if ( is_search() ) {
    $blog_archive_columns   = (int) sapid_get_theme_option( 'search-grid-columns' );
    $blog_meta = sapid_get_theme_option('search-meta');
    $blog_excerpt = sapid_get_theme_option('search-excerpt');
}else{
    $blog_archive_columns   = (int) sapid_get_theme_option( 'blog-archive-columns' );
    $blog_meta = sapid_get_theme_option('blog-result-meta');
    $blog_excerpt = sapid_get_theme_option('excerpt-display');
}

$blog_archive_columns = ( ! $blog_archive_columns ) ? 1 : $blog_archive_columns; // set  blog accoding to columns
$column_width  = ( 5 === $blog_archive_columns ) ? 2 : 12 / $blog_archive_columns; //set column width 
$wrapper_class   = 'blogs bg-white mt-0 pt-2 pb-2 sapid-blog-layout-grid-wrapper ';
$css_class =  'col-lg-' . $column_width . ' col-md-6 mb-5 sapid-blog-grid';
$row_class = 'row';
$image_size = 'full';
$justify_class   = 'justify-content-start text-start';
$pagination_justify_class   = 'justify-content-center text-center';

do_action( 'sapid_loop_before' ); ?>
<div class="<?php echo esc_attr( $wrapper_class.$justify_class ); ?>"> 
    <?php  if (is_category()){ ?>
        <!-- Blog Category Titlte and  Category Description -->
        <div class="row">
            <div class="col-md-12">  
                <h2 class="title"><?php  single_cat_title(); ?></h2>
                <p class="subtitle"><?php echo category_description(); ?></p>
            </div>
        </div>    
    <?php } ?>
     <div class="<?php echo $row_class ?>"> 
       <?php
         while ( have_posts() ) :
            the_post();
            $catHtml ='';
            $taxonomy = 'category';
            if ( get_post_type( get_the_ID() ) == 'product' ) {
                $taxonomy = 'product_cat';
            }
            $categories = get_the_terms( get_the_ID(), $taxonomy );
            foreach($categories as $category){
                $catHtml .='<a class="text-dblue-sub f-w" href="' . get_term_link($category) . '">' . $category->name . '</a>';
            }
        ?>
            <div class="<?php echo esc_attr($css_class)  ?>">  <!-- Grid  Layout -->
                <div class="card">
                    <picture> <?php sapid_post_thumbnail($image_size); ?> </picture>
                    <div class="card-body">
                        <?php if(!empty($blog_meta)){ ?>
                            <div class="d-flex justify-content-between mb-3"> <?php echo $catHtml; ?><span class="text-dblue"><?php echo get_the_date( 'F j, Y' ); ?></span> </div>
                        <?php } ?>     
                        <?php the_title(sprintf('<h2 class="entry-title  sapid-blog-title text-dblue f-w"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>');?>
                        <?php 
                        if(!empty($blog_excerpt)): ?>
                            <p class="text-dblue f-w"><?php the_excerpt(); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php
        endwhile; 
        ?>
    </div>
</div>

<?php echo sapid_pagination( '', sapid_get_theme_option( 'pagination-range' ),'', $pagination_justify_class );  ?>
<?php
do_action( 'sapid_loop_after' );
?>