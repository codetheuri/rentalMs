<?php

namespace dashboard\models;

use Auth\Models\User;

use Yii;

/**
 * This is the model class for table "tenancy".
 *
 * @property int $id
 * @property int $unit_id
 * @property int|null $tenant_id
 * @property string $start_date
 * @property string|null $end_date
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Users $tenant
 * @property Unit $unit
 * 
 */

class Tenancy extends \yii\db\ActiveRecord
{
    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tenancy';
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tenant_id', 'end_date', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['unit_id', 'start_date'], 'required'],
            [['unit_id', 'tenant_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['payment_status'], 'integer'],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::class, 'targetAttribute' => ['unit_id' => 'id']],
            [['tenant_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['tenant_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'tenant_id' => 'Tenant ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'payment_status' => 'Payment Status',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
    public static function getPaymentStatusList()
    {
        return [
            self::STATUS_UNPAID => 'Unpaid',
            self::STATUS_PAID => 'Paid',
        ];
    }

    public function getPaymentStatusLabel()
    {
        return self::getPaymentStatusList()[$this->payment_status] ?? 'Unknown';
    }
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Only update if unit_id exists
        if ($this->unit_id) {
            $unit = $this->unit;
            if ($unit) {
                $unit->status_id = 2; // Or maybe a constant like Unit::STATUS_OCCUPIED
                $unit->save(false); // Avoid validation if not necessary
            }
        }
    }
    public function afterDelete()
    {
        parent::afterDelete();

        if ($this->unit_id) {
            $unit = $this->unit;
            if ($unit) {
                $unit->status_id = 8; // Or Unit::STATUS_VACANT
                $unit->save(false);
            }
        }
    }
}
