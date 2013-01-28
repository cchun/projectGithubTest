<?php

class SiteController extends Controller
{
	public $layout='//layouts/userOnline';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				
				//把登录用户信息添加到tbl_useronline表上
				$tbl_useron = new UserOnline();
				$tbl_useron->online_name = Yii::app()->user->name;
				$tbl_useron->online_time_now = date("YmdHis");
				$tbl_useron->online_from_time = date("YmdHis");
				$tbl_useron->save();
				
				
				$user = Yii::app()->user->name;
				$namefrom = $user;
				$nameto = "【系统消息】";
				$content = $user."进入了聊天室!";
			//	$this->render('test', array('para'=>$content));
				$this->addToTblChatcont($namefrom, $nameto, $content);
				$this->redirect(Yii::app()->user->returnUrl);
			//	$this->render('test', array('para'=>"HHHHHHHHH"));
			}	
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		$user = Yii::app()->user->name;
		Yii::app()->user->logout();
		//TblUseronline::delete(Yii::app()->user->name);
		$tbl_useron = new UserOnline();
		$tbl_useron->deleteAll("online_name='$user'");
		//$this->render('test', array('na'=>$na));
		
		$namefrom = $user;
		$nameto = "【系统消息】";
		$content = $user."离开了聊天室!";
		$this->addToTblChatcont($namefrom, $nameto, $content);
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
	public function actionTalk() {
		if(Yii::app()->user->isGuest)
       		 throw new CHttpException(iconv('gb2312', 'utf-8', "请先登录"));
        
		$user = Yii::app()->user->name;
		$modelarray = $this->getTalkLog();
		$tmp = "";
		foreach($modelarray as $model) {
			if($model->message_reciever == iconv("gb2312","utf-8", "所有人")) {
				$model->message_reciever = iconv("gb2312","utf-8", "【闲聊】");
				$model->message_content = iconv("gb2312","utf-8", "说:").$model->message_content;
			}
			else {
				$model->message_sender = "";
			}
			$tmp .= $model->message_reciever.$model->message_sender.$model->message_content."\n";
		}
		$model = new Message;
		$model->message_content = $tmp;
		$model1 = new Message;
		
		//$model为TblUseronline
		if(isset($_POST['Message']))
		{
			$model1->attributes=$_POST['Message'];
			$model1->message_sender = $user;
			$model1->message_reciever =iconv("gb2312","utf-8", "所有人");
			$model1->message_time = date("YmdHis");
			$model1->save();
		}
		
		$array = array("HHHHH");
		$this->render('talkIndex',array(
			'model'=>$model,
			'model1'=>$model1, 
			'data'=>$array
		));
	}

	/**
	 * function:动态刷新聊天窗口，供ajax调用
	 */
	public function actionUpdateAjax() {
		
		$user = Yii::app()->user->name;
		$modelarray = $this->getTalkLog();
		$tmp = "";
		foreach($modelarray as $model) {
			if($model->message_reciever == iconv("gb2312","utf-8", "所有人")) {
				$model->message_reciever = iconv("gb2312","utf-8", "【闲聊】");
				$model->message_content = iconv("gb2312","utf-8", "说:").$model->message_content;
			}
			else {
				$model->message_sender = "";
			}
			$tmp .= $model->message_reciever.$model->message_sender.$model->message_content."\n";
		}
		$model = new Message;
		$model->message_content = $tmp;
		
		$this->renderPartial('_talklog', array('model'=>$model));
		//$this->renderPartial('test', array('para'=>"HHHHHHHHHH"));	
	}
	
	public function actionUpdateUseronline() {
		$model = new UserOnline;
		$modelArray = $model->findAll();
		
		foreach($modelArray as $mod) {
		/*	$this->menu=array(
				array('label'=>$mod->name),
			);*/
			array_push($this->menu, array('label'=>$mod->name));
		}
		$this->renderPartial('//layouts/userOnline');	
		//$this->renderPartial('test', array('para'=>$this->menu));	
	}
	
	//得到需要显示的聊天内容 
	private function getTalkLog() {
		$model = $this->getFromtime();
		$time = $model->online_from_time;
		$timer = $this->dotimer($time);
		
		$model = new Message();
		$res = $model->findAll("message_time > $timer");
		return $res; //array
	}

	public function af() {
		return "哈哈test";
	}
	
	//得到用户的显示聊天内容的起始时间
	private function getFromtime() {
		$user = Yii::app()->user->name;
		$tbl_useronline = new UserOnline();
		$res = $tbl_useronline->find("online_name='$user'");
		return $res;
	}
	
	//chang the string time to double time 
	private function dotimer($timer) {
		$timer = str_replace("-", "", $timer);
		$timer = str_replace(":", "", $timer);
		$timer = str_replace(" ", "", $timer);
		$timer = chop($timer);		
		return doubleval($timer);
	}
	
	/**
	 * function:插入数据到$sigma_message_content
	 * para:发送者 接受者  内容
	 */
	 private function addToTblChatcont($namefrom, $nameto, $content) {
		$tbl_userChatcontent = new Message();
		$tbl_userChatcontent->message_time = date("YmdHis")+1;
		$tbl_userChatcontent->message_sender = iconv("gb2312","utf-8", $namefrom);
		$tbl_userChatcontent->message_reciever = iconv("gb2312","utf-8", $nameto);
		$tbl_userChatcontent->message_content = iconv("gb2312","utf-8", $content);
		$tbl_userChatcontent->save();
	 }
}














