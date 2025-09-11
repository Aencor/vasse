<?php

/**
 * @param $categories
 * @param $post
 * @return array
 */
function monk_block_category($categories, $post): array
{
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'monk-category',
                'title' => __('Monk Blocks', 'kikemonk')
            )
        )
    );
}
add_filter('block_categories', 'monk_block_category', 10, 2);


/**
 * Data list files
 *
 * @return array
 */
function monk_data_list_files(): array
{
    $files = array(
        'hero',
        'presentacion-home',
        'presentacion-bts',
        'contacto',
        'texto',
        'galeria'
    );

    $data_list = array();

    foreach ($files as $i => $file) {
        $file_path = get_template_directory() . '/blocks/' . $file . '.php';
        
        // Skip if file doesn't exist
        if (!file_exists($file_path)) {
            continue;
        }
        
        $data = get_file_data($file_path, array(
            'title'         => 'Block Name',
            'slug'          => 'Slug',
            'description'   => 'Description',
            'keywords'      => 'Keywords',
            'align'         => 'Align'
        ));

        if (!empty($data['title'])) {
            $data_list[] = array(
                'name'          => $file,
                'title'         => $data['title'],
                'description'   => $data['description'],
                'keywords'      => $data['keywords'],
                'align'         => $data['align'],
                'file_uri'      => '/blocks/' . $file . '.php'
            );
        }
    }

    return $data_list;
}

/**
 * Register ACF block types
 */
function monk_register_acf_block_types()
{
    // Check if ACF is active
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    foreach (monk_data_list_files() as $block_data) {
        // Skip if required fields are missing
        if (empty($block_data['name']) || empty($block_data['title'])) {
            continue;
        }

        $block_args = array(
            'name'              => $block_data['name'],
            'title'             => __($block_data['title'], 'kikemonk'),
            'description'       => !empty($block_data['description']) ? __($block_data['description'], 'kikemonk') : '',
            'category'          => 'monk-category',
            'icon'              => '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 90 90"><rect x="-0.2" y="0.2" fill="#DA0F26" width="90" height="90"/><path fill="#FFFFFF" d="M68.6,57.8c0,10.7-6.6,19.6-21.1,19.6H22.6V38.8h22.1c9.4,0,12.7-4.8,12.7-10.6c0-5.8-2.6-10.6-12-10.6l-22.8,0.1v-7h23.2c13.3,0,19,7.8,19,17.4c0,5.4-2.6,10.2-7,13.1C64.7,44.5,68.6,50.5,68.6,57.8z M61.2,57.8c0-6.9-4.4-12.8-14.3-12.8H29.6v25.4l17.7,0.1C56.7,70.6,61.2,64.7,61.2,57.8z"/></svg>',
            'keywords'          => !empty($block_data['keywords']) ? array_map('trim', explode(',', $block_data['keywords'])) : array(),
            'render_template'   => get_template_directory() . $block_data['file_uri'],
            'enqueue_style'     => get_template_directory_uri() . '/assets/css/blocks/' . $block_data['name'] . '.css',
            'enqueue_script'    => get_template_directory_uri() . '/assets/js/blocks/' . $block_data['name'] . '.js',
            'supports'          => array(
                'align'     => !empty($block_data['align']),
                'mode'      => true,
                'anchor'    => true,
                'multiple'  => true,
                'jsx'       => true,
                'color'     => [
                    'background' => true,
                    'gradients'  => true,
                    'text'       => true,
                ],
            ),
            'example' => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'is_preview' => true
                    )
                )
            )
        );

        // Register the block
        acf_register_block_type($block_args);
    }
}
add_action('acf/init', 'monk_register_acf_block_types');

// Clear block cache if needed
function monk_clear_block_cache() {
    if (isset($_GET['clear_block_cache'])) {
        delete_transient('monk_block_data');
        wp_redirect(remove_query_arg('clear_block_cache'));
        exit;
    }
}
add_action('admin_init', 'monk_clear_block_cache');

// Add a link to clear block cache in admin bar
function monk_add_clear_cache_link($admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $admin_bar->add_menu(array(
        'id'    => 'clear-block-cache',
        'title' => 'Clear Block Cache',
        'href'  => add_query_arg('clear_block_cache', '1'),
        'meta'  => array(
            'title' => 'Clear Block Cache',
        ),
    ));
}
add_action('admin_bar_menu', 'monk_add_clear_cache_link', 100);
