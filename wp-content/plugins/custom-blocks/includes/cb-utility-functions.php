<?php

/**
 * Includes a file from the cb plugin directory
 *
 * @param string $fileName The specified E.g. "includes/SomeClass.php"
 *
 * @return void
 */
function cbInclude($fileName)
{
    $path = CB_PLUGIN_PATH . $fileName;
    if (file_exists($path)) {
        include_once $path;
    }
}

/**
 * Adds custom block categories
 *
 * @param array $categories
 *
 * @return array of merged categories
 */
function cb_block_categories($categories)
{

    $extraCategories = [
        [
            'slug' => 'custom-blocks',
            'title' => __('Custom Blocks', 'custom-blocks'),
        ],
    ];


    if (file_exists(CB_PLUGIN_PATH . '/config.json')) {
         $cachedCategories = json_decode(
            file_get_contents(CB_PLUGIN_PATH . '/config.json'), true
        )["categories"];

         foreach ($cachedCategories as $category) {
             $extraCategories[] = [
                 'slug' => $category['slug'],
                 'title' => __($category['title'], $category['slug']),
             ];
         }
    }

    return array_merge($categories, $extraCategories);
}
add_filter('block_categories_all', 'cb_block_categories', 10, 2);

/**
 * Enable built-in Gutenberg styles
 *
 * @return void
 */
function cb_register_gb_styles()
{
    if (!is_admin()) {
        wp_enqueue_style('wp-block-library');
        wp_enqueue_style('wp-block-library-theme');
        wp_enqueue_style('wc-block-style');
    }
}

add_action('wp_enqueue_scripts', 'cb_register_gb_styles', 100);

// Save
function custom_blocks_update_field_group($group)
{
    $configs = (new \CustomBlocks\includes\BlockRepository())->getActive();

    if (isset($group["location"][0][0]["param"]) &&
        $group["location"][0][0]["param"] == "block") {

        $acfValueToCBValue =
            strtolower(str_replace(["acf/", "custom-block-", "-"], ["", "", ""], $group["location"][0][0]["value"]));

        foreach ($configs as $config) {
            $CBValue =
                strtolower(str_replace([" ", "-"], ["", ""], $config["category"] . $config["uuid"]));

            if ($acfValueToCBValue == $CBValue) {
                $folder = str_replace("block.php", "acf-json", $config["file"]);
                if (!file_exists($folder)) {
                    mkdir($folder, 0755, true);
                }

                add_filter('acf/settings/save_json', function () use ($folder) {
                    return $folder;
                });
            }
        }

    }
}

function cbdd($var) {
    echo "<pre>";
    var_dump($var);
    echo "<pre>";
    die();
}

add_action('acf/update_field_group', 'custom_blocks_update_field_group', 1, 1);

// Load - includes the /acf-json folder in this plugin to the places to look for ACF Local JSON files
add_filter('acf/settings/load_json', function($paths) {
    $configs = (new \CustomBlocks\includes\BlockRepository())->getActive();
    foreach ($configs as $config) {
        $paths[] = str_replace("block.php", "acf-json", $config["file"]);
    }

    return $paths;
});
