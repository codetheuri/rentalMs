<?php

namespace dashboard\models;
use Auth\models\User;

use Yii;

/**
 * This is the model class for table "maintenance_request".
 *
 * @property int $id
 * @property int $unit_id
 * @property int|null $tenant_id
 * @property string $description
 * @property int $status_id
 * @property int|null $is_deleted
 * @property string|null $requested_at
 * @property string|null $resolved_at
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Status $status
 * @property Users $tenant
 * @property Unit $unit
 */
class MaintenanceRequest extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maintenance_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tenant_id', 'resolved_at', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['unit_id', 'description', 'status_id'], 'required'],
            [['unit_id', 'tenant_id', 'status_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['requested_at', 'resolved_at'], 'safe'],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::class, 'targetAttribute' => ['unit_id' => 'id']],
            [['tenant_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['tenant_id' => 'user_id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit',
            'tenant_id' => 'Tenant ',
            'description' => 'Description',
            'status_id' => 'Status',
            'is_deleted' => 'Is Deleted',
            'requested_at' => 'Requested At',
            'resolved_at' => 'Resolved At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[Tenant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTenant()
    {
        return $this->hasOne(User::class, ['user_id' => 'tenant_id']);
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::class, ['id' => 'unit_id']);
    }

}
