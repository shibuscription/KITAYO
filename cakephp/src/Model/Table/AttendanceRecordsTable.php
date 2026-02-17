<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AttendanceRecords Model
 *
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\AttendanceRecord newEmptyEntity()
 * @method \App\Model\Entity\AttendanceRecord newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AttendanceRecord[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AttendanceRecord get($primaryKey, $options = [])
 * @method \App\Model\Entity\AttendanceRecord findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AttendanceRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AttendanceRecord[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AttendanceRecord|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AttendanceRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AttendanceRecord[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AttendanceRecord[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AttendanceRecord[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AttendanceRecord[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AttendanceRecordsTable extends Table
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

        $this->setTable('attendance_records');
        $this->setDisplayField('id');
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
            ->date('work_date')
            ->requirePresence('work_date', 'create')
            ->notEmptyDate('work_date');

        $validator
            ->dateTime('check_in')
            ->allowEmptyDateTime('check_in');

        $validator
            ->dateTime('check_out')
            ->allowEmptyDateTime('check_out');

        $validator
            ->dateTime('break_start')
            ->allowEmptyDateTime('break_start');

        $validator
            ->dateTime('break_end')
            ->allowEmptyDateTime('break_end');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->scalar('note')
            ->allowEmptyString('note');

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
        $rules->add($rules->existsIn('employee_id', 'Employees'), ['errorField' => 'employee_id']);

        return $rules;
    }
}
