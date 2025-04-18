<?php

namespace dashboard\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property int $property_id
 * @property string $unit_number
 * @property float $monthly_rent
 * @property int $status_id
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property MaintenanceRequest[] $maintenanceRequests
 * @property Property $property
 * @property Status $status
 * @property Tenancy[] $tenancies
 */
class Unit extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['property_id', 'unit_number', 'monthly_rent', 'status_id'], 'required'],
            [['property_id', 'status_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['monthly_rent'], 'number'],
            [['unit_number'], 'string', 'max' => 255],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
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
            'property_id' => 'Property ID',
            'unit_number' => 'Unit Number',
            'monthly_rent' => 'Monthly Rent',
            'status_id' => 'Status ID',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[MaintenanceRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, ['unit_id' => 'id']);
    }

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
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
     * Gets query for [[Tenancies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTenancies()
    {
        return $this->hasMany(Tenancy::class, ['unit_id' => 'id']);
    }

}
