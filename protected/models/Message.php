<?php

/**
 * This is the model class for table "sigma_message".
 *
 * The followings are the available columns in table 'sigma_message':
 * @property string $message_sender
 * @property string $message_reciever
 * @property string $message_content
 * @property string $message_time
 * @property integer $messsage_type
 * @property string $message_color
 * @property string $message_is_secret
 * @property string $message_is_kick
 */
class Message extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Message the static model class
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
		return 'sigma_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('messsage_type', 'numerical', 'integerOnly'=>true),
			array('message_sender, message_reciever', 'length', 'max'=>20),
			array('message_color', 'length', 'max'=>8),
			array('message_is_secret, message_is_kick', 'length', 'max'=>1),
			array('message_content, message_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('message_sender, message_reciever, message_content, message_time, messsage_type, message_color, message_is_secret, message_is_kick', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'message_sender' => 'Message Sender',
			'message_reciever' => 'Message Reciever',
			'message_content' => 'Message Content',
			'message_time' => 'Message Time',
			'messsage_type' => 'Messsage Type',
			'message_color' => 'Message Color',
			'message_is_secret' => 'Message Is Secret',
			'message_is_kick' => 'Message Is Kick',
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

		$criteria->compare('message_sender',$this->message_sender,true);
		$criteria->compare('message_reciever',$this->message_reciever,true);
		$criteria->compare('message_content',$this->message_content,true);
		$criteria->compare('message_time',$this->message_time,true);
		$criteria->compare('messsage_type',$this->messsage_type);
		$criteria->compare('message_color',$this->message_color,true);
		$criteria->compare('message_is_secret',$this->message_is_secret,true);
		$criteria->compare('message_is_kick',$this->message_is_kick,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}