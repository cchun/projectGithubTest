<?php

/**
 * This is the model class for table "sigma_user_online".
 *
 * The followings are the available columns in table 'sigma_user_online':
 * @property string $online_name
 * @property string $online_time_now
 * @property string $online_from_time
 */
class UserOnline extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserOnline the static model class
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
		return 'sigma_user_online';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('online_name', 'length', 'max'=>20),
			array('online_time_now, online_from_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('online_name, online_time_now, online_from_time', 'safe', 'on'=>'search'),
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
			'online_name' => 'Online Name',
			'online_time_now' => 'Online Time Now',
			'online_from_time' => 'Online From Time',
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

		$criteria->compare('online_name',$this->online_name,true);
		$criteria->compare('online_time_now',$this->online_time_now,true);
		$criteria->compare('online_from_time',$this->online_from_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}