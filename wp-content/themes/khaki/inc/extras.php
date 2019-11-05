<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package khaki
 */

/**
 * Sanitizes a html classname to ensure it only contains valid characters.
 * */
if (!function_exists('khaki_sanitize_class')) :
    function khaki_sanitize_class($classes)
    {
        if (!is_array($classes)) {
            $classes = explode(' ', $classes);
        }

        foreach ($classes as $k => $v) {
            $classes[$k] = sanitize_html_class($v);
        }

        return join(' ', $classes);

        return $classes;
    }
endif;

if (!function_exists('khaki_pvc_hook')) :
    function khaki_pvc_hook($arg)
    {
        if (get_post_type() == 'post') {
            $arg = "";
        }

        return $arg;
    }
endif;
add_filter('pvc_shortcode_filter_hook', 'khaki_pvc_hook');
/**
 * Get timezones list
 * from: http://hilios.github.io/jQuery.countdown/examples/timezone-aware.html
 */
if (!function_exists('khaki_get_tz_list')) {
    function khaki_get_tz_list($opts_format = false)
    {
        $tz = array(
            'auto', 'Africa/Abidjan', 'Africa/Accra', 'Africa/Addis_Ababa', 'Africa/Algiers', 'Africa/Asmara', 'Africa/Asmera', 'Africa/Bamako', 'Africa/Bangui', 'Africa/Banjul', 'Africa/Bissau', 'Africa/Blantyre', 'Africa/Brazzaville', 'Africa/Bujumbura', 'Africa/Cairo', 'Africa/Casablanca', 'Africa/Ceuta', 'Africa/Conakry', 'Africa/Dakar', 'Africa/Dar_es_Salaam', 'Africa/Djibouti', 'Africa/Douala', 'Africa/El_Aaiun', 'Africa/Freetown', 'Africa/Gaborone', 'Africa/Harare', 'Africa/Johannesburg', 'Africa/Juba', 'Africa/Kampala', 'Africa/Khartoum', 'Africa/Kigali', 'Africa/Kinshasa', 'Africa/Lagos', 'Africa/Libreville', 'Africa/Lome', 'Africa/Luanda', 'Africa/Lubumbashi', 'Africa/Lusaka', 'Africa/Malabo', 'Africa/Maputo', 'Africa/Maseru', 'Africa/Mbabane', 'Africa/Mogadishu', 'Africa/Monrovia', 'Africa/Nairobi', 'Africa/Ndjamena', 'Africa/Niamey', 'Africa/Nouakchott', 'Africa/Ouagadougou', 'Africa/Porto-Novo', 'Africa/Sao_Tome', 'Africa/Timbuktu', 'Africa/Tripoli', 'Africa/Tunis', 'Africa/Windhoek', 'America/Adak', 'America/Anchorage', 'America/Anguilla', 'America/Antigua', 'America/Araguaina', 'America/Argentina/Buenos_Aires', 'America/Argentina/Catamarca', 'America/Argentina/ComodRivadavia', 'America/Argentina/Cordoba', 'America/Argentina/Jujuy', 'America/Argentina/La_Rioja', 'America/Argentina/Mendoza', 'America/Argentina/Rio_Gallegos', 'America/Argentina/Salta', 'America/Argentina/San_Juan', 'America/Argentina/San_Luis', 'America/Argentina/Tucuman', 'America/Argentina/Ushuaia', 'America/Aruba', 'America/Asuncion', 'America/Atikokan', 'America/Atka', 'America/Bahia', 'America/Bahia_Banderas', 'America/Barbados', 'America/Belem', 'America/Belize', 'America/Blanc-Sablon', 'America/Boa_Vista', 'America/Bogota', 'America/Boise', 'America/Buenos_Aires', 'America/Cambridge_Bay', 'America/Campo_Grande', 'America/Cancun', 'America/Caracas', 'America/Catamarca', 'America/Cayenne', 'America/Cayman', 'America/Chicago', 'America/Chihuahua', 'America/Coral_Harbour', 'America/Cordoba', 'America/Costa_Rica', 'America/Creston', 'America/Cuiaba', 'America/Curacao', 'America/Danmarkshavn', 'America/Dawson', 'America/Dawson_Creek', 'America/Denver', 'America/Detroit', 'America/Dominica', 'America/Edmonton', 'America/Eirunepe', 'America/El_Salvador', 'America/Ensenada', 'America/Fort_Wayne', 'America/Fortaleza', 'America/Glace_Bay', 'America/Godthab', 'America/Goose_Bay', 'America/Grand_Turk', 'America/Grenada', 'America/Guadeloupe', 'America/Guatemala', 'America/Guayaquil', 'America/Guyana', 'America/Halifax', 'America/Havana', 'America/Hermosillo', 'America/Indiana/Indianapolis', 'America/Indiana/Knox', 'America/Indiana/Marengo', 'America/Indiana/Petersburg', 'America/Indiana/Tell_City', 'America/Indiana/Vevay', 'America/Indiana/Vincennes', 'America/Indiana/Winamac', 'America/Indianapolis', 'America/Inuvik', 'America/Iqaluit', 'America/Jamaica', 'America/Jujuy', 'America/Juneau', 'America/Kentucky/Louisville', 'America/Kentucky/Monticello', 'America/Knox_IN', 'America/Kralendijk', 'America/La_Paz', 'America/Lima', 'America/Los_Angeles', 'America/Louisville', 'America/Lower_Princes', 'America/Maceio', 'America/Managua', 'America/Manaus', 'America/Marigot', 'America/Martinique', 'America/Matamoros', 'America/Mazatlan', 'America/Mendoza', 'America/Menominee', 'America/Merida', 'America/Metlakatla', 'America/Mexico_City', 'America/Miquelon', 'America/Moncton', 'America/Monterrey', 'America/Montevideo', 'America/Montreal', 'America/Montserrat', 'America/Nassau', 'America/New_York', 'America/Nipigon', 'America/Nome', 'America/Noronha', 'America/North_Dakota/Beulah', 'America/North_Dakota/Center', 'America/North_Dakota/New_Salem', 'America/Ojinaga', 'America/Panama', 'America/Pangnirtung', 'America/Paramaribo', 'America/Phoenix', 'America/Port-au-Prince', 'America/Port_of_Spain', 'America/Porto_Acre', 'America/Porto_Velho', 'America/Puerto_Rico', 'America/Rainy_River', 'America/Rankin_Inlet', 'America/Recife', 'America/Regina', 'America/Resolute', 'America/Rio_Branco', 'America/Rosario', 'America/Santa_Isabel', 'America/Santarem', 'America/Santiago', 'America/Santo_Domingo', 'America/Sao_Paulo', 'America/Scoresbysund', 'America/Shiprock', 'America/Sitka', 'America/St_Barthelemy', 'America/St_Johns', 'America/St_Kitts', 'America/St_Lucia', 'America/St_Thomas', 'America/St_Vincent', 'America/Swift_Current', 'America/Tegucigalpa', 'America/Thule', 'America/Thunder_Bay', 'America/Tijuana', 'America/Toronto', 'America/Tortola', 'America/Vancouver', 'America/Virgin', 'America/Whitehorse', 'America/Winnipeg', 'America/Yakutat', 'America/Yellowknife', 'Antarctica/Casey', 'Antarctica/Davis', 'Antarctica/DumontDUrville', 'Antarctica/Macquarie', 'Antarctica/Mawson', 'Antarctica/McMurdo', 'Antarctica/Palmer', 'Antarctica/Rothera', 'Antarctica/South_Pole', 'Antarctica/Syowa', 'Antarctica/Troll', 'Antarctica/Vostok', 'Arctic/Longyearbyen', 'Asia/Aden', 'Asia/Almaty', 'Asia/Amman', 'Asia/Anadyr', 'Asia/Aqtau', 'Asia/Aqtobe', 'Asia/Ashgabat', 'Asia/Ashkhabad', 'Asia/Baghdad', 'Asia/Bahrain', 'Asia/Baku', 'Asia/Bangkok', 'Asia/Beirut', 'Asia/Bishkek', 'Asia/Brunei', 'Asia/Calcutta', 'Asia/Chita', 'Asia/Choibalsan', 'Asia/Chongqing', 'Asia/Chungking', 'Asia/Colombo', 'Asia/Dacca', 'Asia/Damascus', 'Asia/Dhaka', 'Asia/Dili', 'Asia/Dubai', 'Asia/Dushanbe', 'Asia/Gaza', 'Asia/Harbin', 'Asia/Hebron', 'Asia/Ho_Chi_Minh', 'Asia/Hong_Kong', 'Asia/Hovd', 'Asia/Irkutsk', 'Asia/Istanbul', 'Asia/Jakarta', 'Asia/Jayapura', 'Asia/Jerusalem', 'Asia/Kabul', 'Asia/Kamchatka', 'Asia/Karachi', 'Asia/Kashgar', 'Asia/Kathmandu', 'Asia/Katmandu', 'Asia/Khandyga', 'Asia/Kolkata', 'Asia/Krasnoyarsk', 'Asia/Kuala_Lumpur', 'Asia/Kuching', 'Asia/Kuwait', 'Asia/Macao', 'Asia/Macau', 'Asia/Magadan', 'Asia/Makassar', 'Asia/Manila', 'Asia/Muscat', 'Asia/Nicosia', 'Asia/Novokuznetsk', 'Asia/Novosibirsk', 'Asia/Omsk', 'Asia/Oral', 'Asia/Phnom_Penh', 'Asia/Pontianak', 'Asia/Pyongyang', 'Asia/Qatar', 'Asia/Qyzylorda', 'Asia/Rangoon', 'Asia/Riyadh', 'Asia/Saigon', 'Asia/Sakhalin', 'Asia/Samarkand', 'Asia/Seoul', 'Asia/Shanghai', 'Asia/Singapore', 'Asia/Srednekolymsk', 'Asia/Taipei', 'Asia/Tashkent', 'Asia/Tbilisi', 'Asia/Tehran', 'Asia/Tel_Aviv', 'Asia/Thimbu', 'Asia/Thimphu', 'Asia/Tokyo', 'Asia/Ujung_Pandang', 'Asia/Ulaanbaatar', 'Asia/Ulan_Bator', 'Asia/Urumqi', 'Asia/Ust-Nera', 'Asia/Vientiane', 'Asia/Vladivostok', 'Asia/Yakutsk', 'Asia/Yekaterinburg', 'Asia/Yerevan', 'Atlantic/Azores', 'Atlantic/Bermuda', 'Atlantic/Canary', 'Atlantic/Cape_Verde', 'Atlantic/Faeroe', 'Atlantic/Faroe', 'Atlantic/Jan_Mayen', 'Atlantic/Madeira', 'Atlantic/Reykjavik', 'Atlantic/South_Georgia', 'Atlantic/St_Helena', 'Atlantic/Stanley', 'Australia/ACT', 'Australia/Adelaide', 'Australia/Brisbane', 'Australia/Broken_Hill', 'Australia/Canberra', 'Australia/Currie', 'Australia/Darwin', 'Australia/Eucla', 'Australia/Hobart', 'Australia/LHI', 'Australia/Lindeman', 'Australia/Lord_Howe', 'Australia/Melbourne', 'Australia/NSW', 'Australia/North', 'Australia/Perth', 'Australia/Queensland', 'Australia/South', 'Australia/Sydney', 'Australia/Tasmania', 'Australia/Victoria', 'Australia/West', 'Australia/Yancowinna', 'Brazil/Acre', 'Brazil/DeNoronha', 'Brazil/East', 'Brazil/West', 'CET', 'CST6CDT', 'Canada/Atlantic', 'Canada/Central', 'Canada/East-Saskatchewan', 'Canada/Eastern', 'Canada/Mountain', 'Canada/Newfoundland', 'Canada/Pacific', 'Canada/Saskatchewan', 'Canada/Yukon', 'Chile/Continental', 'Chile/EasterIsland', 'Cuba', 'EET', 'EST', 'EST5EDT', 'Egypt', 'Eire', 'Etc/GMT', 'Etc/GMT+0', 'Etc/GMT+1', 'Etc/GMT+10', 'Etc/GMT+11', 'Etc/GMT+12', 'Etc/GMT+2', 'Etc/GMT+3', 'Etc/GMT+4', 'Etc/GMT+5', 'Etc/GMT+6', 'Etc/GMT+7', 'Etc/GMT+8', 'Etc/GMT+9', 'Etc/GMT-0', 'Etc/GMT-1', 'Etc/GMT-10', 'Etc/GMT-11', 'Etc/GMT-12', 'Etc/GMT-13', 'Etc/GMT-14', 'Etc/GMT-2', 'Etc/GMT-3', 'Etc/GMT-4', 'Etc/GMT-5', 'Etc/GMT-6', 'Etc/GMT-7', 'Etc/GMT-8', 'Etc/GMT-9', 'Etc/GMT0', 'Etc/Greenwich', 'Etc/UCT', 'Etc/UTC', 'Etc/Universal', 'Etc/Zulu', 'Europe/Amsterdam', 'Europe/Andorra', 'Europe/Athens', 'Europe/Belfast', 'Europe/Belgrade', 'Europe/Berlin', 'Europe/Bratislava', 'Europe/Brussels', 'Europe/Bucharest', 'Europe/Budapest', 'Europe/Busingen', 'Europe/Chisinau', 'Europe/Copenhagen', 'Europe/Dublin', 'Europe/Gibraltar', 'Europe/Guernsey', 'Europe/Helsinki', 'Europe/Isle_of_Man', 'Europe/Istanbul', 'Europe/Jersey', 'Europe/Kaliningrad', 'Europe/Kiev', 'Europe/Lisbon', 'Europe/Ljubljana', 'Europe/London', 'Europe/Luxembourg', 'Europe/Madrid', 'Europe/Malta', 'Europe/Mariehamn', 'Europe/Minsk', 'Europe/Monaco', 'Europe/Moscow', 'Europe/Nicosia', 'Europe/Oslo', 'Europe/Paris', 'Europe/Podgorica', 'Europe/Prague', 'Europe/Riga', 'Europe/Rome', 'Europe/Samara', 'Europe/San_Marino', 'Europe/Sarajevo', 'Europe/Simferopol', 'Europe/Skopje', 'Europe/Sofia', 'Europe/Stockholm', 'Europe/Tallinn', 'Europe/Tirane', 'Europe/Tiraspol', 'Europe/Uzhgorod', 'Europe/Vaduz', 'Europe/Vatican', 'Europe/Vienna', 'Europe/Vilnius', 'Europe/Volgograd', 'Europe/Warsaw', 'Europe/Zagreb', 'Europe/Zaporozhye', 'Europe/Zurich', 'GB', 'GB-Eire', 'GMT', 'GMT+0', 'GMT-0', 'GMT0', 'Greenwich', 'HST', 'Hongkong', 'Iceland', 'Indian/Antananarivo', 'Indian/Chagos', 'Indian/Christmas', 'Indian/Cocos', 'Indian/Comoro', 'Indian/Kerguelen', 'Indian/Mahe', 'Indian/Maldives', 'Indian/Mauritius', 'Indian/Mayotte', 'Indian/Reunion', 'Iran', 'Israel', 'Jamaica', 'Japan', 'Kwajalein', 'Libya', 'MET', 'MST', 'MST7MDT', 'Mexico/BajaNorte', 'Mexico/BajaSur', 'Mexico/General', 'NZ', 'NZ-CHAT', 'Navajo', 'PRC', 'PST8PDT', 'Pacific/Apia', 'Pacific/Auckland', 'Pacific/Bougainville', 'Pacific/Chatham', 'Pacific/Chuuk', 'Pacific/Easter', 'Pacific/Efate', 'Pacific/Enderbury', 'Pacific/Fakaofo', 'Pacific/Fiji', 'Pacific/Funafuti', 'Pacific/Galapagos', 'Pacific/Gambier', 'Pacific/Guadalcanal', 'Pacific/Guam', 'Pacific/Honolulu', 'Pacific/Johnston', 'Pacific/Kiritimati', 'Pacific/Kosrae', 'Pacific/Kwajalein', 'Pacific/Majuro', 'Pacific/Marquesas', 'Pacific/Midway', 'Pacific/Nauru', 'Pacific/Niue', 'Pacific/Norfolk', 'Pacific/Noumea', 'Pacific/Pago_Pago', 'Pacific/Palau', 'Pacific/Pitcairn', 'Pacific/Pohnpei', 'Pacific/Ponape', 'Pacific/Port_Moresby', 'Pacific/Rarotonga', 'Pacific/Saipan', 'Pacific/Samoa', 'Pacific/Tahiti', 'Pacific/Tarawa', 'Pacific/Tongatapu', 'Pacific/Truk', 'Pacific/Wake', 'Pacific/Wallis', 'Pacific/Yap', 'Poland', 'Portugal', 'ROC', 'ROK', 'Singapore', 'Turkey', 'UCT', 'US/Alaska', 'US/Aleutian', 'US/Arizona', 'US/Central', 'US/East-Indiana', 'US/Eastern', 'US/Hawaii', 'US/Indiana-Starke', 'US/Michigan', 'US/Mountain', 'US/Pacific', 'US/Pacific-New', 'US/Samoa', 'UTC', 'Universal', 'W-SU', 'WET', 'Zulu'
        );
        $tz2 = array();
        foreach ($tz as $z) {
            $tz2[] = array(
                'value' => $z,
                'label' => $z
            );
        }
        return $opts_format ? $tz2 : $tz;
    }
}
/**
 * Universal generate Breadcrumbs
 * */
