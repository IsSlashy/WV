<?php
/*
Plugin Name:     WV Lazy Load
Description:     Remplace src/srcset/sizes par data-*, ajoute loading="lazy" et charge les images au scroll.
Version:         1.2.0
Author:          ramyfx
Text Domain:     wv-lazy-load
*/

namespace WV\LazyLoad;

// 1) On enfile notre script JS (polyfill + logique lazy-load)
\add_action('wp_enqueue_scripts', function() {
    \wp_enqueue_script(
        'wv-lazyload-polyfill',
        plugin_dir_url(__FILE__) . 'js/lazyload.js',
        [],
        '1.2.0',   // <-- incrémenter ce numéro à chaque mise à jour
        true
    );
});

// 2) On transforme les images générées par WP (wp_get_attachment_image)
\add_filter('wp_get_attachment_image_attributes', function(array $attr): array {
    // srcset → data-srcset
    if (!empty($attr['srcset'])) {
        $attr['data-srcset'] = $attr['srcset'];
        unset($attr['srcset']);
    }
    // sizes → data-sizes
    if (!empty($attr['sizes'])) {
        $attr['data-sizes'] = $attr['sizes'];
        unset($attr['sizes']);
    }
    // src → data-src + pixel transparent
    if (!empty($attr['src'])) {
        $attr['data-src'] = $attr['src'];
        $attr['src'] = 'data:image/gif;base64,R0lGODlhAQABAIAAAAUEBA==';
    }
    // Toujours lazy-loading
    $attr['loading'] = 'lazy';

    return $attr;
});

// 3) On transforme aussi toutes les balises <img> dans the_content
\add_filter('the_content', function(string $content): string {
    return \preg_replace_callback(
        // Match robuste de toute balise <img ...>
        '/<img\b([^>]+)>/i',
        function(array $m) {
            $attrs = $m[1];

            // Récupérer src, srcset, sizes
            preg_match('/\bsrc=(["\'])(.*?)\1/',    $attrs, $ms)    ? $src    = $ms[2]    : $src    = '';
            preg_match('/\bsrcset=(["\'])(.*?)\1/', $attrs, $mset)  ? $srcset = $mset[2]  : $srcset = '';
            preg_match('/\bsizes=(["\'])(.*?)\1/',  $attrs, $msz)   ? $sizes  = $msz[2]   : $sizes  = '';

            // Supprimer les attributs originaux
            $attrs = \preg_replace('/\s*(src|srcset|sizes)=(["\'])(.*?)\2/', '', $attrs);

            // Reconstruire la balise <img>
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
