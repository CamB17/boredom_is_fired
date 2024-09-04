<?php get_template_part('global/header/header'); ?>
<? do_action('archive_template'); ?>
<?php if ( have_posts() ) : ?>
    <section class="blog-archive">
        <?php while ( have_posts() ) : the_post(); ?>
            <?
            if ( get_field('image') ) {
                $image_id = get_field('image')['id'] ?? null;
                $image = fly_get_attachment_image_src( $image_id, array( 600, 370 ), true )['src'];

            } else {
                $image_id = get_field('default_blog_post_image', 'options')['id'];
                $image = fly_get_attachment_image_src( $image_id, array( 600, 370 ), true )['src'];
            }
            ?>
            <div class="row blog-post" >

                <div class="small-12 medium-6 columns image"  onclick="document.location='<?= get_the_permalink(); ?>';">
                    <div class="image_holder" style="background-image:url('<?= $image; ?>');"></div>

                </div>

                <div class="small-12 medium-6 columns info align-middle" >
                    <div class="hold-me">
                        <a href="<? the_permalink(); ?>">
                            <h4><? the_title(); ?></h4>
                        </a>
                        <h6><?= get_the_date(); ?></h6>
                        <p>
                            <?= wp_trim_words($post->post_content, 40, '...') ?>
                        </p>
                        <a href="<? the_permalink(); ?>" class="button">Read More &raquo;</a>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>

        <div class="row pagination">
            <div class="small-12 columns">
                <? bif_archive_pagination(); ?>
            </div>
        </div>

    </section>

<?php endif; ?>

<?php get_template_part('global/footer/footer'); ?>
