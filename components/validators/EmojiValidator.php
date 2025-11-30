<?php
namespace app\components\validators;

class EmojiValidator extends \yii\validators\Validator
{
    public function validateAttribute($model, $attribute)
    {
        $modelTranslations = $model->translations ?? null;
        $modelLanguages = $model->languages ?? null;
        if ($modelTranslations) {
            foreach ($modelTranslations as $key => $translation) {
                if ($translation) {
                    if (is_array($translation)) {
                        foreach ($translation as $language => $text) {
                            preg_match('/[\x{1F600}-\x{1F64F}]/u', $text, $matches_emo);
                            if (!empty($matches_emo[0])) {
                                $model->addError($attribute . '[' . $key . '][' . $language . ']', \Yii::t('user', 'Строка содержит недопустимые символы'));
                            }
                        }
                    } else {
                        preg_match('/[\x{1F600}-\x{1F64F}]/u', $translation, $matches_emo);
                        if (!empty($matches_emo[0])) {
                            $model->addError($attribute . '[' . $key . '][' . $language . ']', \Yii::t('user', 'Строка содержит недопустимые символы'));
                        }
                    }
                }
            }
        }
        if ($modelLanguages) {
            foreach ($modelLanguages as $language => $text) {
                preg_match('/[\x{1F600}-\x{1F64F}]/u', $text, $matches_emo);
                if (!empty($matches_emo[0])) {
                    $model->addError($attribute . '[' . $language . ']', \Yii::t('user', 'Строка содержит недопустимые символы'));
                }
            }
        }
        preg_match('/[\x{1F600}-\x{1F64F}]/u', $model->{$attribute}, $matches_emo);
        if (!empty($matches_emo[0])) {
            $model->addError($attribute, \Yii::t('user', 'Строка содержит недопустимые символы'));
        }
    }
}
