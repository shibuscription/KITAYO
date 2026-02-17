<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeIdm Model
 *
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\EmployeeIdm newEmptyEntity()
 * @method \App\Model\Entity\EmployeeIdm newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeIdm[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeIdm get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeIdm findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EmployeeIdm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeIdm[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeIdm|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeIdm saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeIdm[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmployeeIdm[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmployeeIdm[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmployeeIdm[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeeIdmTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('employee_idm');
        $this->setDisplayField('idm');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('employee_id')
            ->notEmptyString('employee_id');

        $validator
            ->scalar('idm')
            ->maxLength('idm', 32)
            ->requirePresence('idm', 'create')
            ->notEmptyString('idm')
            ->add('idm', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->boolean('active_flag')
            ->allowEmptyString('active_flag');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['idm']), ['errorField' => 'idm']);
        $rules->add($rules->existsIn('employee_id', 'Employees'), ['errorField' => 'employee_id']);

        return $rules;
    }
}
