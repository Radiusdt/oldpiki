<?php
/**
 * @var \app\modules\user\models\User $user
 */
?>
Dear <?= $user->username ?>!<br>
Your account <?= $user->email ?> has been APPROVED and is now ready to use. <br>
Please go to <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/user/auth/login']); ?>">login page</a> and log in with your email and password.<br>