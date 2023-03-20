<?php
namespace CustomBlocks\includes;

class BlockRepository
{
    public $paths = [
        CB_PLUGIN_PATH . 'blocks/',
        CB_THEME_PATH . 'blocks/',
    ];

    protected $cachePath = CB_PLUGIN_PATH . '/config.json';

    protected $cache = [];
    protected $loadedCache = [];
    protected $resyncAttempts = 0;

    public function __construct()
    {
        cbInclude("includes/Block.php");
        $this->loadedCache = $this->getCache();
    }

    /**
     * Loops through global and local paths, prepares and writes the cache
     *
     * @return void
     */
    public function sync()
    {
        foreach ($this->paths as $path) {
            $this->syncPath($path);
        }

        $this->writeCache();
    }

    /**
     * Loops through directory and prepares blocks to be cached
     *
     * @param string $path a directory to load blocks from
     *
     * @param bool $category flag to say if this block is a sub-directory and
     * therefore should be categorised
     * @return void
     */
    public function syncPath($path, $category = false)
    {
        if (file_exists($path)) {
            foreach (scandir($path) as $fileInfo) {
                if (substr($fileInfo, 0, 1) != ".") {
                    $blockConfigPath = $path . $fileInfo . "/block.php";

                    if (file_exists($blockConfigPath)) {

                        $block = (new Block())->fromConfig($blockConfigPath);
                        if ($category) {
                            $slug = sanitize_title($category);

                            $this->cache["categories"][$category] = [
                                "slug" => $slug,
                                "title" => ucwords(str_replace("-", " " ,$category))
                            ];

                            $block->category = $slug;
                        }

                        if (filter_var($block->active, FILTER_VALIDATE_BOOLEAN)) {
                            $this->cache["active"][] = (array) $block;
                        } else {
                            $this->cache["inactive"][] = (array) $block;
                        }
                    } else {
                        $this->syncPath($path . $fileInfo . "/", $fileInfo);
                    }
                }
            }
        }
    }

    /**
     * Stores a json file of active and inactive configs
     *
     * @return void
     */
    public function writeCache()
    {
        $this->cache['timestamp'] = time();
        file_put_contents(
            $this->cachePath,
            json_encode($this->cache)
        );
    }

    /**
     * Registers all active blocks with ACF
     * If either paths have changed since last cache it will re-sync them
     *
     * @return void
     */
    public function registerActiveBlocks()
    {
        $this->loadedCache = $this->getCache();

        if ($this->shouldResync()) {
            $this->sync();
        }

        foreach($this->getActive() as $block) {
            (new Block())->fromCache($block)->register();
        }
    }

    public function shouldResync()
    {
        $this->resyncAttempts ++;
        if ($this->resyncAttempts > 1 || !isset($this->loadedCache["timestamp"])) {
            return false;
        }

        foreach ($this->paths as $path) {
            if (file_exists($path) && max(fileatime($path), filemtime($path)) > $this->loadedCache['timestamp']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all of the active block.php file locations
     *
     * @return array of file paths to active block configs
     */
    public function getActive()
    {
        $cache = $this->loadedCache;
        if (isset($cache['active'])) {
            return $cache['active'];
        }

        return [];
    }

    /**
     * return the entire config.json file as php array
     *
     * @return array of config
     */
    public function getCache()
    {
        if (file_exists($this->cachePath)) {
            return json_decode(
                file_get_contents($this->cachePath), true
            );
        }

        return [];
    }
}