if (!function_exists('khaki_breadcrumbs')) {
    function khaki_breadcrumbs($home_title = false)
    {
        /* === OPTIONS === */
        $text['home'] = $home_title; // text for the 'Home' link
        $text['category'] = esc_html__('Archive by Category "%s"', 'khaki'); // text for a category page
        $text['tax'] = esc_html__('Archive for "%s"', 'khaki'); // text for a taxonomy page
        $text['search'] = esc_html__('Search Results for "%s" Query', 'khaki'); // text for a search results page
        $text['tag'] = esc_html__('Posts Tagged "%s"', 'khaki'); // text for a tag page
        $text['author'] = esc_html__('Articles Posted by %s', 'khaki'); // text for an author page
        $text['404'] = esc_html__('Error 404', 'khaki'); // text for the 404 page
        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
        $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
        $delimiter = ''; // delimiter between crumbs
        $before = '<li><span>'; // tag before the current crumb
        $after = '</span></li>'; // tag after the current crumb
        /* === END OF OPTIONS === */
        global $post;
        $post_type = get_post_type();//product
        $result='';
        $homeLink = esc_url( home_url('/') );
        $linkBefore = '<li>';
        $linkAfter = '</li>';
        $linkAttr = ' rel="v:url" property="v:title"';
        $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
        if (is_home() || is_front_page()) {
            if ($showOnHome == 1 and $text['home']) $result .= '<ul><li><a href="' . $homeLink . '">' . $text['home'] . '</a></li></ul>';
        } else {
            $result .= '<ul>';
            if (function_exists('is_bbpress') && is_bbpress()) { //supported bbpres breadcrumbs
                $result .= bbp_get_breadcrumb(array('home_text' => $text['home']));
            } elseif($post_type == 'product' && function_exists('woocommerce_breadcrumb')){
                // is Woocommerce
                $args =wp_parse_args(array(
                    'delimiter' => $delimiter,
                    'before' => $before,
                    'wrap_before' => '',
                    'wrap_after'  => '',
                    'after'       => $after,
                    'home'        => $text['home']
                ));
                $breadcrumbs = new WC_Breadcrumb();
                if ( ! empty( $args['home'] ) ) {
                    $breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
                }
                $args['breadcrumb'] = $breadcrumbs->generate();
                if (!empty($args['breadcrumb'])) {
                    $result .= $args['wrap_before'];
                    foreach ($args['breadcrumb'] as $key => $crumb) {
                        $result .=  $before;

                        if (!empty($crumb[1]) && sizeof($args['breadcrumb']) !== $key + 1) {
                            $result .=  '<a href="' . esc_url($crumb[1]) . '">' . esc_html($crumb[0]) . '</a>';
                        } else {
                            $result .=  esc_html($crumb[0]);
                        }

                        $result .=  $after;

                        if (sizeof($args['breadcrumb']) !== $key + 1) {
                            $result .=  $delimiter;
                        }
                    }
                    $result .= $args['wrap_after'];
                }

            } else {
                if ($text['home']) {
                    $result .= sprintf($link, $homeLink, $text['home']) . $delimiter;
                }

                if (is_category()) {
                    $thisCat = get_category(get_query_var('cat'), false);
                    if ($thisCat->parent != 0) {
                        $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                        $result .= $cats;
                    }
                    $result .= $before . sprintf($text['category'], single_cat_title('', false)) . $after;
                } elseif (is_tax()) {
                    $thisCat = get_category(get_query_var('cat'), false);
                    if ($thisCat->parent != 0) {
                        $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                        $result .= $cats;
                    }
                    $result .= $before . sprintf($text['tax'], single_cat_title('', false)) . $after;

                } elseif (is_search()) {
                    $result .= $before . sprintf($text['search'], get_search_query()) . $after;
                } elseif (is_day()) {
                    $result .= sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                    $result .= sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
                    $result .= $before . get_the_time('d') . $after;
                } elseif (is_month()) {
                    $result .= sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                    $result .= $before . get_the_time('F') . $after;
                } elseif (is_year()) {
                    $result .= $before . get_the_time('Y') . $after;
                } elseif (is_single() && !is_attachment()) {
                    if (get_post_type() != 'post') {
                        $post_type = get_post_type_object(get_post_type());
                        $slug = $post_type->rewrite;
                        $result .= sprintf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                        if ($showCurrent == 1) $result .= $delimiter . $before . get_the_title() . $after;
                    } else {
                        $cat = get_the_category();
                        $cat = $cat[0];
                        $cats = get_category_parents($cat, TRUE, $delimiter);
                        if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                        $result .= $cats;
                        if ($showCurrent == 1) $result .= $before . get_the_title() . $after;
                    }
                } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                    $post_type = get_post_type_object(get_post_type());
                    if(is_object($post_type)){
                        $result .= $before . $post_type->labels->singular_name . $after;
                    }
                } elseif (is_attachment()) {
                    $parent = get_post($post->post_parent);
                    $cat = get_the_category($parent->ID);
                    $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    $result .= $cats;
                    $result .= sprintf($link, get_permalink($parent), $parent->post_title);
                    if ($showCurrent == 1) $result .= $delimiter . $before . get_the_title() . $after;
                } elseif (is_page() && !$post->post_parent) {
                    if ($showCurrent == 1) $result .= $before . get_the_title() . $after;
                } elseif (is_page() && $post->post_parent) {
                    $parent_id = $post->post_parent;
                    $breadcrumbs = array();
                    while ($parent_id) {
                        $page = get_page($parent_id);
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                        $parent_id = $page->post_parent;
                    }
                    $breadcrumbs = array_reverse($breadcrumbs);
                    for ($i = 0; $i < count($breadcrumbs); $i++) {
                        $result .= $breadcrumbs[$i];
                        if ($i != count($breadcrumbs) - 1) $result .= $delimiter;
                    }
                    if ($showCurrent == 1) $result .= $delimiter . $before . get_the_title() . $after;
                } elseif (is_tag()) {
                    $result .= $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
                } elseif (is_author()) {
                    global $author;
                    $userdata = get_userdata($author);
                    $result .= $before . sprintf($text['author'], $userdata->display_name) . $after;
                } elseif (is_archive()) {
                    $result .= $before . the_archive_title() . $after;
                } elseif (is_404()) {
                    $result .= $before . $text['404'] . $after;
                }
                if (get_query_var('paged')) {
                    if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) $result .= ' (';
                    $result .= esc_html__('Page', 'khaki') . ' ' . get_query_var('paged');
                    if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) $result .= ')';
                }
            }
            $result .= '</ul>';
        }
