<?php

namespace app\components;

use Yii;
use yii\base\Component;

use yii\swiftmailer\Mailer as MailerVipHosting;

use app\models\Mailayar as Model;

class VipHostingmailer extends Component
{
    private $_settings = [];
	
	private $mailerVipHosting;

    public function init()
    {
		
		$settings = Model::find()->all();
		
		$this->mailerVipHosting = new MailerVipHosting;
		
        foreach ($settings as $setting) {
			if($setting->key == 'password'){
				$setting->value = Yii::$app->security->decryptByPassword(base64_decode($setting->value), Yii::$app->params['secret']);
			}
            $this->_settings[$setting->key] = $setting->value;
        }
		
		$this->mailerVipHosting->setTransport(
		
			[
				'class' => 'Swift_SmtpTransport',
				'host' => $this->_settings['hostname'], 
				'username' => $this->_settings['username'],
				'password' => $this->_settings['password'],
				'port' => $this->_settings['port'], 
				'encryption' => $this->_settings['security']
			]
		);
				
    }
		
    public function send($to, $subject, $detail)
    {
		
		$gonder = $this->mailerVipHosting->compose()
		 ->setFrom(array($this->_settings['username'] => $this->_settings['from']))
		 ->setTo($to)
		 ->setSubject($subject)
		 ->setHtmlBody($detail)
		 ->send();
		 
		 return $gonder;
		 
	 }
	 
    public function __get($key)
    {
        if (isset($this->_settings[$key])) {
            return $this->_settings[$key];
        }

        return false;
    }

    public function __set($key, $value)
    {
		$this->_settings[$key] = $value;
    }

    public function all()
    {
        return $this->_settings;
    }
	 
}