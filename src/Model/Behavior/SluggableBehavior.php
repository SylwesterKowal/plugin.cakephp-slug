<?php
/**
 * Created by PhpStorm.
 * User: Wlasciciel
 * Date: 2016-07-21
 * Time: 23:04
 */
namespace Slug\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Utility\Text;
use Cake\ORM\TableRegistry;

class SluggableBehavior extends Behavior
{
    protected $_defaultConfig = [
        'pass' => 'id',
        'field' => 'name',
        'slug' => 'slug',
        'replacement' => '-',
        'plugin' => '',
        'controller' => '',
        'action' => ''
    ];

    public function initialize(array $config)
    {
        $this->_defaultConfig = $config;
    }

    public function slug(Entity $entity)
    {
        $config = $this->config();
        $value = $entity->get($config['field']);
        $this->Slugs = TableRegistry::get('Slug.Slugs');


        $data['plugin'] = $config['plugin'];
        $data['controller'] = $config['controller'];
        $data['action'] = $config['action'];
        $data['pass'] = $entity->get($config['pass']);

        $redirect = $this->Slugs->find()
            ->where($data)
            ->first();

        $data['created'] = date('Y-m-d H:i:s');
        $data['slug'] = strtolower(Text::slug($value, $config['replacement']));
//        debug($redirect);
        if(!is_object($redirect)){
            $redirect = $this->Slugs->newEntity();
        }
        $redirect = $this->Slugs->patchEntity($redirect, $data);
        $this->Slugs->save($redirect);
    }

    public function afterSave(Event $event, EntityInterface $entity)
    {
//        debug($entity);
        $this->slug($entity);
    }

}