return $result;
    }
}
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if (!function_exists('khaki_posted_on')) :
    function khaki_posted_on($get = false, $showDate = true)
    {

        $time_string = get_the_time(esc_html__('F j, Y ', 'khaki'));

        if ($get) {
            return ($showDate ? wp_kses_post( $time_string ) : '');
        } else {
            echo($showDate ? wp_kses_post( $time_string ) : '');
        }
    }
endif;
/**
 * Prints HTML with image and post url
 */
if (!function_exists('khaki_post_thumbnail')) :
    function khaki_post_thumbnail($get = false, $additional_info = '')
    {
        $template =
            '<a href="%s" class="nk-image-box-1 nk-post-image">
				%s
			' . $additional_info . '
		</a>';
        $thumbnail = '';
        if (has_post_thumbnail()) {
            $thumbnail = '<img src="' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'khaki_500x375')) . '" alt="' . esc_attr(get_the_title(get_the_ID())) . '">';
        }

        if ($get) {
            $result = '';
            if($thumbnail != ''){
                $result = sprintf($template, esc_url(get_permalink()), $thumbnail);
            }
            return $result;
        } else {
            if($thumbnail != '') {
                printf($template, esc_url(get_permalink()), $thumbnail);
            }
        }
    }
endif;

/**
 * Get Attachment Attribute for Images
 */
