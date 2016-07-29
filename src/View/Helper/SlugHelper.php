<?php
/**
 * Created by PhpStorm.
 * User: Wlasciciel
 * Date: 2016-07-22
 * Time: 00:52
 */

namespace Slug\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\View\HelperRegistry;
use Cake\Event\Event;

class SlugHelper extends Helper
{
    public $helpers = ['Html'];

    protected $_defaultConfig = [
        'pass' => 'id',
        'slug' => 'slug',
        'plugin' => '',
        'controller' => '',
        'action' => ''
    ];

    public function initialize(array $config)
    {
        $this->_defaultConfig = $config;
    }

    public function link($entity, $anchor, $params = [], $options = [])
    {
        $config = $this->config();
        if (isset($entity->slug->slug) && !empty($entity->slug->slug)) {
            $slug = $entity->slug->slug;
            return $this->Html->link($anchor, $slug, $options);
        } else {
            return $this->Html->link($anchor, $params, $options);
        }
    }
}