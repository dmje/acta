<?php
namespace CustomBlocks\includes;

class SyncButton
{
    public function __construct()
    {
        add_filter('plugin_action_links', [$this, 'syncLink'], 10, 2);
        add_action('admin_menu', [$this, 'addSyncPage']);
        add_action('admin_notices', [$this, 'syncComplete']);
    }

    /**
     * Registers a hidden page to execute sync code from
     *
     * @return void
     */
    public function addSyncPage()
    {
        add_submenu_page(
            null,
            'Sync Custom Blocks',
            'Sync Custome Blocks',
            'manage_options',
            'sync-custom-blocks',
            [$this, "syncCustomBlocks"]
        );
    }

    /**
     * Executes a sync and then redirects to plugin page
     *
     * @return void
     */
    public function syncCustomBlocks()
    {
        (new BlockRepository())->sync();
        $url = admin_url('plugins.php?msg=custom-block-sync-complete');
        ?><script><?php echo("location.href = '".$url."';");?></script><?php
    }

    /**
     * Adds a sync link on the plugins page
     *
     * @param array  $links of links
     * @param string $file  the file
     *
     * @return mixed
     */
    public function syncLink($links, $file)
    {
        if ($file === "custom-blocks/custom-blocks.php"
            && current_user_can('manage_options')
        ) {
            $settings
                = '
                <a href="'.
                admin_url('options-general.php?page=sync-custom-blocks') .
                '">' . esc_html__('Sync') . '</a>';

            array_unshift($links, $settings);
        }

        return $links;
    }

    /**
     * Displays a success message after sync button is complete
     *
     * @return void
     */
    function syncComplete()
    {
        if (isset($_GET['msg']) == 'custom-block-sync-complete') {
            ?>
            <div class="notice notice-success is-dismissible">
                <p>Gutenberg Custom Blocks have been synced</p>
            </div>
            <?php

        }
    }
}

new SyncButton();