if (!function_exists('khaki_get_attachment')) :
    function khaki_get_attachment($attachment_id, $attachment_size = 'full') {
        // is url
        if (filter_var($attachment_id, FILTER_VALIDATE_URL)) {
            $path_to_image = $attachment_id;
            $attachment_id = attachment_url_to_postid($attachment_id);
            if (is_numeric($attachment_id) && $attachment_id == 0) {
                return array(
                    'alt' => null,
                    'caption' => null,
                    'description' => null,
                    'href' => null,
                    'src' => $path_to_image,
                    'title' => null,
                    'width' => null,
                    'height' => null,
                );
            }
        }

        // is numeric
        if (is_numeric($attachment_id) && $attachment_id !== 0) {
            $attachment = get_post($attachment_id);
            $attachment_src = array();
            if(is_object($attachment)) {
                if (isset($attachment_size)) {
                    $attachment_src = wp_get_attachment_image_src($attachment_id, $attachment_size);
                }
                return array(
                    'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
                    'caption' => $attachment->post_excerpt,
                    'description' => $attachment->post_content,
                    'href' => get_permalink($attachment->ID),
                    'src' => isset($attachment_src[0]) ? $attachment_src[0] : $attachment->guid,
                    'title' => $attachment->post_title,
                    'width' => isset($attachment_src[1]) ? $attachment_src[1] : false,
                    'height' => isset($attachment_src[2]) ? $attachment_src[2] : false,
                );
            }
        }
        return false;
    }
