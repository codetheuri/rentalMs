<?php

namespace dashboard\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property string $transaction_id
 * @property float $amount
 * @property int|null $is_deleted
 * @property string $created_at
 * @property string $updated_at
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaction_id', 'amount', 'created_at', 'updated_at'], 'required'],
            [['amount'], 'number'],
            [['is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['transaction_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'amount' => 'Amount',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
