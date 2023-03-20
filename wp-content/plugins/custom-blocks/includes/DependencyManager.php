<?php
namespace CustomBlocks\includes;

class DependencyManager
{
    public $dependencies = [
        [
            "name" => "Advanced Custom Fields Pro",
            "class" => "acf_pro",
        ],
    ];

    public $missingDependencies = [];

    public function __construct()
    {
        $this->scanForMissingDependencies();
    }

    /**
     * Get array of plugins that are required to run the plugin
     * that are not currently active
     *
     * @return array
     */
    public function scanForMissingDependencies()
    {
        foreach ($this->dependencies as $dependency) {
            if (class_exists($dependency["class"]) === false) {
                $this->missingDependencies[] = $dependency;
            }
        }

        return $this->missingDependencies;
    }

    /**
     * Returns list of missing dependencies as html
     *
     * @return string
     */
    public function getMissingAsHtml()
    {
        $html = "<ul>";
        foreach ($this->missingDependencies as $missingDependency) {
            $html .= "<li>Please install the following plugin " .
                $missingDependency["name"] . "</li>";
        }

        return $html . "</ul>";
    }
}
