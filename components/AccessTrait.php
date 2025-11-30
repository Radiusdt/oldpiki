<?php
namespace app\components;

use app\modules\user\enums\Role;
use app\modules\user\models\User;
use yii\db\ActiveQuery;

/**
 * Class AccessTrait
 * @package app\components
 *
 * @property integer $user_id
 * @property User[] $accessedUsers
 */
trait AccessTrait
{
    /**
     * @var User $_user
     */
    protected $_user;
    public $accessUserIds = [];

    public function setCurrentUser(User $user)
    {
        $this->_user = $user;
    }

    private static function getIdProperty()
    {
        return self::tableName() . '_id';
    }

    public function hasEditAccess(User $user)
    {
        if ($user->checkRole(Role::ADMINISTRATOR->value)) {
            return true;
        } elseif ($user->checkRole($user->checkRole(Role::ADMINISTRATOR->value))){
            if (!empty($this->user) && $this->user->team_id == $user->team_id) {
                return true;
            }
        }
        if ($this->user_id == $user->id) {
            return true;
        }
        return false;
    }

    public function hasAccess(User $user)
    {
        if ($this->hasEditAccess($user)) {
            return true;
        }

        return false;
    }

    public function addAccessCondition(ActiveQuery|\brntsrs\ClickHouse\ActiveQuery $query)
    {
        self::addAccessConditionToQuery($this->_user, $query);
    }

    private static function addAccessConditionToQuery(User $user, ActiveQuery|\brntsrs\ClickHouse\ActiveQuery $query)
    {
        switch ($user->getRole()) {
            case Role::ADMINISTRATOR->value:
            case Role::SUPER_ADMIN->value:
                /*$query->andFilterWhere([
                    'or',
                    ['user_id' => $user->id],
                    ['in', 'id', $allowedIds],
                ]);*/
                //$query->andFilterWhere(['user_id' => $user->id]);
                break;
            case Role::TEAMLEAD->value:
                $user = User::findOne($user->id);
                if (!empty($user) && !empty($user->team_id)) {
                    $ids = User::find()
                        ->filterWhere(['team_id' => $user->team_id])
                        ->select(['id'])
                        ->column();
                    $query->andFilterWhere([
                        'or',
                        ['user_id' => $ids],
                    ]);
                } else {
                    $query->andFilterWhere([
                        'or',
                        ['user_id' => $user->id],
                    ]);
                }
                break;
            default:
                $query->andFilterWhere([
                    'or',
                    ['user_id' => $user->id],
                ]);
        }
    }
}