<?php
namespace Slug\Routing\Route;

use Cake\Routing\Route\Route;
use Cake\Utility\Inflector;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Controller\Controller;

/**
 * This route class will transparently inflect the controller, action and plugin
 * routing parameters, so that requesting `/my-plugin/my-controller/my-action`
 * is parsed as `['plugin' => 'MyPlugin', 'controller' => 'MyController', 'action' => 'myAction']`
 */
class SlugRoute extends Route
{

    protected function _camelizePlugin($plugin)
    {
        $plugin = str_replace('-', '_', $plugin);
        if (strpos($plugin, '/') === false) {
            return Inflector::camelize($plugin);
        }
        list($vendor, $plugin) = explode('/', $plugin, 2);
        return Inflector::camelize($vendor) . '/' . Inflector::camelize($plugin);
    }

    /**
     * Parses a string URL into an array. If it matches, it will convert the
     * controller and plugin keys to their CamelCased form and action key to
     * camelBacked form.
     *
     * @param string $url The URL to parse
     * @return array|false An array of request parameters, or false on failure.
     */
    public function parse($url)
    {

        $params = parent::parse($url);
        if (!$params) {
            return false;
        }
//        $tableSlugs = TableRegistry::get('Slug.Slugs');
//        $params = $tableSlugs->loadBySlug($params['slug']);

        $this->loadModel('Slugs');
        $params = $this->Slugs->loadBySlug($params['slug']);
        return $params;
    }

    /**
     * Dasherizes the controller, action and plugin params before passing them on
     * to the parent class.
     *
     * @param array $url Array of parameters to convert to a string.
     * @param array $context An array of the current request context.
     *   Contains information such as the current host, scheme, port, and base
     *   directory.
     * @return bool|string Either false or a string URL.
     */
    public function match(array $url, array $context = [])
    {
        $url = $this->_dasherize($url);
        if (!$this->_inflectedDefaults) {
            $this->_inflectedDefaults = true;
            $this->defaults = $this->_dasherize($this->defaults);
        }
        return parent::match($url, $context);
    }

    /**
     * Helper method for dasherizing keys in a URL array.
     *
     * @param array $url An array of URL keys.
     * @return array
     */
    protected function _dasherize($url)
    {
        foreach (['controller', 'plugin', 'action'] as $element) {
            if (!empty($url[$element])) {
                $url[$element] = Inflector::dasherize($url[$element]);
            }
        }
        return $url;
    }
}

