    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
                <div class="entry-wrap">
                    <div class="entry">
                        <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                        <span class="date"><?php the_time('l, F j, Y'); echo " at "; the_time('g:ia') ?></span>
                        <?php the_content('Read more &raquo;'); ?>
                        <p class="postmetadata clear">Filed under: <?php the_category(', ') ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

    <?php else : ?>
        <h2 class="center">Not Found</h2>
        <p class="center">Sorry, but you are looking for something that isn't here.</p>
        <?php get_search_form(); ?>
    <?php endif; ?>