endif;


if (!function_exists('khaki_get_image')) :
    /**
     * Get <img> tag by ID or URL
     *
     * @param int|string $attachment_id - attaachment ID or URL to image.
     * @param string     $size - attachment size.
     * @param bool       $icon - icon.
     * @param array      $attr - attributes array.
     *
     * @return null|string
     */
    function khaki_get_image( $attachment_id, $size = 'thumbnail', $icon = false, $attr = array() ) {
        $image_id = $attachment_id;

        if ( filter_var( filter_var( $attachment_id, FILTER_SANITIZE_URL ), FILTER_VALIDATE_URL ) ) {
            // @codingStandardsIgnoreLine
            $image_id = attachment_url_to_postid( $attachment_id );

            if ( is_numeric( $image_id ) && 0 === $image_id ) {
                $alt = '';
                $return = '<img src="' . esc_url( $attachment_id ) . '"';
                if ( isset( $attr ) && ! empty( $attr ) && is_array( $attr ) ) {
                    foreach ( $attr as $key => $attribute ) {
                        $return .= ' ' . esc_attr( $key ) . '="' . esc_attr( $attribute ) . '"';
                    }
                }
                $return .= ' alt="' . esc_attr( $alt ) . '" />';
                return $return;
            }
        }

        if ( is_numeric( $image_id ) && 0 !== $image_id ) {
            return wp_get_attachment_image( $image_id, $size, $icon, $attr );
        }

        return null;
    }
endif;

/**
 * Get Social List
 */
