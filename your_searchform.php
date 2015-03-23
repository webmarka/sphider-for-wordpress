<!--To search through Sphider-->
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
<label class="hidden" for="query"><?php _e('Search site for:'); ?></label>
<div><input type="text" value="<?php the_search_query(); ?>" name="query" id="query" />
<input type="hidden" name="s" value="1" />
<input type="submit" id="searchsubmit" value="Search" />
</div>
</form>

<!--To search through WordPress-->
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
<label class="hidden" for="s"><?php _e('Search blog for:'); ?></label>
<div><input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
<input type="submit" id="searchsubmit" value="Search" />
</div>
</form>