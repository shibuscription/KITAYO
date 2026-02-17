<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ScanLogs Model
 *
 * @property \App\Model\Table\DevicesTable&\Cake\ORM\Association\BelongsTo $Devices
 *
 * @method \App\Model\Entity\ScanLog newEmptyEntity()
 * @method \App\Model\Entity\ScanLog newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ScanLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ScanLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\ScanLog findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ScanLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ScanLog[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ScanLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScanLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScanLog[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ScanLog[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ScanLog[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ScanLog[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ScanLogsTable extends Table
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

        $this->setTable('scan_logs');
        $this->setDisplayField('idm');
        $this->setPrimaryKey('id');

        $this->belongsTo('Devices', [
            'foreignKey' => 'device_id',
            'bindingKey' => 'device_id',
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
            ->scalar('idm')
            ->maxLength('idm', 50)
            ->requirePresence('idm', 'create')
            ->notEmptyString('idm');

        $validator
            ->scalar('device_id')
            ->maxLength('device_id', 50)
            ->notEmptyString('device_id');

        $validator
            ->dateTime('scanned_at')
            ->requirePresence('scanned_at', 'create')
            ->notEmptyDateTime('scanned_at');

        $validator
            ->boolean('processed')
            ->allowEmptyString('processed');

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
        $rules->add($rules->existsIn('device_id', 'Devices'), ['errorField' => 'device_id']);

        return $rules;
    }
}