if (!function_exists('khaki_get_social_list')) :
    function khaki_get_social_list($size_list = 'full')
    {
        if ($size_list == 'full') {
            return array(
                'fab fa-twitch' => esc_html__('Twitch', 'khaki'),
                'fab fa-vimeo' => esc_html__('Vimeo', 'khaki'),
                'fab fa-youtube' => esc_html__('Youtube', 'khaki'),
                'fab fa-facebook' => esc_html__('Facebook', 'khaki'),
                'fab fa-google-plus' => esc_html__('Google-plus', 'khaki'),
                'fab fa-twitter' => esc_html__('Twitter', 'khaki'),
                'fab fa-pinterest' => esc_html__('Pinterest', 'khaki'),
                'fab fa-instagram' => esc_html__('Instagram', 'khaki'),
                'fab fa-linkedin' => esc_html__('Linkedin', 'khaki'),
                'fab fa-behance' => esc_html__('Behance', 'khaki'),
                'fab fa-odnoklassniki' => esc_html__('Odnoklassniki', 'khaki'),
                'fab fa-skype' => esc_html__('Skype', 'khaki'),
                'fab fa-vk' => esc_html__('VK', 'khaki'),
                'fab fa-steam' => esc_html__('Steam', 'khaki'),
                'fab fa-bitbucket' => esc_html__('Bitbucket', 'khaki'),
                'fab fa-dropbox' => esc_html__('Dropbox', 'khaki'),
                'fab fa-dribbble' => esc_html__('Dribbble', 'khaki'),
                'fab fa-deviantart' => esc_html__('Deviantart', 'khaki'),
                'fab fa-flickr' => esc_html__('Flickr', 'khaki'),
                'fab fa-foursquare' => esc_html__('Foursquare', 'khaki'),
                'fab fa-github' => esc_html__('Github', 'khaki'),
                'fab fa-medium' => esc_html__('Medium', 'khaki'),
                'fab fa-paypal' => esc_html__('PayPal', 'khaki'),
                'fab fa-reddit' => esc_html__('Reddit', 'khaki'),
                'fab fa-soundcloud' => esc_html__('SoundCloud', 'khaki'),
                'fab fa-slack' => esc_html__('Slack', 'khaki'),
                'fab fa-tumblr' => esc_html__('Tumblr', 'khaki'),
                'fab fa-wordpress' => esc_html__('WordPress', 'khaki')
            );
        } elseif ($size_list == 'small') {
            return array(
                'fab fa-facebook' => esc_html__('Facebook', 'khaki'),
                'fab fa-google-plus' => esc_html__('Google Plus', 'khaki'),
                'fab fa-twitter' => esc_html__('Twitter', 'khaki'),
                'fab fa-pinterest' => esc_html__('Pinterest', 'khaki'),
                'fab fa-linkedin' => esc_html__('Linkedin', 'khaki'),
                'fab fa-vk' => esc_html__('VK', 'khaki')
            );
        } else {
            return null;
        }
    }
endif;

/**
 * Get all terms for post shortcodes
 */
if (!function_exists('khaki_get_terms')) :
    function khaki_get_terms()
    {
        $terms_list_vc = array();
        $terms_list = get_terms(get_object_taxonomies(get_post_types(array(
            'public' => false,
            'name' => 'attachment',
        ), 'names', 'NOT')));
        foreach ($terms_list as $term) {
            $terms_list_vc[] = array(
                "value" => $term->term_id,
                "label" => $term->name,
                "group" => $term->taxonomy
            );
        }

        return $terms_list_vc;
    }
endif;

/**
 * Responsive video embed
 */
add_filter('embed_oembed_html', 'khaki_oembed_filter', 10, 4);
if (!function_exists('khaki_oembed_filter')) :
    function khaki_oembed_filter($html, $url, $attr, $post_ID)
    {
        $classes = '';
        if (strpos($url, 'youtube') > 0 || strpos($url, 'youtu.be') > 0) {
            $classes .= ' responsive-embed responsive-embed-16x9 embed-youtube';
        } else if (strpos($url, 'vimeo') > 0) {
            $classes .= ' responsive-embed responsive-embed-16x9 embed-vimeo';
        } else if (strpos($url, 'twitter') > 0) {
            $classes .= ' embed-twitter';
        }

        $return = '<div class="' . khaki_sanitize_class($classes) . '">' . $html . '</div>';
        return $return;
    }
endif;
/**
 * Redefined HTML form get_the_password_form
 */
if (!function_exists('khaki_get_the_password_form')):
    function khaki_get_the_password_form($post = 0)
    {
        $post = get_post($post);
        $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
        $output = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form nk-form" method="post">
        ' . esc_html__('This content is password protected. To view it please enter your password below', 'khaki') . '
        <div class="nk-gap-1"></div>
        <input name="post_password" id="' . $label . '" type="password" size="20" placeholder="' . esc_html__('Enter you password', 'khaki') . '" class="form-control"/>
        <input type="hidden" name="Submit" value="' . esc_attr_x('Enter', 'post password form', 'khaki') . '" />
        <div class="nk-gap"></div>
        <button class="nk-btn nk-btn-lg">' . esc_html__('Enter', 'khaki') . '</button>
        </form>
        ';
        return apply_filters('the_password_form', $output);
    }
endif;

if (!function_exists( 'khaki_password_form' )):
    function khaki_password_form() {
        global $post;
        $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
        $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="nk-form nk-form-style-1 validate"><div class="input-group"><input name="post_password" id="' . $label . '" type="password" class="form-control required" placeholder = "'.esc_html__('Password', 'khaki').'"/><button class="nk-btn nk-btn-color-dark-1 password-submit">'.esc_html__( "Submit", 'khaki' ).'</button></div><small>' . esc_html__( "To view this protected post, enter the password below", 'khaki' ) . '</small> </form>
        ';
        return $o;
    }
endif;
add_filter( 'the_password_form', 'khaki_password_form' );

// define the previous_comments_link_attributes callback
if (!function_exists('khaki_filter_previous_comments_link_attributes')):
    function khaki_filter_previous_comments_link_attributes( $var ) {
        $var='class="nk-pagination-prev"';
        return $var;
    }
endif;

