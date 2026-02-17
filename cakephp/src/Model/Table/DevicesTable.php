<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Devices Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\DevicesTable&\Cake\ORM\Association\BelongsTo $Devices
 * @property \App\Model\Table\DevicesTable&\Cake\ORM\Association\HasOne $Devices
 * @property \App\Model\Table\ScanLogsTable&\Cake\ORM\Association\HasMany $ScanLogs
 *
 * @method \App\Model\Entity\Device newEmptyEntity()
 * @method \App\Model\Entity\Device newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Device[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Device get($primaryKey, $options = [])
 * @method \App\Model\Entity\Device findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Device patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Device[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Device|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Device saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DevicesTable extends Table
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

        $this->setTable('devices');
        $this->setDisplayField('device_id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Devices', [
            'foreignKey' => 'device_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('Devices', [
            'foreignKey' => 'device_id',
        ]);
        $this->hasMany('ScanLogs', [
            'foreignKey' => 'device_id',
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
            ->integer('company_id')
            ->notEmptyString('company_id');

        $validator
            ->scalar('device_id')
            ->maxLength('device_id', 50)
            ->notEmptyString('device_id')
            ->add('device_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('device_name')
            ->maxLength('device_name', 100)
            ->allowEmptyString('device_name');

        $validator
            ->scalar('location')
            ->maxLength('location', 100)
            ->allowEmptyString('location');

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
        $rules->add($rules->existsIn('device_id', 'Devices'), ['errorField' => 'device_id']);
        $rules->add($rules->existsIn('company_id', 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
