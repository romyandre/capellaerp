<?php

class PurchasingorgController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'purchasingorg';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Purchasingorg;

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
				'purchasingorgid'=>$model->purchasingorgid,
				'purchasingorgcode'=>$model->purchasingorgcode,
				'description'=>$model->description,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Purchasingorg'], $_POST['Purchasingorg']['purchasingorgid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Purchasingorg']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Purchasingorg']['purchasingorgcode'],'emptypurchasingorgcode','emptystring'),
                array($_POST['Purchasingorg']['description'],'emptydescription','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Purchasingorg'];
		if ((int)$_POST['Purchasingorg']['purchasingorgid'] > 0)
		{
		  $model=$this->loadModel($_POST['Purchasingorg']['purchasingorgid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->purchasingorgcode = $_POST['Purchasingorg']['purchasingorgcode'];
		  $model->description = $_POST['Purchasingorg']['description'];
		  $model->recordstatus = $_POST['Purchasingorg']['recordstatus'];
		}
		else
		{
		  $model = new Purchasingorg();
		  $model->attributes=$_POST['Purchasingorg'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Purchasingorg']['purchasingorgid']);
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
    $model = Purchasingorg::model()->findByPk($data->purchasingorgid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
		$model=new Purchasingorg('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Purchasingorg']))
			$model->attributes=$_GET['Purchasingorg'];
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
		$file = $folder . basename($_FILES['uploadfile']['name']); 
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
			echo "success";
			$row=1;			
			if (($handle = fopen($file, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					if ($row>1) {
			  $model=Purchasingorg::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Purchasingorg();
			  }
			  $model->purchasingorgid = (int)$data[0];
			  $model->purchasingorgcode = $data[1];
			  $model->description = $data[2];
			  $model->recordstatus = (int)$data[3];
			  try
					  {
						if(!$model->save())
						{
						  echo $model->getErrors();
						}
					  }
					  catch (Exception $e)
					  {
						echo $e->getMessage();;
					  }
					}
					$row++;
				}
				fclose($handle);
			}
		} else {
			echo Yii::t('app','directory permission');
		}	
  }

	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select purchasingorgcode,description
				from purchasingorg a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.purchasingorgid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Purchasing Organization List';
		$this->pdf->AddPage('P');
		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->colalign = array('C','C');
		$this->pdf->setwidths(array(20,120));
		$this->pdf->colheader = array('Code','Description');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['purchasingorgcode'],$row1['description']));
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
		$model=Purchasingorg::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchasingorg-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
