<?php

namespace OpenHive\LP;

use ReCaptcha\ReCaptcha;

class FormHandler
{
    protected $postData;

    public function __construct(array $post)
    {
        if ($post) {
            foreach ($post as $key => $value) {
                if (null !== $value) {
                    $this->postData[$key] = $value;
                }
            }
        }
    }

    public function handle(string $formName): bool
    {
        $requestedMethod = 'handleForm' . ucfirst($formName);
        if (method_exists($this, $requestedMethod)) {
            return $this->{$requestedMethod}();
        }

        return false;
    }

    protected function handleFormContact()
    {
        if (isset($this->postData['g-recaptcha-response'])) {
            $resp = (new ReCaptcha(RECAPTCHA_SECRET_KEY))->verify($this->postData['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if (isset($this->postData['email'], $this->postData['message']) && $resp->isSuccess() && filter_var($this->postData['email'], FILTER_VALIDATE_EMAIL)) {
                $message = htmlspecialchars(strip_tags($this->postData['name']??''));
                $message .= ('<' . $this->postData['email'] . '>: ' . PHP_EOL);
                $message .= htmlspecialchars(strip_tags($this->postData['message']));

                $telegram = new \Telegram\Bot\Api(TELEGRAM_TOKEN);

                $telegram->sendMessage([
                    'chat_id' => TELEGRAM_GROUP,
                    'text' => $message
                ]);

                return true;
            }
        }

        return false;
    }
}