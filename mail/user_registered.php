<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $token string */
/* @var \app\modules\user\models\User $user */
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/auth/activation', 'token' => $token]);
?>

Hello, <?php echo Html::encode($user->username) ?><br><br>

Thank you for registering! Please click here to verify your e-mail address, or use the link below:<br>

<?php echo Html::a(Html::encode($confirmLink), $confirmLink) ?>.<br><br>
We will let you know once your account has been approved.