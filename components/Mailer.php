<?php
namespace app\components;

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;
use yii\base\Component;

class Mailer extends Component
{
    public $apiKey = '';
    public $apiSecret = '';
    public $from = [];
    public $templates = [];

    /**
     * @var ApiClient
     */
    private $client;

    public function init()
    {
        parent::init();
        try {
            $this->client = new ApiClient(
                $this->apiKey,
                $this->apiSecret,
                new FileStorage(\Yii::getAlias('@app/runtime/email'))
            );
        } catch (\Exception $exception) {
            $this->client = false;
        }
    }

    public function send(\app\modules\user\models\User $user, $subject, $view, $params)
    {
        if ($this->client === false) {
            return false;
        }

        $params['userName'] = $user->getPublicIdentity();

        $template = null;
        if (isset($this->templates[$view])) {
            $template = $view;
        }

        if (!empty($template)) {
            return $this->client->smtpSendMail([
                'template' => [
                    'id' => $this->templates[$template],
                    'variables' => $params,
                ],
                'subject' => $subject,
                'from'    => $this->from,
                'to'      => [
                    [
                        'name' => $user->getPublicIdentity(),
                        'email' => $user->email,
                    ],
                ],
            ]);
        }
        return $this->client->smtpSendMail([
            'html'    => $this->renderMessage($view, $params),
            'subject' => $subject,
            'from'    => $this->from,
            'to'      => [
                [
                    'name' => $user->getPublicIdentity(),
                    'email' => $user->email,
                ],
            ],
        ]);
    }

    public function sendToAdmin($email, $subject, $view, $params)
    {
        return $this->client->smtpSendMail([
            'html'    => $this->renderMessage($view, $params),
            'subject' => $subject,
            'from'    => $this->from,
            'to'      => [
                [
                    'email' => $email,
                ],
            ],
        ]);
    }

    private function renderMessage($view, $params)
    {
        return (string)(\Yii::$app->controller->renderPartial('@app/mail/' . $view, $params));
    }
}