if (!function_exists('khaki_filter_next_comments_link_attributes')):
    function khaki_filter_next_comments_link_attributes( $var ) {
        $var='class="nk-pagination-next"';
        return $var;
    }
endif;
// add the filter
add_filter( 'previous_comments_link_attributes', 'khaki_filter_previous_comments_link_attributes', 10, 1 );
add_filter( 'next_comments_link_attributes', 'khaki_filter_next_comments_link_attributes', 10, 1 );

if (!function_exists('khaki_get_main_navigation_logo')):
    function khaki_get_main_navigation_logo(){
        $attachment = khaki_get_attachment(khaki_get_theme_mod('main_navigation_logo'));
        $alt = $attachment['alt'] ? esc_attr($attachment['alt']) : get_bloginfo('name');
        $result = '<a href="'.esc_url(home_url('/')).'" class="nk-nav-logo">';
        $result .= '<img src="'.esc_url(khaki_get_theme_mod('main_navigation_logo')).'" alt="'.$alt.'" width="'.esc_attr(khaki_get_theme_mod('main_navigation_logo_width')).'">';
        $result .='</a>';
        return $result;
    }
endif;
//delete [...] before output and trim to need char length
if (!function_exists('khaki_excerpt_max_charlength')):
    function khaki_excerpt_max_charlength($limit = 15, $return_mode = false) {
        $content = wp_trim_words(do_shortcode(get_the_content()), $limit, '...');
        if ($return_mode){
            return $content;
        }
        else{
            echo $content;
        }
    }
endif;

if (!function_exists('khaki_ar_not_empty')):
function khaki_ar_not_empty($var){
    if(!empty($var)){
        return true;
    }
}
endif;

if (!function_exists('khaki_remove_wpautop')):
    function khaki_remove_wpautop($content, $autop = false) {
        if ($autop) {
            $content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
        }
        return do_shortcode(shortcode_unautop($content));
    }
endif;

/* get_intermediate_image_sizes() without keys */
if (!function_exists( 'khaki_get_image_sizes' )) :
    function khaki_get_image_sizes() {
        $sizes = get_intermediate_image_sizes();
        $result = array('full' => 'full');
        foreach($sizes as $k => $name) {
            $result[$name] = $name;
        }
        return $result;
    }
endif;
if (!function_exists( 'khaki_login_with_ajax_from_navigation_panel_icon' )) :
    function khaki_login_with_ajax_from_navigation_panel_icon($panel = 'main_panel'){

        if(khaki_get_theme_mod('khaki_login_with_ajax_show_icon') && function_exists('login_with_ajax')){
        $user_login = is_user_logged_in();
        $menu_item_class = 'nk-drop-item';
        $menu_item_class .= $panel == 'main_panel' ? ' single-icon' : '';
        $icon_logged_class = $user_login ? 'ion-md-person' : 'ion-md-log-in';
        ?>
        <li class="<?php echo khaki_sanitize_class($menu_item_class);?>">
            <?php
            $profile_url = khaki_get_theme_mod('khaki_login_with_ajax_profile_url');
            if ( function_exists('bp_get_loggedin_user_link') ){
                $profile_url = bp_get_loggedin_user_link();
                }
                ?>
            <a href="<?php echo esc_url($profile_url);?>" class="no-link-effect">
                <span class="<?php echo khaki_sanitize_class($icon_logged_class);?>"></span>
            </a>
            <div class="dropdown">
                <div class="nk-sign-form">
                    <?php login_with_ajax();?>
                </div>
            </div>
        </li>
        <?php
        }
    }
endif;

// Add specific Boxed CSS class by filter.
add_filter( 'body_class', 'khaki_body_class' );

if ( ! function_exists( 'khaki_body_class' ) ) {
    function khaki_body_class( $classes ) {
        $boxed = khaki_get_theme_mod('page_boxed', true) ? 'nk-page-boxed' : '';
        return array_merge( $classes, array( $boxed ) );
    }
}

