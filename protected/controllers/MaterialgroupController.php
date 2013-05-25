<?php

class MaterialgroupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'materialgroup';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $parentmatgroup=new Materialgroup('searchwstatus');
	  $parentmatgroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Parentmatgroup']))
		$parentmatgroup->attributes=$_GET['Parentmatgroup'];

      	  $materialtype=new Materialtype('searchwstatus');
	  $materialtype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialtype']))
		$materialtype->attributes=$_GET['Materialtype'];

		$model=new Materialgroup;

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
	   $parentmatgroup=new Materialgroup('searchwstatus');
	  $parentmatgroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Parentmatgroup']))
		$parentmatgroup->attributes=$_GET['Parentmatgroup'];

      $materialtype=new Materialtype('searchwstatus');
	  $materialtype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialtype']))
		$materialtype->attributes=$_GET['Materialtype'];
	  $model=$this->loadModel($_POST['id']);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
				'materialgroupid'=>$model->materialgroupid,
				'materialgroupcode'=>$model->materialgroupcode,
				'description'=>$model->description,
				'parentmatgroupid'=>$model->parentmatgroupid,
				'parentmatgroupcode'=>($model->parentmatgroup!==null)?$model->parentmatgroup->materialgroupcode:"",
				'materialtypeid'=>$model->materialtypeid,
				'materialtypename'=>($model->materialtype!==null)?$model->materialtype->description:"",
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Materialgroup'], $_POST['Materialgroup']['materialgroupid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Materialgroup']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Materialgroup']['materialgroupcode'],'emptymaterialgroupcode','emptystring'),
                array($_POST['Materialgroup']['description'],'emptydescription','emptystring'),
                array($_POST['Materialgroup']['materialtypeid'],'emptymaterialtype','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Materialgroup'];
		if ((int)$_POST['Materialgroup']['materialgroupid'] > 0)
		{
		  $model=$this->loadModel($_POST['Materialgroup']['materialgroupid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->materialgroupcode = $_POST['Materialgroup']['materialgroupcode'];
		  $model->description = $_POST['Materialgroup']['description'];
		  $model->materialtypeid=$_POST['Materialgroup']['materialtypeid'];
		  $model->parentmatgroupid=$_POST['Materialgroup']['parentmatgroupid'];
		  $model->recordstatus = $_POST['Materialgroup']['recordstatus'];
		}
		else
		{
		  $model = new Materialgroup();
		  $model->attributes=$_POST['Materialgroup'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Materialgroup']['materialgroupid']);
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
    $model = Materialgroup::model()->findByPk($data->materialgroupid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	   $parentmatgroup=new Materialgroup('searchwstatus');
	  $parentmatgroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Parentmatgroup']))
		$parentmatgroup->attributes=$_GET['Parentmatgroup'];
      $materialtype=new Materialtype('searchwstatus');
	  $materialtype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialtype']))
		$materialtype->attributes=$_GET['Materialtype'];
		$model=new Materialgroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Materialgroup']))
			$model->attributes=$_GET['Materialgroup'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
				  'parentmatgroup'=>$parentmatgroup,
            'materialtype'=>$materialtype
		));
	}
  
  public function coa($connection,$pdf,$accountid)
	{
		$sql = "select distinct a.materialgroupcode,a.description, c.materialtypecode,a.materialgroupid
				from materialgroup a
left join materialtype c on c.materialtypeid = a.materialtypeid
				where a.parentmatgroupid = ".$accountid;
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		foreach($dataReader as $row)
		{
			$this->pdf->row(array($row['materialgroupcode'],$row['materialtypecode'],
				'    '.$row['description']));
			
			$sql1 = "select count(1)
						from materialgroup a
						where a.parentmatgroupid = ".$row['materialgroupid'];
				$command1=$this->connection->createCommand($sql1);
				$value=$command1->queryscalar();
				if ($value > 0) 
				{
					$this->coa($this->connection,$this->pdf,$row['materialgroupid']);
				}
		}
  }

	public function actionDownload()
  {
	parent::actionDownload();
    $sql = "select distinct a.materialgroupcode,a.description, c.materialtypecode,a.materialgroupid
				from materialgroup a
left join materialtype c on c.materialtypeid = a.materialtypeid	";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.materialgroupid = ".$_GET['id'];
		}
		$sql = $sql . "  order by a.materialgroupcode ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
    $this->pdf->title='Material Group List';
    $this->pdf->AddPage('P');

    $this->pdf->colalign = array('C','C','C','C');
    $this->pdf->setwidths(array(30,30,100));
	$this->pdf->colheader = array('Code','Material Type','Description');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','L','L','L');
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['materialgroupcode'],$row1['materialtypecode'],
          $row1['description']));
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
		$model=Materialgroup::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='materialgroup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
