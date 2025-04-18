<?php

namespace dashboard\models;
use auth\models\User;
use Yii;

/**
 * This is the model class for table "property".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $type
 * @property string|null $description
 * @property int|null $owner_id
 * @property int $status_id
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Users $owner
 * @property Status $status
 * @property Unit[] $units
 */
class Property extends \yii\db\ActiveRecord
{

    public $number_of_units;
    public $monthly_rent;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'owner_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['name', 'address', 'type', 'status_id'], 'required'],
            [['address', 'description'], 'string'],
            [['owner_id', 'status_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['name', 'type'], 'string', 'max' => 255],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'user_id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['number_of_units'], 'integer'],
            [['number_of_units'], 'default', 'value' => 1], // Default to 1 unit
            [['monthly_rent'], 'number'],
            // [['monthly_rent'], 'default', 'value' => 0], // Default to 0 rent

        ];  
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'type' => 'Type',
            'description' => 'Description',
            'owner_id' => 'Owner ',
            'status_id' => 'Status ',
            'number_of_units' => 'Number of Units',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['user_id' => 'owner_id']);
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
     * Gets query for [[Units]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(Unit::class, ['property_id' => 'id']);
    }

}