// Small cart for navigation panel
if ( ! function_exists( 'khaki_small_cart' ) ) {
    function khaki_small_cart()
    {
        ?>
        <?php if (class_exists('WooCommerce') && khaki_get_theme_mod('woocommerce_cart_show')): ?>
        <?php if (!is_cart()): ?>
            <?php
            $cart_count = WC()->cart->get_cart_contents_count();
            $cart_is_not_empty = false;
            if (WC()->cart->get_cart()) {
                $cart_is_not_empty = true;
            }
            ?>
            <li class="single-icon nk-drop-item">
                <a href="#" class="no-link-effect">
                    <span class="ion-md-cart"></span>
                </a>
                <span class="nk-badge<?php echo khaki_sanitize_class($cart_count > 0 ? ' fade show' : ' fade out'); ?>"
                      id="khaki_small_cart_count"><?php echo esc_html($cart_count); ?></span>
                <div class="dropdown">
                    <div class="nk-widget">
                        <div class="nk-widget-store-cart" id="khaki_small_cart">
                            <div>
                                <div class="khaki_hide_small_cart"
                                     data-cart-count="<?php echo esc_attr(WC()->cart->get_cart_contents_count()); ?>">
                                    <?php if ($cart_is_not_empty): ?>
                                        <h4 class="text-center"><?php echo esc_html__('Cart', 'khaki'); ?></h4>

                                        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item): ?>
                                            <?php
                                            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)):?>
                                                <div class="nk-widget-post">
                                                    <?php
                                                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('khaki_800x600'), $cart_item, $cart_item_key);

                                                    if (!$product_permalink) {
                                                        echo $thumbnail;
                                                    } else {
                                                        printf('<a href="%s" class="nk-image-box-1 nk-post-image">%s</a>', esc_url($product_permalink), $thumbnail);
                                                    }
                                                    ?>
                                                    <h3 class="nk-post-title">
                                                        <?php
                                                        echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                                            '<a href="%s" class="no-fade trash-small-cart float-right" title="%s" data-product_id="%s" data-product_sku="%s"><span class="ion-ios-trash"></span></a>',
                                                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                            esc_html__('Remove this item', 'khaki'),
                                                            esc_attr($product_id),
                                                            esc_attr($_product->get_sku())
                                                        ), $cart_item_key);
                                                        ?>
                                                        <?php
                                                        if (!$product_permalink) {
                                                            echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;';
                                                        } else {
                                                            echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key);
                                                        }
                                                        ?>
                                                    </h3>
                                                    <div class="nk-product-price">
                                                        <?php
                                                        if ($_product->is_sold_individually()) {
                                                            $product_quantity = '1';
                                                        } else {
                                                            $product_quantity = $cart_item['quantity'];
                                                        }

                                                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                                        ?> &times; <?php
                                                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <div class="nk-widget-store-cart-total">
                                            <a href="<?php echo wp_nonce_url(wc_get_cart_url(), 'empty_cart'); ?>&clear-cart=true"><span
                                                        class="ion-ios-trash"></span> <?php esc_html_e('Empty Cart', 'khaki'); ?>
                                            </a>
                                            <span><?php wc_cart_totals_subtotal_html(); ?></span>
                                        </div>

                                    <?php endif; ?>
                                    <?php if ($cart_is_not_empty == false): ?>
                                        <span class="text-center"><?php esc_html_e('Your cart is empty!', 'khaki'); ?></span>
                                    <?php endif; ?>
                                    <?php if ($cart_is_not_empty): ?>
                                        <div class="nk-widget-store-cart-actions">
                                            <div class="btn-group">
                                                <a class="nk-btn nk-btn-rounded nk-btn-color-white text-dark-1" href="<?php echo esc_url(wc_get_cart_url()); ?>">
                                                    <span class="icon"><span class="ion-md-cart"></span></span> <?php esc_html_e('View Cart', 'khaki'); ?>
                                                </a>
                                                <a class="nk-btn nk-btn-rounded nk-btn-color-white text-dark-1" href="<?php echo esc_url(wc_get_checkout_url()); ?>">
                                                    <?php esc_html_e('Checkout', 'khaki'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        <?php endif; ?>
    <?php endif; ?>
        <?php
    }
}

if ( ! function_exists( 'khaki_allowed_html' ) ) :
    function khaki_allowed_html() {
        $allowed_html = array(
            'a' => array(
                'href' => true,
                'title' => true,
                'rel' => true,
                'property' => true,
                'target' => true,
                'data-toggle' => true,
                'class' => true,
                'style' => true,
                'aria-label' => true,
                'data-size' => true,
            ),
            'br' => array(),
            'p' => array(
                'id' => true,
                'class' => true,
            ),
            'label' => array(
                'for' => true,
            ),
            'input' => array(
                'class' => true,
                'type' => true,
                'value' => true,
                'name' => true,
                'checked' => true,
            ),
            'h2' => array(
                'class' => true,
            ),
            'em' => array(),
            'strong' => array(),
            'li' => array(
                'id' => true,
                'class' => true,
                'data-filter' => true,
            ),
            'ul' => array(
                'id' => true,
                'class' => true,
            ),
            'span' => array(
                'id' => true,
                'class' => true,
                'data-sociality-like' => true,
                'data-post-id' => true,
                'data-post-type' => true,
                'data-post-likes-count' => true,
                'data-post-liked' => true,
            ),
            'div' => array(
                'id' => true,
                'class' => true,
                'data-arrows' => true,
                'data-size' => true,
                'tabindex' => true,
                'style' => true,
                'aria-selected' => true,
                'data-autoplay' => true,
                'data-dots' => true,
                'data-src' => true,
                'data-duration' => true,
                'data-video' => true,
                'data-video-thumb' => true,
                'data-filter' => true,
            ),
            'nav' => array(),
            'img' => array(
                'width' => true,
                'height' => true,
                'src' => true,
                'class' => true,
                'alt' => true,
                'srcset' => true,
                'sizes' => true,
                'style' => true,
            ),
            'blockquote' => array(
                'class' => true,
            ),
            'style' => true,
            'i' => array(
                'class' => true,
            ),
            'time' => array(
                'class' => true,
                'datetime' => true,
            ),
        );
        return apply_filters( 'khaki_filter_allowed_html', $allowed_html );
    }
endif;

/**
 * Get an HTML img element representing an image path or id
 */
if ( ! function_exists( 'khaki_get_image' ) ) :
    function khaki_get_image( $image_id_or_path = null, $size = 'thumbnail', $icon = false, $attr = '' ) {
        $image_id = $image_id_or_path;
        if ( khaki_check_url($image_id_or_path) ) {
            $image_id = attachment_url_to_postid( $image_id_or_path );
        }
        if ( $image_id ) {
            return wp_get_attachment_image( $image_id, $size, $icon, $attr );
        }
        if ( khaki_check_url($image_id_or_path) ) {
            $return = '<img src="' . esc_url( $image_id_or_path ) . '"';
            if ( isset( $attr ) && ! empty( $attr ) && is_array( $attr ) ) {
                foreach ( $attr as $key => $attribute ) {
                    if ( 'class' === $key ) {
                        $return .= ' class="' . esc_attr( $attribute ) . '"';
                    }
                }
            }
            $return .= ' />';
            return $return;
        }
        return null;
    }
endif;

// Validate url. Using filter_var() will fail for urls with non-ascii chars. The following function encode all non-ascii chars before calling filter_var().
if ( ! function_exists('khaki_check_url' ) ) :
    function khaki_check_url( $url ) {
        $path = parse_url($url, PHP_URL_PATH);
        $encoded_path = array_map('urlencode', explode('/', $path));
        $url = str_replace($path, implode('/', $encoded_path), $url);

        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }
endif;
