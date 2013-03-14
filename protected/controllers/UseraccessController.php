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
      $id=$_POST['id'];
      $model=$this->loadModel($id[0]);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
          echo CJSON::encode(array(
              'status'=>'success',
              'useraccessid'=>$model->useraccessid,
              'username'=>$model->username,
              'password'=>$model->password,
              'realname'=>$model->realname,
              'email'=>$model->email,
              'recordstatus'=>$model->recordstatus,
			  'employeeid'=>$model->employeeid,
				'fullname'=>($model->employee!==null)?$model->employee->fullname:"",
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
              $this->GetSMessage('suainsertsuccess');
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
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

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
			  $model=$this->loadModel((int)$data[0]);
			  if ($model=== null) {
				$model = new Addressbook();
			  }
			  $model->fullname = $data[1];
			  $model->iscustomer = (int)$data[2];
			  $model->isemployee = (int)$data[3];
			  $model->isapplicant = (int)$data[4];
			  $model->isvendor = (int)$data[5];
			  $model->isinsurance = (int)$data[6];
			  $model->isbank = (int)$data[7];
			  $model->ishospital = (int)$data[8];
			  $model->iscatering = (int)$data[9];
			  $model->recordstatus = (int)$data[10];
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
