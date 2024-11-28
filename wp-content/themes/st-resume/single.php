<?php get_header(); ?>

<!-- Main Container -->
<div class="container-fluid container">
    <div class="row">
        <!-- Content Area -->
        <div class="col-lg-8 col-md-7 col-sm-12 content-area">
            <article id="post-<?php the_ID(); ?>" <?php post_class('st-resume-post'); ?>>

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>   

                <div class="post-media">
                    <?php the_post_thumbnail('full', ['class' => 'img-fluid']); ?>
                </div>

                <header class="post-header">

                    <h1 class="post-title"><?php the_title(); ?></h1>

                    <?php echo '<div class="post-categories">' . get_the_category_list( ',&nbsp;&nbsp;' ) . ' </div>'; ?>

                    <div class="post-meta">

                        <span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                        
                        <span class="meta-sep">/</span>
                        
                        <?php comments_popup_link( esc_html__( '0 Comments', 'st-resume' ), esc_html__( '1 Comment', 'st-resume' ), '% '. esc_html__( 'Comments', 'st-resume' ), 'post-comments'); ?>

                    </div>

                </header>

                <div class="post-content">
                    <?php
                    the_content('');
                    $st_resume_defaults = array(
                        'before' => '<p class="single-pagination">'. esc_html__( 'Pages:', 'st-resume' ),
                        'after' => '</p>'
                    );
                    wp_link_pages( $st_resume_defaults );
                    ?>
                </div>

                <footer class="post-footer">
                    <?php 
                    $st_resume_tag_list = get_the_tag_list( '<div class="post-tags">','','</div>');
                    if ( $st_resume_tag_list ) {
                        echo ''. $st_resume_tag_list;
                    }
                    ?>
                    <span class="post-author"><?php esc_html_e( 'By', 'st-resume' ); ?>&nbsp;<?php the_author_posts_link(); ?></span>
                </footer>

            </article>

            <?php
            endwhile;
            endif;

            if ( comments_open() || get_comments_number() ) {
                echo '<div class="comments-area" id="comments">';
                    comments_template( '', true );
                echo '</div>';
            }
            ?>
        </div><!-- .content-area -->

        <!-- Sidebar Area -->
        <div class="col-lg-4 col-md-5 col-sm-12 sidebar-area">
            <!-- Post Categories with Count -->
            <div class="widget widget-categories">
                <h2 class="widget-title"><?php esc_html_e( 'Categories', 'st-resume' ); ?></h2>
                <ul class="list-group">
                    <?php 
                    $st_resume_categories = get_categories( array(
                        'orderby' => 'name',
                        'order'   => 'ASC'
                    ) );

                    foreach( $st_resume_categories as $st_resume_category ) {
                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                        echo '<a href="' . esc_url( get_category_link( $st_resume_category->term_id ) ) . '">' . esc_html( $st_resume_category->name ) . '</a>';
                        echo '<span class="badge badge-primary badge-pill st-cat-badge">' . esc_html( $st_resume_category->count ) . '</span>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Recent Posts with Thumbnails -->
            <hr>
            <div class="widget widget-recent-posts">
                <h2 class="widget-title"><?php esc_html_e( 'Recent Posts', 'st-resume' ); ?></h2>
                <ul class="list-unstyled">
                    <?php
                    $st_resume_recent_posts = wp_get_recent_posts( array(
                        'numberposts' => 5,
                        'post_status' => 'publish'
                    ) );
                    foreach( $st_resume_recent_posts as $st_resume_post_item ) : ?>
                        <li class="media mb-3">
                            <a href="<?php echo get_permalink($st_resume_post_item['ID']) ?>">
                                <?php echo get_the_post_thumbnail( $st_resume_post_item['ID'], 'thumbnail', ['class' => 'mr-3 img-thumbnail'] ); ?>
                            </a>
                            <div class="media-body">
                                <h5 class="mt-0 mb-1">
                                    <a href="<?php echo get_permalink($st_resume_post_item['ID']) ?>">
                                        <?php echo esc_html( $st_resume_post_item['post_title'] ); ?>
                                    </a>
                                </h5>
                            </div>
                        </li>
                    <?php endforeach; wp_reset_query(); ?>
                </ul>
            </div>

            <hr>
            <div class="widget widget-tags">
                <h2 class="widget-title"><?php esc_html_e( 'Tags', 'st-resume' ); ?></h2>
                <div class="tagcloud">
                    <ul class="list-inline">
                    <?php
                        $st_resume_tags = get_tags();
                        foreach ( $st_resume_tags as $st_resume_tag ) {
                            echo '<li class="list-inline-item"><a href="' . get_tag_link($st_resume_tag->term_id) . '" class="btn btn-outline-primary btn-sm st-tags-btn">' . $st_resume_tag->name . '</a></li>';
                        }
                    ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>
