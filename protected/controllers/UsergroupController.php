<?php

class UsergroupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	protected $menuname = 'usergroup';
	public $useraccess,$groupaccess;

	public function lookupdata()
	{
	  $this->useraccess=new Useraccess('searchwstatus');
	  $this->useraccess->unsetAttributes();  // clear any default values
	  if(isset($_GET['Useraccess']))
		$this->useraccess->attributes=$_GET['Useraccess'];

	  $this->groupaccess=new Groupaccess('searchwstatus');
	  $this->groupaccess->unsetAttributes();  // clear any default values
	  if(isset($_GET['Groupaccess']))
		$this->groupaccess->attributes=$_GET['Groupaccess'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            parent::actionCreate();
		$this->lookupdata();
		$model=new Usergroup;

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
				'usergroupid'=>$model->usergroupid,
				'useraccessid'=>$model->useraccessid,
				'username'=>$model->useraccess->username,
				'groupaccessid'=>$model->groupaccessid,
				'groupname'=>$model->groupaccess->groupname,
				));
            Yii::app()->end();
        }
      }
	}
	
	protected function gridData($data,$row)
  {     
    $model = Usergroup::model()->findByPk($data->usergroupid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Usergroup'], $_POST['Usergroup']['usergroupid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Usergroup']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Usergroup']['useraccessid'],'emptyusername','emptystring'),
            array($_POST['Usergroup']['groupaccessid'],'emptygroupname','emptystring'),
            )
        );
        if ($messages == '') {
          //$_POST['Usergroup']=$_POST['Usergroup'];
          if ((int)$_POST['Usergroup']['usergroupid'] > 0)
          {
            $model=$this->loadModel($_POST['Usergroup']['usergroupid']);
			$this->olddata = $model->attributes;
			$this->useraction='update';
            $model->useraccessid = $_POST['Usergroup']['useraccessid'];
            $model->groupaccessid = $_POST['Usergroup']['groupaccessid'];
          }
          else
          {
            $model = new Usergroup();
            $model->attributes=$_POST['Usergroup'];
			$this->olddata = $model->attributes;
			$this->useraction='new';
          }
		  $this->newdata = $model->attributes;
          try
            {
              if($model->save())
              {
			  $this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Usergroup']['usergroupid']);
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
            parent::actionDelete();
		  $model=$this->loadModel($_POST['id']);
		  $model->delete();
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
		 $this->lookupdata();
		$model=new Usergroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usergroup']))
			$model->attributes=$_GET['Usergroup'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
		'useraccess'=>$this->useraccess,
		'groupaccess'=>$this->groupaccess
		));
	}

        public function actionUpload()
	{
	  parent::actionUpload();
	  Yii::import("ext.EAjaxUpload.qqFileUploader");
	  $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
	  $allowedExtensions = array("csv");
	  $sizeLimit = (int)Yii::app()->params['sizeLimit'];// maximum file size in bytes
	  $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
	  $result = $uploader->handleUpload($folder,true);
	  $row = 0;
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model=Absrule::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Absrule();
			  }
			  $model->absruleid = (int)$data[0];
			  $model->absscheduleid = (int)$data[1];
			  $model->difftimein = $data[2];
			  $model->difftimeout = $data[3];
			  $model->absstatusid = (int)$data[4];
			  $model->recordstatus = 1;
			  try
			  {
				if(!$model->save())
				{
				  $errormessage=$model->getErrors();
				  if (Yii::app()->request->isAjaxRequest)
				  {
					echo CJSON::encode(array(
					  'status'=>'failure',
					  'div'=>$errormessage
					));
				  }
				}
			  }
			  catch (Exception $e)
			  {
				$errormessage=$e->getMessage();
				if (Yii::app()->request->isAjaxRequest)
				  {
					echo CJSON::encode(array(
					  'status'=>'failure',
					  'div'=>$errormessage
					));
				  }
			  }
			}
			$row++;
		  }
		  fclose($handle);
	  }
	  $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	  echo $result;
  }

  public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select username,groupname
				from usergroup a
left join useraccess b on b.useraccessid = a.useraccessid
left join groupaccess c on c.groupaccessid = a.groupaccessid				";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.usergroupid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='User Group List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->setaligns(array('C','C'));
		$this->pdf->setwidths(array(90,90));
		$this->pdf->Row(array('User Name','Group Name'));
		$this->pdf->setaligns(array('L','L'));
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['username'],$row1['groupname']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
  
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Usergroup::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='usergroup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
