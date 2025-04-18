<?php
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $content */

$this->registerCss("
  body {
    font-family: 'Arial', sans-serif;
    background: #fff;
    color: #000;
    padding: 40px;
  }

  h1, h2, h3, h4, h5 {
    margin-top: 0;
  }

  @media print {
    body {
      margin: 0;
      padding: 0;
    }

    .no-print {
      display: none !important;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid #000;
      padding: 8px;
    }
  }
");
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

  <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
