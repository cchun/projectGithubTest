<?php

/**
 * This is the model class for table "sigma_user".
 *
 * The followings are the available columns in table 'sigma_user':
 * @property integer $user_id
 * @property string $user_password
 * @property string $user_username
 *
 * The followings are the available model relations:
 * @property SigmaBlog[] $sigmaBlogs
 * @property SigmaCompetition[] $sigmaCompetitions
 * @property SigmaCompetitionSubmit[] $sigmaCompetitionSubmits
 * @property SigmaUserCompetition[] $sigmaUserCompetitions
 * @property SigmaUserTask[] $sigmaUserTasks
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sigma_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_password, user_username', 'required'),
			array('user_password, user_username', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, user_password, user_username', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'sigmaBlogs' => array(self::HAS_MANY, 'SigmaBlog', 'blog_user_id'),
			'sigmaCompetitions' => array(self::HAS_MANY, 'SigmaCompetition', 'competition_creater'),
			'sigmaCompetitionSubmits' => array(self::HAS_MANY, 'SigmaCompetitionSubmit', 'competition_submit_user_id'),
			'sigmaUserCompetitions' => array(self::HAS_MANY, 'SigmaUserCompetition', 'user_competition_user_id'),
			'sigmaUserTasks' => array(self::HAS_MANY, 'SigmaUserTask', 'user_task_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'user_password' => 'User Password',
			'user_username' => 'User Username',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_password',$this->user_password,true);
		$criteria->compare('user_username',$this->user_username,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function validatePassword($password) {
		return $password === $this->user_password;
	}
	
	
	/**
	 * function:返回用户列表数组
	 * 无参数
	 */
	public static function getUserOnline() {
		$userArray = array();
		$model = new UserOnline;
		$modelArray = $model->findAll();
		foreach($modelArray as $mod) {
			array_push($userArray, $mod->online_name);
		}
		return $userArray;
	}
}







