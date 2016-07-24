<?php
namespace Slug\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Redirects Model
 *
 * @method \App\Model\Entity\Redirect get($primaryKey, $options = [])
 * @method \App\Model\Entity\Redirect newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Redirect[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Redirect|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Redirect patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Redirect[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Redirect findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SlugsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('slugs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('url');

        $validator
            ->allowEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->isUnique(['slug']));
        return $rules;
    }

    public function loadBySlug($slug){

        $redirect = $this->find()
            ->where(['Slugs.slug'=>$slug])
            ->select(['plugin','controller','action','pass'])
            ->first()
            ->toArray();
        $redirect['pass'] = [$redirect['pass']];
        return $redirect;

    }

}
