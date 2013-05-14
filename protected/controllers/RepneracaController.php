<?php

class RepneracaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'repneraca';

public $account;

	public function lookupdata()
	{
	  $this->account=new Account('searchwstatus');
	  $this->account->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->account->attributes=$_GET['Account'];
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
      $this->lookupdata();
		$model=new Repneraca;

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
      $this->lookupdata();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	  $model=$this->loadModel($_POST['id']);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
				'repneracaid'=>$model->repneracaid,
				'accountid'=>$model->accountid,
                'accountname'=>($model->account!==null)?$model->account->accountname:"",
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

     public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Repneraca'], $_POST['Repneraca']['repneracaid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Repneraca']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Repneraca']['accountid'],'hmsxemptyrepneracaname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Repneraca'];
		if ((int)$_POST['Repneraca']['repneracaid'] > 0)
		{
		  $model=$this->loadModel($_POST['Repneraca']['repneracaid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->accountid = $_POST['Repneraca']['accountid'];
		  $model->isdebet = $_POST['Repneraca']['isdebet'];
		  $model->recordstatus = $_POST['Repneraca']['recordstatus'];
		}
		else
		{
		  $model = new Repneraca();
		  $model->attributes=$_POST['Repneraca'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Repneraca']['repneracaid']);
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
	
	protected function gridData($data,$row)
  {     
    $model = Repneraca::model()->findByPk($data->repneracaid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
      $this->lookupdata();
    $model=new Repneraca('search');
    $model->unsetAttributes();  // clear any default values
      if(isset($_GET['Repneraca']))
        $model->attributes=$_GET['Repneraca'];

if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
            'model'=>$model,
                    'account'=>$this->account
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
			  $model=Repneraca::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Repneraca();
			  }
			  $model->repneracaid = (int)$data[0];
			  $model->repneracaname = $data[1];
			  $model->recordstatus = (int)$data[2];
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
  
  private $subtotal = 0;
  private $sublast = 0;
  
  private function coa($connection,$account,$dateto)
  {
	$sql = "select ifnull(count(1),0) as hitung
			from account a
			where a.parentaccountid = ".$account;
	$command=$connection->createCommand($sql);
	$dataReader=$command->query();
	while(($row=$dataReader->read())!==false) {
		if ($row['hitung'] > 0)
		{
			$sql1 = "select a.accountid,a.parentaccountid
				from account a
				where a.parentaccountid = ".$account;
			$command1=$connection->createCommand($sql1);
			$dataReader1=$command1->query();
			while(($row1=$dataReader1->read())!==false) {
				$this->coa($connection,$row1['accountid'],$dateto);
			}
		}
		else
		{
			$sql1 = "select z.accountid, ifnull(sum(ifnull(debit,0)),0) - ifnull(sum(ifnull(credit,0)),0) as angka
				from genledger z
				inner join account y on y.accountid = z.accountid
				where z.accountid = ".$account." and date(postdate) between concat(year('".$dateto."'),'-01-01') and '".$_POST['dateto']."'";
			$command1=$connection->createCommand($sql1);
			$dataReader1=$command1->query();
			while(($row1=$dataReader1->read())!==false) {
				$this->subtotal = $this->subtotal + $row1['angka'];
			}		
		}
	}
  }

  public function actionDownload()
  {
    parent::actionDownload();
    if (isset($_POST['dateto']))
	  {
	  $this->pdf->title='Laporan Neraca (Rp)';
	  $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial','',12);
	$this->pdf->Cell(0,10,'Pada Tanggal : '. date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['dateto'])) . ' dan ' .
		date(Yii::app()->params['dateviewfromdb'],strtotime(date('Y',strtotime($_POST['dateto'] . ' - 1 year')).'-12-31'))
		,0,0,'C');

    // menuliskan tabel
    $connection=Yii::app()->db;
    $sql = "select a.accountid, b.accountcode, b.accountname,a.isdebet,b.parentaccountid
		from repneraca a
		inner join account b on b.accountid = a.accountid ";
	$command=$connection->createCommand($sql);

    $this->pdf->setFont('Arial','',8);
	$this->pdf->sety($this->pdf->gety()+20);
    $this->pdf->colalign = array('C','C','C');
      $this->pdf->setwidths(array(80,40,40));
      $this->pdf->colheader = array('Account Name',date(Yii::app()->params['dateviewfromdb'],strtotime($_POST['dateto'])),
		date(Yii::app()->params['dateviewfromdb'],strtotime(date('Y',strtotime($_POST['dateto'] . ' - 1 year')).'-12-31')));
	  $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','R','R');
    $i=0;$parent = '';

    $dataReader=$command->query();
    // calling read() repeatedly until it returns false
    while(($row=$dataReader->read())!==false) {
        $i=$i+1;
		$this->subtotal = $this->coa($connection,$row['accountid'],$_POST['dateto']);
		$this->sublast = $this->coa($connection,$row['accountid'],date('Y',strtotime($_POST['dateto'] . ' - 1 year')).'-12-31');
		if ($row['parentaccountid'] == '')
		{
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->row(array($row['accountname'],Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$this->subtotal),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$this->sublast)));
		}
		else
		{
				$this->pdf->setFont('Arial','',8);			
				$this->pdf->row(array('   '.$row['accountname'],Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$this->subtotal),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$this->sublast)));
		}
    }
    // me-render ke browser
    $this->pdf->Output();
      }
  }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Repneraca::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='repneraca-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
