<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
	public $firstName;
	public $lastName;
    public $email;
    public $password;
    public $confirm;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['firstName', 'filter', 'filter' => 'trim'],
            ['firstName', 'required', 'message' => 'Пожалуйста, укажите имя'],
            ['firstName', 'string', 'min' => 2, 'max' => 255],

        	['lastName', 'filter', 'filter' => 'trim'],
        	['lastName', 'required', 'message' => 'Пожалуйста, укажите фамилию'],
        	['lastName', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => 'Пожалуйста, укажите email'],
            ['email', 'email', 'message' => 'Неверный формат почты'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Это email уже зарегистрирован'],

            ['password', 'required', 'message' => 'Пожалуйста, укажите пароль'],
            ['password', 'string', 'min' => 6, 'message' => 'Пароль слишком короткий, минимум 6 символов'],
            ['password', 'validatePassword'],

        	['confirm', 'required', 'message' => 'Необходимо ввести пароль еще раз'],
            ['confirm', 'confirmPassword'],
        ];
    }

    public function attributeLabels()
    {
    	return ['firstName' => 'Имя', 'lastName' => 'Фамилия',
    			'email' => 'E-mail', 'password' => 'Пароль', 'confirm' => 'Повторите пароль'];
    }
    
    public function validatePassword($attribute, $params)
    {
    	if (!preg_match('/^[\da-zA-Z_#]/', $this->password)) {
    		$this->addError($attribute, 'Пароль содержит запрещённые символы');
    	}
    }
    
    public function confirmPassword($attribute, $params)
    {
    	if ($this->password != $this->confirm) {
    		$this->addError($attribute, 'Подтверждение не совпадает с паролем');
    	}
    }
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->firstName = $this->firstName;
        $user->lastName = $this->lastName;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
