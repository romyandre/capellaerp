<?php

class WfgroupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
 protected $menuname = 'wfgroup';

	public $workflow,$groupaccess;
  
	public function lookupdata()
	{
	  $this->workflow=new Workflow('searchwstatus');
	  $this->workflow->unsetAttributes();  // clear any default values
	  if(isset($_GET['Workflow']))
		$this->workflow->attributes=$_GET['Workflow'];

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
	  $model=new Wfgroup;
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
	  $this->lookupdata();
	  $model=$this->loadModel($_POST['id']);
	  if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'wfgroupid'=>$model->wfgroupid,
              'groupaccessid'=>$model->groupaccessid,
			  'groupname'=>($model->groupaccess!==null)?$model->groupaccess->groupname:"",
			  'workflowid'=>$model->workflowid,
			  'wfdesc'=>$model->workflow->wfdesc,
              'wfbefstat'=>$model->wfbefstat,
              'wfrecstat'=>$model->wfrecstat,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
				'workflow'=>$this->workflow,
				'groupaccess'=>$this->groupaccess), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Wfgroup'], $_POST['Wfgroup']['wfgroupid']);
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
		$model->delete();
	  echo CJSON::encode(array(
			  'status'=>'success',
			  'div'=>'Data deleted'
			  ));
	  Yii::app()->end();
	}

	public function actionWrite()
	{
	  if(isset($_POST['Wfgroup']))
	  {
		$messages = $this->ValidateData(
                array(array($_POST['Wfgroup']['workflowid'],'emptyworkflow','emptystring'),
            array($_POST['Wfgroup']['groupaccessid'],'emptygroupaccess','emptystring'),
            array($_POST['Wfgroup']['wfbefstat'],'emptywfbefstat','emptystring'),
            array($_POST['Wfgroup']['wfrecstat'],'emptywfrecstat','emptystring'),
            )
        );
        if ($messages == '') {
          if ((int)$_POST['Wfgroup']['wfgroupid'] > 0)
          {
            $model=$this->loadModel($_POST['Wfgroup']['wfgroupid']);
            $model->workflowid = $_POST['Wfgroup']['workflowid'];
            $model->groupaccessid = $_POST['Wfgroup']['groupaccessid'];
            $model->wfbefstat = $_POST['Wfgroup']['wfbefstat'];
            $model->wfrecstat = $_POST['Wfgroup']['wfrecstat'];
            $model->recordstatus = $_POST['Wfgroup']['recordstatus'];
          }
          else
          {
            $model = new Wfgroup();
            $model->attributes=$_POST['Wfgroup'];
          }
          try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Wfgroup']['wfgroupid']);
              $this->GetSMessage('scoinsertsuccess');
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
	
	protected function gridData($data,$row)
	{     
		$model = Wfgroup::model()->findByPk($data->wfgroupid); 
		return $this->renderPartial('_view',array('model'=>$model),true); 
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();

	  $model=new Wfgroup('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Wfgroup']))
		  $model->attributes=$_GET['Wfgroup'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		  'model'=>$model,
				'workflow'=>$this->workflow,
				'groupaccess'=>$this->groupaccess
	  ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Wfgroup::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='wfgroup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select wfname,wfdesc,groupname,wfbefstat,wfrecstat
				from wfgroup a
left join workflow b on b.workflowid = a.workflowid
left join groupaccess c on c.groupaccessid = a.groupaccessid				";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.positionid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Workflow Group List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->colalign=array('C');
		$this->pdf->setwidths(array(90));
		$this->pdf->colheader=array('Workflow Name','Description','Group Name','Before Status','After Status');
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign=array('L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['wfname'],$row1['wfdesc'],$row1['groupname'],$row1['wfbefstat'],$row1['wfrecstat']));
		}
		// me-render ke browser
		$this->pdf->Output();
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
			  $model=Wfgroup::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Wfgroup();
			  }
			  $model->wfgroupid = (int)$data[0];
			  $model->wfgroupname = $data[1];
			  $model->absin = $data[2];
			  $model->absout = $data[3];
			  $model->workflowid = (int)$data[4];
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
}
