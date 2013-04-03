<?php

class SnroController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'snro';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Snro;

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
				'snroid'=>$model->snroid,
				'description'=>$model->description,
				'formatdoc'=>$model->formatdoc,
				'formatno'=>$model->formatno,
				'repeatby'=>$model->repeatby,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Snro'], $_POST['Snro']['snroid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Snro']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Snro']['description'],'emptydescription','emptystring'),
                array($_POST['Snro']['formatdoc'],'emptyformatdoc','emptystring'),
                array($_POST['Snro']['formatno'],'emptyformatno','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Snro'];
		if ((int)$_POST['Snro']['snroid'] > 0)
		{
		  $model=$this->loadModel($_POST['Snro']['snroid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->description = $_POST['Snro']['description'];
		  $model->formatdoc = $_POST['Snro']['formatdoc'];
		  $model->formatno = $_POST['Snro']['formatno'];
		  $model->repeatby = $_POST['Snro']['repeatby'];
		  $model->recordstatus = $_POST['Snro']['recordstatus'];
		}
		else
		{
		  $model = new Snro();
		  $model->attributes=$_POST['Snro'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Snro']['snroid']);
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
	
	protected function gridData($data,$row)
  {     
    $model = Snro::model()->findByPk($data->snroid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
    $model=new Snro('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Snro']))
			$model->attributes=$_GET['Snro'];
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
	  $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
	  $allowedExtensions = array("csv");
	  $sizeLimit = (int)Yii::app()->params['sizeLimit'];// maximum file size in bytes
	  $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
	  $result = $uploader->handleUpload($folder,true);
	  $row = 0;
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model=Snro::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Snro();
			  }
			  $model->snroid = (int)$data[0];
			  $model->description = $data[1];
			  $model->formatdoc = $data[2];
			  $model->formatno = (int)$data[3];
			  $model->repeatby = (int)$data[4];
			  $model->recordstatus = (int)$data[5];
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
		$sql = "select description,formatdoc,formatno
				from snro a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.snroid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='SNRO List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->setaligns(array('C','C','C'));
		$this->pdf->setwidths(array(60,50,40));
		$this->pdf->Row(array('Description','Format Doc','Format No'));
		$this->pdf->setaligns(array('L','L','L'));
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['description'],$row1['formatdoc'],$row1['formatno']));
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
		$model=Snro::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='snro-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
