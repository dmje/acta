<?php
namespace CustomBlocks\includes;

class Block
{
    public $uuid = "";
    public $file;
    public $title = ""; //Block Title
    public $description = "";
    public $keywords = "";
    public $acf = "";
    public $css = "";
    public $js = "";
    public $dependency = "";
    public $active = false;
    public $postTypes = "page,post";
    public $allowMultiple = true;
    public $category = "custom-blocks";

    /**
     * Builds a block from a attributes within config file
     *
     * @param string $file a path to the config file
     * @return $this
     */
    public function fromConfig($file)
    {
        $attributes = (array) $this;
        foreach ($attributes as $key => $attribute) {
            $attributes[$key] =
                implode(" ", preg_split('/(?=[A-Z])/', $key));
        }

        foreach (get_file_data($file, $attributes) as $key => $attribute) {
            $this->$key = $attribute;
        }

        $this->file = $file;

        return $this;
    }

    /**
     * Builds block from attributes stored in cache
     *
     * @param array $cache
     * @return $this
     */
    public function fromCache($cache)
    {
        foreach ($cache as $key => $attribute) {
            $this->$key = $attribute;
        }

        return $this;
    }

    /**
     * Registers Block object with ACF
     *
     * @return void
     */
    public function register()
    {
        acf_register_block_type(
            [
                'name'              => 'custom-block-' . $this->category . "-" . $this->uuid,
                'mode'              => 'preview',
                'title'             => __($this->title),
                'description'       => __($this->description),
                'render_template'   => $this->file,
                'category'          => $this->category,
                'enqueue_assets'    => [$this, 'enqueue'],
                'post_types'        => $this->getPostTypes(),
                'multiple'          => filter_var($this->allowMultiple, FILTER_VALIDATE_BOOLEAN),
                'icon'              => file_get_contents(
                    str_replace("block.php", "icon.svg", $this->file)
                ),
                'supports'          => [
                    'align'         => true,
                    'jsx'           => true,
                ],
                'keywords'          => explode(",", $this->keywords),
                'example'  => [
                    'attributes' => [
                        'mode' => 'preview',
                    ]
                ],
            ]
        );
    }

    /**
     * If the config has not been set for post types set it to page and post
     * so that it show for something
     *
     * @return array
     */
    public function getPostTypes()
    {
        if ($this->postTypes == "null" || empty($this->postTypes)) {
            return ['page', 'post'];
        }

        return explode(",", $this->postTypes);
    }

    /**
     * @return void
     */
    public function enqueue()
    {
        foreach (explode(",", $this->js) as $asset) {
            wp_enqueue_script($asset, strstr(str_replace("block.php", $asset, $this->file), "/wp-content"));
        }

        foreach (explode(",", $this->css) as $asset) {
            wp_enqueue_style("asset", strstr(str_replace("block.php", $asset, $this->file), "/wp-content"));
        }
    }
}
