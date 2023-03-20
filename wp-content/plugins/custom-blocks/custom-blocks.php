<?php
/**
 * Plugin Name: Gutenberg Custom Blocks
 * Plugin URI: http://thirty8.co.uk
 * Description: Custom blocks to extend Gutenberg
 * Version: 0.16
 * Author: Mike Ellis / Marc Jenkins
 * GitHub Plugin URI: https://github.com/dmje/custom-blocks
 */
namespace CustomBlocks;
use CustomBlocks\includes\BlockRepository;
use CustomBlocks\includes\DependencyManager;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('CustomBlocks') === false) {
    class CustomBlocks
    {
        protected $blockRepository;

        public function __construct()
        {
            $this->initialize();
        }

        /**
         * Sets up the custom blocks plugin
         *
         * @return void
         */
        public function initialize()
        {
            cbInclude("includes/DependencyManager.php");
            cbInclude("includes/BlockRepository.php");
            cbInclude("includes/SyncButton.php");
            $this->blockRepository = new BlockRepository();
            register_activation_hook(__FILE__, [$this, 'activate']);
            add_action('acf/init', [$this->blockRepository, 'registerActiveBlocks']);
        }

        /**
         * Runs when the user activates the plugin.
         * Checks dependencies and does first sync.
         *
         * @return void
         */
        public function activate()
        {
            $dependencyManager = new DependencyManager();

            if (count($dependencyManager->missingDependencies)) {
                wp_die(
                    $dependencyManager->getMissingAsHtml(),
                    "There was an error activating plugin",
                    [
                       "back_link" => true,
                        "exit" => true,
                    ]
                );
            }

            $this->blockRepository->sync();
        }
    }

    define('CB_PLUGIN_PATH', plugin_dir_path(__FILE__));
    define('CB_THEME_PATH', get_stylesheet_directory() . '/');
    include_once CB_PLUGIN_PATH . 'includes/cb-utility-functions.php';
    new CustomBlocks();
}
