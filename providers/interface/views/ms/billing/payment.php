<?php
use helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="billing-form">
    <?php $form = ActiveForm::begin([
        'id' => 'payment-form',
        'options' => ['class' => 'form-horizontal'],
        'enableAjaxValidation' => false,
    ]); ?>

    <div class="form-group">
        <label>Phone Number</label>
        <input type="text" name="phone_number" class="form-control" placeholder="254712345678" required>
    </div>

    <div class="form-group">
        <label>Amount</label>
        <input type="number" name="amount" class="form-control" required>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Pay Now', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
document.getElementById('payment-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= Url::to(['/dashboard/billing/initiate-payment']) ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Please check your phone to complete the payment');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Please check your phone to complete the payment');
    });
});
</script>

