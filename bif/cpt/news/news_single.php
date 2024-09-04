<?php get_template_part( 'global/header/header' ); 

fm_subpage_header();

?>

<section class="news_single">
    <div class="row">
        <div class="small-12 columns">
            <? if ( have_posts() ) : 
                while ( have_posts() ) : the_post(); ?>

                    <? the_content(); ?>
    
                    <a href="/blog/" class="button back">
                        Back to Blog
                    </a>
                <? endwhile; 
            endif; ?>
        </div>
    </div>
</section>


<?php get_template_part( 'global/footer/footer' ); ?>
