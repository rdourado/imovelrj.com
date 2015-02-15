				<li class="entry h-entry entry-item">
					<?php if (has_post_thumbnail()) : ?>
					<div class="post-image">
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('my-large') ?></a>
					</div>
					<?php endif; ?>
					<div class="entry-head cf">
						<div class="entry-id">
							<h1 class="entry-title p-name"><a href="<?php the_permalink() ?>" class="u-url"><?php the_title() ?></a></h1>
							<p class="entry-category p-category"><?php the_category(', ') ?></p>
						</div>
					</div>
				</li>
