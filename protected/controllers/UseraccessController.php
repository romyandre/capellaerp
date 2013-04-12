<?php

class UseraccessController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	protected $menuname='useraccess';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
      $model=new Useraccess;

      // Uncomment the following line if AJAX validation is needed
      // $this->performAjaxValidation($model);

      if (Yii::app()->request->isAjaxRequest)
      {
          echo CJSON::encode(array(
              'status'=>'success',
              ));
          Yii::app()->end();
      }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
      parent::actionUpdate();
      $model=$this->loadModel($_POST['id']);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
          echo CJSON::encode(array(
              'status'=>'success',
              'useraccessid'=>$model->useraccessid,
              'username'=>$model->username,
              'password'=>$model->password,
              'realname'=>$model->realname,
              'email'=>$model->email,
			  'theme'=>$model->theme,
			  'languageid'=>$model->languageid,
			  'languagename'=>($model->language!==null)?$model->language->languagename:'',
			  'background'=>$model->background,
              'recordstatus'=>$model->recordstatus,
              ));
          Yii::app()->end();
        }
      }
	}
	
	protected function gridData($data,$row)
  {     
    $model = Useraccess::model()->findByPk($data->useraccessid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Useraccess'], $_POST['Useraccess']['useraccessid']);
    }

	public function actionWrite()
	{
      parent::actionWrite();
	  if(isset($_POST['Useraccess']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Useraccess']['realname'],'emptyrealname','emptystring'),
            array($_POST['Useraccess']['username'],'emptyusername','emptystring'),
            array($_POST['Useraccess']['email'],'emptyemailname','emptystring'),
            array($_POST['Useraccess']['languageid'],'emptylanguagename','emptystring'),
            )
        );
        if ($messages == '') {
          $oldpass=$_POST['passhide'];
          if ((int)$_POST['Useraccess']['useraccessid'] > 0)
          {
            $model=$this->loadModel($_POST['Useraccess']['useraccessid']);
			$this->olddata = $model->attributes;
			$this->useraction='update';
            $model->username = $_POST['Useraccess']['username'];
            $model->realname = $_POST['Useraccess']['realname'];
			            $model->theme = $_POST['Useraccess']['theme'];
            $model->languageid = $_POST['Useraccess']['languageid'];
            $model->background = $_POST['Useraccess']['background'];
            if ($_POST['Useraccess']['password'] == '')
            {
              $model->password = $oldpass;
            }
			else
			{
				$model->password = $model->hashPassword($_POST['Useraccess']['password'],$model->salt);
			}
            $model->email = $_POST['Useraccess']['email'];
            $model->recordstatus = $_POST['Useraccess']['recordstatus'];
          }
          else
          {
            $model = new Useraccess();
            $model->attributes=$_POST['Useraccess'];
            $model->salt = $model->generateSalt();
            $model->password=$model->hashPassword($model->password,$model->salt);
			$this->olddata = $model->attributes;
			$this->useraction='new';
          }
		  $this->newdata = $model->attributes;
          try
          {
            if($model->save())
            {
				$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Useraccess']['useraccessid']);
              $this->GetSMessage('insertsuccess');
            }
            else
            {
              $this->GetMessage($model->getErrors());
            }
          }
          catch (Exception $e)
          {
            $this->GetMessage($e->getMessage());
          }
        }
	  }
	}
	
	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select username,realname,email,phoneno
				from useraccess a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.useraccessid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='User Access List';
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->setwidths(array(40,50,50,40));
		$this->pdf->colheader = array('Username','Real Name','Email','Phone No');
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign=array('L','L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['username'],$row1['realname'],$row1['email'],$row1['phoneno']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
      parent::actionDelete();
		  $model=$this->loadModel($_POST['id']);
		  $model->recordstatus=0;
		  $model->save();
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
      parent::actionIndex();
    $model=new Useraccess('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Useraccess']))
			$model->attributes=$_GET['Useraccess'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Useraccess::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='useraccess-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
