<?php

class SlocController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'sloc';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $plant=new Plant('searchwstatus');
	  $plant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Plant']))
		$plant->attributes=$_GET['Plant'];
		$model=new Sloc;

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
	  $plant=new Plant('searchwstatus');
	  $plant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Plant']))
		$plant->attributes=$_GET['Plant'];
	  $model=$this->loadModel($_POST['id']);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
				'slocid'=>$model->slocid,
				'plantid'=>$model->plantid,
				'plantcode'=>($model->plant!==null)?$model->plant->plantcode:"",
				'sloccode'=>$model->sloccode,
				'description'=>$model->description,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Sloc'], $_POST['Sloc']['slocid']);
    }
	

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Sloc']))
	  {
        $messages = $this->ValidateData(
                array(
                array($_POST['Sloc']['plantid'],'emptyplantcode','emptystring'),
				array($_POST['Sloc']['sloccode'],'emptysloccode','emptystring'),
                array($_POST['Sloc']['description'],'emptydescription','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Sloc'];
		if ((int)$_POST['Sloc']['slocid'] > 0)
		{
		  $model=$this->loadModel($_POST['Sloc']['slocid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->sloccode = $_POST['Sloc']['sloccode'];
		  $model->plantid = $_POST['Sloc']['plantid'];
		  $model->description = $_POST['Sloc']['description'];
		  $model->recordstatus = $_POST['Sloc']['recordstatus'];
		}
		else
		{
		  $model = new Sloc();
		  $model->attributes=$_POST['Sloc'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Sloc']['slocid']);
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
    $model = Sloc::model()->findByPk($data->slocid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $plant=new Plant('searchwstatus');
	  $plant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Plant']))
		$plant->attributes=$_GET['Plant'];
		$model=new Sloc('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
			$model->attributes=$_GET['Sloc'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		'model'=>$model,
		'plant'=>$plant
	  ));
	}

	public function actionDownload()
  {
	parent::actionDownload();
    $sql = "select b.plantcode, a.sloccode, a.description
      from sloc a
      left join plant b on b.plantid = a.plantid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.slocid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

	  $this->pdf->title='Storage Location List';
	  $this->pdf->AddPage('P');

    $this->pdf->colalign = array('C','C','C','C');
    $this->pdf->setwidths(array(30,30,130));
	$this->pdf->colheader = array('Plant','Sloc Code','Description');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','L','L');
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['plantcode'],$row1['sloccode'],$row1['description']));
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
		$model=Sloc::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sloc-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
