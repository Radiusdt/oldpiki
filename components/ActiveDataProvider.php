<?php
namespace app\components;

use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\data\Sort;
use yii\db\ActiveQueryInterface;

class ActiveDataProvider extends \yii\data\ActiveDataProvider
{
    private $_sort;

    /**
     * {@inheritdoc}
     */
    public function setSort($value)
    {
        if (is_array($value)) {
            $config = ['class' => Sort::class];
            if ($this->id !== null) {
                $config['sortParam'] = $this->id . '-sort';
            }
            $this->_sort = \Yii::createObject(array_merge($config, $value));
        } elseif ($value instanceof Sort || $value === false) {
            $this->_sort = $value;
        } else {
            throw new InvalidArgumentException('Only Sort instance, configuration array or false is allowed.');
        }

        if ($this->query instanceof ActiveQueryInterface && ($sort = $this->getSort()) !== false) {
            /* @var $modelClass Model */
            $modelClass = $this->query->modelClass;
            $model = $modelClass::instance();
            if (empty($sort->attributes)) {
                foreach ($model->attributes() as $attribute) {
                    $sort->attributes[$attribute] = [
                        'asc' => [$attribute => SORT_ASC],
                        'desc' => [$attribute => SORT_DESC],
                        'label' => $model->getAttributeLabel($attribute),
                    ];
                }
            } else {
                foreach ($sort->attributes as $attribute => $config) {
                    if (!isset($config['label'])) {
                        $sort->attributes[$attribute]['label'] = $model->getAttributeLabel($attribute);
                    }
                }
            }
        }
    }

    public function getSort()
    {
        if ($this->_sort === null) {
            $this->setSort([]);
        }

        return $this->_sort;
    }
}