jQuery(function($) {
    var pageNum = parseInt(nk_infinite_scroll.startPage) + 1;
    var max = parseInt(nk_infinite_scroll.maxPages);
    var nextLink = nk_infinite_scroll.nextLink;

    var busy = {};
    function loadMore(container, $loadMore, $posts_container, loadMoreText) {
        if(busy[container]) {
            return;
        }
        busy[container] = 1;

        // Show that we're working.
        $loadMore.text('Loading...');

        // load to invisible container, then append to posts container
        $('<div>').load(nextLink + ' ' + container , function() {
           // var $items = $($(this).html());
            var $items = $(this).find(container).children();
            //fix inverted conduct for odd length portfolio items
            var $pf_items = $items.filter('.nk-portfolio-item');
            if($pf_items.length %2 > 0) {
                $pf_items.toggleClass('inverted');
            }
            $posts_container.append($items);

            if($posts_container.hasClass('nk-isotope')) {
                $posts_container.isotope('appended', $items);

                // fix isotope layout after appended item
                setTimeout(function() {
                    $posts_container.isotope('layout');
                }, 100);
            }

            // initialization js for element format post
            if (typeof Khaki !== 'undefined') {
                Khaki.initPluginFlickity();
                Khaki.initVideoBlocks();
                Khaki.initAudioPlayer();
                Khaki.parallaxMouseInit();
                Khaki.debounceResize();
            }

            // Update page number and nextLink.
            pageNum++;
            nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/' + pageNum);

            // Update the button message.
            if(pageNum <= max) {
                $loadMore.text(loadMoreText || 'Load More');
            } else {
                $loadMore.text('No more posts to load');
            }

            busy[container] = 0;
        });
    }

    // load more button
    $('.nk-load-more-container ~ .nk-pagination').each(function() {
        var $pagination = $(this);
        var $posts_container = $pagination.parent().children('.nk-load-more-container');
        //$pagination.addClass('text-center').removeClass('dib');

        /**
         * Replace the traditional navigation with our own,
         * but only if there is at least one page of new posts to load.
         */
        // Insert the "Load More" link.
        var $loadMore = $pagination.html('<a href="javascript:void(0)" class="nk-btn nk-btn-sm nk-btn-circle nk-btn-color-dark-1">Load More ...</a>').find('a');

        if(pageNum > max) {
            $loadMore.text('No more posts to load');
            return;
        }

        /**
         * Load new posts when the link is clicked.
         */
        $loadMore.on('click', function() {

            // Are there more posts to load?
            if(pageNum <= max) {
                loadMore('.nk-load-more-container:eq(0)', $loadMore, $posts_container);
            }

            return false;
        });
    });

    // infinite scroll
    $('.nk-infinite-scroll-container ~ .nk-pagination').each(function() {
        var $pagination = $(this);
        var $posts_container = $pagination.parent().children('.nk-infinite-scroll-container');

        var $newPagination =  $pagination.html('<div class="pagination text-center"><a href="javascript:void(0)" class="nk-btn nk-btn-sm nk-btn-circle nk-btn-color-dark-1">Load More ...</a></div>').find('a');

        //$pagination.replaceWith($newPagination);

        if(pageNum > max) {
            $newPagination.text('No more posts to load');
            return;
        }

        /**
         * Load new posts when the link is clicked.
         */
        var scrollTimeout;
        $(window).on('scroll resize load', function() {
            clearTimeout(scrollTimeout);
            setTimeout(function() {
                // Are there more posts to load?
                if(pageNum <= max) {
                    var clientRect = $newPagination[0].getBoundingClientRect();
                    var wndH = $(window).innerHeight();
                    var visiblePart = wndH * 0.1;

                    if(clientRect.top > visiblePart && (clientRect.top < wndH - visiblePart)) {
                        loadMore('.nk-infinite-scroll-container:eq(0)', $newPagination, $posts_container, ' ');
                    }
                }
            }, 20);
        });
    });
});
