<?php


namespace WV\LazyLoad;
\add_action('wp_enqueue_scripts', function() {
    \wp_enqueue_script(
        'wv-lazyload-polyfill',
        plugin_dir_url(__FILE__) . 'js/lazyload.js',
        [],
        '1.2.0',
        true
    );
});

\add_filter('wp_get_attachment_image_attributes', function(array $attr): array {
    if (!empty($attr['srcset'])) {
        $attr['data-srcset'] = $attr['srcset'];
        unset($attr['srcset']);
    }
    if (!empty($attr['sizes'])) {
        $attr['data-sizes'] = $attr['sizes'];
        unset($attr['sizes']);
    }
    if (!empty($attr['src'])) {
        $attr['data-src'] = $attr['src'];
        $attr['src'] = 'data:image/gif;base64,R0lGODlhAQABAIAAAAUEBA==';
    }
    // Toujours lazy-loading
    $attr['loading'] = 'lazy';

    return $attr;
});

\add_filter('the_content', function(string $content): string {
    return \preg_replace_callback(
        '/<img\b([^>]+)>/i',
        function(array $m) {
            $attrs = $m[1];

            preg_match('/\bsrc=(["\'])(.*?)\1/',    $attrs, $ms)    ? $src    = $ms[2]    : $src    = '';
            preg_match('/\bsrcset=(["\'])(.*?)\1/', $attrs, $mset)  ? $srcset = $mset[2]  : $srcset = '';
            preg_match('/\bsizes=(["\'])(.*?)\1/',  $attrs, $msz)   ? $sizes  = $msz[2]   : $sizes  = '';

            $attrs = \preg_replace('/\s*(src|srcset|sizes)=(["\'])(.*?)\2/', '', $attrs);

            $tag  = '<img';
            $tag .= $attrs;
            if ($src)    { $tag .= " data-src=\"{$src}\" src=\"data:image/gif;base64,R0lGODlhAQABAIAAAAUEBA==\""; }
            if ($srcset) { $tag .= " data-srcset=\"{$srcset}\""; }
            if ($sizes)  { $tag .= " data-sizes=\"{$sizes}\""; }
            $tag .= ' loading="lazy"';
            $tag .= '>';

            return $tag;
        },
        $content
    );
}, 11);
