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
        if (isset($entity->redirect->slug) && !empty($entity->redirect->slug)) {
            $slug = $entity->redirect->slug;
            return $this->Html->link(h($anchor), $slug, $options);
        } else {
            return $this->Html->link(h($anchor), $params, $options);
        }
    }
}