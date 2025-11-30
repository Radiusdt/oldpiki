<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $token string */
/* @var \app\modules\user\models\User $user */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/password/reset', 'token' => $token]);
?>

    Hello, <?php echo Html::encode($user->username) ?><br><br>

    Just follow the link to proceed with password reset:

<?php echo Html::a(Html::encode($resetLink), $resetLink) ?>.<br><br>
If you did not request password change, just ignore this message.