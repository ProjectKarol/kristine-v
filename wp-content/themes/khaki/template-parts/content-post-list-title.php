<?php 
//template part for output post title
the_title(sprintf('<h2 class="nk-post-title h3"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');?>