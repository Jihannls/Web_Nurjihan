<?php get_header(); ?>

<div id="skip-link-target" class="mt-5">

	<!-- Main Container -->
	<div class="container" id="skip-link-target">
		<div class="row">

		<?php
		function st_resume_excerpt_length($st_resume_length) {
		return 20;
		}
		add_filter('excerpt_length', 'st_resume_excerpt_length');
		?>
		
		<div class="col-md-8">
			<div class="row">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="col-md-6 mb-4">
					<div class="card h-100">
						<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php the_post_thumbnail('medium', ['class' => 'card-img-top img-fluid']); ?>
						</a>
					<div class="card-body">
						<h5 class="card-title">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
						</h5>
						<p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 50, '...'); ?></p>
					</div>
					<div class="card-footer">
						<small class="text-muted">
							<?php the_time( get_option( 'date_format' ) ); ?> / 
							<?php comments_popup_link( '0 Comments', '1 Comment', '% Comments', 'post-comments'); ?>
						</small>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-primary float-right st-read-more-btn">Read more</a>
					</div>
				</div>
			</div>
				<?php endwhile; else: ?>
				<div class="col-12">
					<div class="alert alert-warning">
						<h3>Nothing Found!</h3>
						<p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
						<div class="ashe-widget widget_search">
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>
			<?php endif; 
			
		// Pagination
		the_posts_pagination();?>
		</div>
	</div>

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

				<!-- Tags -->
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

			</div><!-- .sidebar-area -->
		</div>
	</div>
</div>
<?php get_footer(); ?>