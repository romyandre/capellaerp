<?php

class ProductaccountController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'productaccount';

	public $product,$expenseaccount,$salesaccount,$salesretaccount,$salesitemaccount,
	$purcretaccount,$unbilledaccount;

	public function lookupdata()
	{
	  $this->product=new Product('searchwstatus');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];

		$this->expenseaccount=new Account('searchwstatus');
	  $this->expenseaccount->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->expenseaccount->attributes=$_GET['Account'];

		$this->salesaccount=new Account('searchwstatus');
	  $this->salesaccount->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->salesaccount->attributes=$_GET['Account'];
		
		$this->salesretaccount=new Account('searchwstatus');
	  $this->salesretaccount->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->salesretaccount->attributes=$_GET['Account'];
		
		$this->salesitemaccount=new Account('searchwstatus');
	  $this->salesitemaccount->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->salesitemaccount->attributes=$_GET['Account'];
		
		$this->purcretaccount=new Account('searchwstatus');
	  $this->purcretaccount->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->purcretaccount->attributes=$_GET['Account'];
		
				$this->unbilledaccount=new Account('searchwstatus');
	  $this->unbilledaccount->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->unbilledaccount->attributes=$_GET['Account'];

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();

		$model=new Productaccount;

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
				'productaccountid'=>$model->productaccountid,
				'productid'=>$model->productid,
				'productname'=>($model->product!==null)?$model->product->productname:"",
				'expenseaccount'=>$model->expenseaccount,
				'expenseaccountno'=>($model->expenseaccount0!==null)?$model->expenseaccount0->accountname:"",
				'salesaccount'=>$model->expenseaccount,
				'salesaccountno'=>($model->salesaccount0!==null)?$model->salesaccount0->accountname:"",
				'salesretaccount'=>$model->salesretaccount,
				'salesretaccountno'=>($model->salesretaccount0!==null)?$model->salesretaccount0->accountname:"",
				'salesitemaccount'=>$model->salesitemaccount,
				'salesitemaccountno'=>($model->salesitemaccount0!==null)?$model->salesitemaccount0->accountname:"",
				'purcretaccount'=>$model->purcretaccount,
				'purcretaccountno'=>($model->purcretaccount0!==null)?$model->purcretaccount0->accountname:"",
				'unbilledaccount'=>$model->unbilledaccount,
				'unbilledaccountno'=>($model->unbilledaccount0!==null)?$model->unbilledaccount0->accountname:"",
				'isactiva'=>$model->isactiva,
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Productaccount'], $_POST['Productaccount']['productaccountid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Productaccount']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Productaccount']['productid'],'emptyproductid','emptystring'),
                array($_POST['Productaccount']['expenseaccount'],'emptyaccount','emptystring'),
                array($_POST['Productaccount']['salesaccount'],'emptyaccount','emptystring'),
                array($_POST['Productaccount']['salesretaccount'],'emptyaccount','emptystring'),
                array($_POST['Productaccount']['salesitemaccount'],'emptyaccount','emptystring'),
                array($_POST['Productaccount']['purcretaccount'],'emptyaccount','emptystring'),
                array($_POST['Productaccount']['unbilledaccount'],'emptyaccount','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Productaccount']['productaccountid'] > 0)
		{
		  $model=$this->loadModel($_POST['Productaccount']['productaccountid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->productid = $_POST['Productaccount']['productid'];
		  $model->expenseaccount = $_POST['Productaccount']['expenseaccount'];
		  $model->salesaccount = $_POST['Productaccount']['salesaccount'];
		  $model->salesretaccount = $_POST['Productaccount']['salesretaccount'];
		  $model->salesitemaccount = $_POST['Productaccount']['salesitemaccount'];
		  $model->purcretaccount = $_POST['Productaccount']['purcretaccount'];
		  $model->unbilledaccount = $_POST['Productaccount']['unbilledaccount'];
		  $model->isactiva = $_POST['Productaccount']['isactiva'];
		}
		else
		{
		  $model = new Productaccount();
		  $model->attributes=$_POST['Productaccount'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Productaccount']['productaccountid']);
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
	
	protected function gridData($data,$row)
  {     
    $model = Productaccount::model()->findByPk($data->productaccountid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();
		$model=new Productaccount('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productaccount']))
			$model->attributes=$_GET['Productaccount'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
				  'product'=>$this->product,
				  'expenseaccount'=>$this->expenseaccount,
				  'salesaccount'=>$this->salesaccount,
				  'salesretaccount'=>$this->salesretaccount,
				  'salesitemaccount'=>$this->salesitemaccount,
				  'purcretaccount'=>$this->purcretaccount,	
					'unbilledaccount'=>$this->unbilledaccount
		));
	}

  public function actionDownload()
  {
    parent::actionDownload();
    $sql = "select c.productname, concat(b.accountcode,'-',b.accountname) as expenseaccount,
	concat(d.accountcode,'-',d.accountname) as salesaccount,
	concat(e.accountcode,'-',e.accountname) as salesretaccount,
	concat(f.accountcode,'-',f.accountname) as salesitemaccount,
	concat(g.accountcode,'-',g.accountname) as purcretaccount,
	concat(h.accountcode,'-',h.accountname) as unbilledaccount,
	isactiva
        from productaccount a
        left join account b on b.accountid = a.expenseaccount 
		left join product c on c.productid = a.productid 
		left join account d on d.accountid = a.salesaccount 
		left join account e on e.accountid = a.salesretaccount 
		left join account f on f.accountid = a.salesitemaccount
		left join account g on g.accountid = a.purcretaccount
		left join account h on h.accountid = a.unbilledaccount ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.productaccountid = ".$_GET['id'];
		}
		$sql=$sql . " order by a.productid ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

	  $this->pdf->title='Product Account List';
	  $this->pdf->AddPage('L');
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    $this->pdf->colalign = array('C','C','C','C','C','C','C','C');
    $this->pdf->setwidths(array(70,30,30,30,30,30,30,15,10,10));
	$this->pdf->colheader= array('Material Name','Expense Account','Sales Account',
		'Sales Ret Account','Sales Item Account','Purch Ret Account','Unbilled Account',
		'Activa');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','L','L','L','L','L','L','C');
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['productname'],$row1['expenseaccount'],
	  $row1['salesaccount'],$row1['salesretaccount'],$row1['salesitemaccount'],
	  $row1['purcretaccount'],$row1['unbilledaccount'],
	  $row1['isactiva']!=='0'?'V':''));
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
		$model=Productaccount::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='productconversion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
