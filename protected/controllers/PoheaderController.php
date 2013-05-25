<?php

class PoheaderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'poheader';

public $purchasingorg,$purchasinggroup,$supplier,$paymentmethod,$podetail,$prheader,$product,
$unitofmeasure,$currency,$sloc,$tax;

	public function lookupdata()
	{
	  $this->purchasingorg=new Purchasingorg('search');
	  $this->purchasingorg->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasingorg']))
		$this->purchasingorg->attributes=$_GET['Purchasingorg'];

		$this->purchasinggroup=new Purchasinggroup('search');
	  $this->purchasinggroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasinggroup']))
		$this->purchasinggroup->attributes=$_GET['Purchasinggroup'];

		$this->supplier=new Supplier('search');
	  $this->supplier->unsetAttributes();  // clear any default values
	  if(isset($_GET['Supplier']))
		$this->supplier->attributes=$_GET['Supplier'];

      $this->paymentmethod=new Paymentmethod('search');
	  $this->paymentmethod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Paymentmethod']))
		$this->paymentmethod->attributes=$_GET['Paymentmethod'];

		$this->podetail=new Podetail('search');
	  $this->podetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Podetail']))
		$this->podetail->attributes=$_GET['Podetail'];

		$this->lookupdetail();
	}
	
	public function lookupdetail()
	{
	$this->prheader=new Prmaterial('search');
	  $this->prheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Prmaterial']))
		$this->prheader->attributes=$_GET['Prmaterial'];
		
		$this->product=new Product('search');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];

		$this->unitofmeasure=new Unitofmeasure('search');
	  $this->unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$this->unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$this->currency=new Currency('search');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];

		$this->sloc=new Sloc('search');
	  $this->sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$this->sloc->attributes=$_GET['Sloc'];

		$this->tax=new Tax('search');
	  $this->tax->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tax']))
		$this->tax->attributes=$_GET['Tax'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            parent::actionCreate();
	  $this->lookupdata();

		$model=new Poheader;
		$model->recordstatus=Wfgroup::model()->findstatusbyuser('inspo');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (Yii::app()->request->isAjaxRequest)
        {
			if ($model->save()) {
			  echo CJSON::encode(array(
				  'status'=>'success',
				  'poheaderid'=>$model->poheaderid,
				  ));
			  Yii::app()->end();
			}
        }
	}

	public function actionCreatedetail()
	{
	  $this->lookupdetail();

		$podetail=new Podetail;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'currencyid'=>Company::model()->getcurrencyid(),
				'currencyname'=>Company::model()->getcurrencyname(),
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
				'poheaderid'=>$model->poheaderid,
				'purchasinggroupid'=>$model->purchasinggroupid,
				'purchasinggroupcode'=>($model->purchasinggroup!==null)?$model->purchasinggroup->description:"",
				'docdate'=>$model->docdate,
				'addressbookid'=>$model->addressbookid,
				'fullname'=>($model->supplier!==null)?$model->supplier->fullname:"",
				'paymentmethodid'=>$model->paymentmethodid,
				'paycode'=>($model->paymentmethod!==null)?$model->paymentmethod->paycode:"",
				'headernote'=>$model->headernote,
				'postdate'=>$model->postdate,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

	public function actionUpdatedetail()
	{
	  	$this->lookupdetail();

		$id=$_POST['id'];
	  $podetail=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'podetailid'=>$podetail->podetailid,
				'productid'=>$podetail->productid,
				'productname'=>($podetail->product!==null)?$podetail->product->productname:"",
				'poqty'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$podetail->poqty),
				'unitofmeasureid'=>$podetail->unitofmeasureid,
				'uomcode'=>($podetail->unitofmeasure!==null)?$podetail->unitofmeasure->uomcode:"",
				'delvdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($podetail->delvdate)),
				'netprice'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$podetail->netprice),
				'ratevalue'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$podetail->ratevalue),
				'currencyid'=>$podetail->currencyid,
				'currencyname'=>($podetail->currency!==null)?$podetail->currency->currencyname:"",
				'slocid'=>$podetail->slocid,
				'description'=>($podetail->sloc!==null)?$podetail->sloc->description:"",
				'taxid'=>$podetail->taxid,
				'taxcode'=>($podetail->tax!==null)?$podetail->tax->taxcode:"",
				'itemtext'=>$podetail->itemtext,
                'underdelvtol'=>$podetail->underdelvtol,
                'overdelvtol'=>$podetail->overdelvtol,
                'prdetailid'=>$podetail->prdetailid,
                'prno'=>($podetail->prdetail!==null)?(($podetail->prdetail->prheader!==null)?$podetail->prdetail->prheader->prno:""):"",
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Poheader'], $_POST['Poheader']['poheaderid']);
    }

	public function actionWrite()
	{
            parent::actionWrite();
	  if(isset($_POST['Poheader']))
	  {
      $messages = $this->ValidateData(
                array(
				array($_POST['Poheader']['docdate'],'emptydocdate','emptystring'),
				array($_POST['Poheader']['purchasinggroupid'],'emptypurchasinggroup','emptystring'),
            array($_POST['Poheader']['addressbookid'],'emptyaddressbook','emptystring'),
            array($_POST['Poheader']['paymentmethodid'],'emptypaymentmethod','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Poheader'];
		if ((int)$_POST['Poheader']['poheaderid'] > 0)
		{
		  $model=$this->loadModel($_POST['Poheader']['poheaderid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->purchasinggroupid = $_POST['Poheader']['purchasinggroupid'];
		  $model->addressbookid = $_POST['Poheader']['addressbookid'];
          $model->paymentmethodid = $_POST['Poheader']['paymentmethodid'];
		  $model->headernote = $_POST['Poheader']['headernote'];
          $model->docdate = $_POST['Poheader']['docdate'];
		}
		else
		{
		  $model = new Poheader();
		  $model->attributes=$_POST['Poheader'];
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Poheader']['poheaderid']);
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

        public function actionGeneratedetail()
        {
            if(isset($_POST['productid']) & isset($_POST['supplierid']) & isset($_POST['prmaterialid']))
	  {
                $podetail=Prmaterial::model()->findbysql('select * from prmaterial a inner join prheader b on b.prheaderid = a.prheaderid where prmaterialid = '.$_POST['prmaterialid'].
                        ' and productid = '.$_POST['productid'].
                        ' and qty > poqty '.
                        ' and b.prno is not null');
                $pirdetail=Purchinforec::model()->findbyattributes(array('addressbookid'=>$_POST['supplierid'],'productid'=>$_POST['productid']));

                echo CJSON::encode(array(
                'status'=>'success',
				'prdetailid'=>$podetail->prmaterialid,
				'prno'=>($podetail->prheader!==null)?$podetail->prheader->prno:"",
				'productid'=>$podetail->productid,
				'productname'=>($podetail->product!==null)?$podetail->product->productname:"",
				'poqty'=>($podetail->qty - $podetail->poqty),
				'unitofmeasureid'=>$podetail->unitofmeasureid,
				'uomcode'=>($podetail->unitofmeasure!==null)?$podetail->unitofmeasure->uomcode:"",
				'slocid'=>($podetail->prheader!==null?$podetail->prheader->slocid:""),
                    'itemtext'=>$podetail->itemtext,
				'reqdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($podetail->reqdate)),
				'description'=>($podetail->prheader!==null)?$podetail->prheader->sloc->description:"",
                    'underdelvtol'=>($pirdetail!==null)?$pirdetail->underdelvtol:"",
                    'overdelvtol'=>($pirdetail!==null)?$pirdetail->overdelvtol:""));
            Yii::app()->end();
            }
        }

	public function actionWritedetail()
	{
	  if(isset($_POST['Podetail']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Podetail']['productid'],'emptyproduct','emptystring'),
            array($_POST['Podetail']['poqty'],'emptyqty','emptystring'),
            array($_POST['Podetail']['unitofmeasureid'],'emptyunitofmeasure','emptystring'),
            array($_POST['Podetail']['netprice'],'emptynetprice','emptystring'),
            array($_POST['Podetail']['currencyid'],'emptycurrency','emptystring'),
            array($_POST['Podetail']['slocid'],'emptysloc','emptystring'),
            array($_POST['Podetail']['taxid'],'emptytax','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Podetail'];
		if ((int)$_POST['Podetail']['podetailid'] > 0)
		{
		  $model=Podetail::model()->findbyPK($_POST['Podetail']['podetailid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->poheaderid = $_POST['Podetail']['poheaderid'];
		  $model->productid = $_POST['Podetail']['productid'];
		  $model->poqty = $_POST['Podetail']['poqty'];
		  $model->unitofmeasureid = $_POST['Podetail']['unitofmeasureid'];
		  $model->delvdate = $_POST['Podetail']['delvdate'];
		  $model->netprice = $_POST['Podetail']['netprice'];
		  $model->currencyid = $_POST['Podetail']['currencyid'];
		  $model->slocid = $_POST['Podetail']['slocid'];
		  $model->taxid = $_POST['Podetail']['taxid'];
		  $model->itemtext = $_POST['Podetail']['itemtext'];
		  $model->underdelvtol = $_POST['Podetail']['underdelvtol'];
		  $model->prdetailid = $_POST['Podetail']['prdetailid'];
		  $model->overdelvtol = $_POST['Podetail']['overdelvtol'];
		  $model->ratevalue = $_POST['Podetail']['ratevalue'];
		}
		else
		{
		  $model = new Podetail();
		  $model->attributes=$_POST['Podetail'];
		$this->olddata = $model->attributes;
			$this->useraction='new';
		}
		 $this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Podetail']['podetailid']);
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

	public function actionDeleteDetail()
	{
		  $model=Podetail::model()->findbyPK($_POST['id']);
		  $model->delete();
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	public function actionApprove()
	{
            parent::actionApprove();
			//$model=$this->loadModel($ids);
                    $a = Yii::app()->user->name;
			$connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call ApprovePO(:vid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
				$command->bindvalue(':vlastupdateby', $a,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->GetSMessage('insertsuccess');
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				  $transaction->rollBack();
				  $this->GetMessage($e->getMessage());
			  }
        Yii::app()->end();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Poheader::model()->findByPk($data->poheaderid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            parent::actionIndex();
	  		$this->lookupdata();

		$model=new Poheader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Poheader']))
			$model->attributes=$_GET['Poheader'];
			
			if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'purchasingorg'=>$this->purchasingorg,
			'purchasinggroup'=>$this->purchasinggroup,
            'paymentmethod'=>$this->paymentmethod,
			'supplier'=>$this->supplier,
			'podetail'=>$this->podetail,
			'prheader'=>$this->prheader,
			'product'=>$this->product,
			'unitofmeasure'=>$this->unitofmeasure,
			'currency'=>$this->currency,
			'sloc'=>$this->sloc,
			'tax'=>$this->tax,
                    'podetail'=>$this->podetail
		));
	}

	public function actionIndexDetail()
	{
	  $this->lookupdetail();

		$podetail=new Podetail('searchbypoheaderid');
		$podetail->unsetAttributes();  // clear any default values
		if(isset($_GET['Podetail']))
			$podetail->attributes=$_GET['Podetail'];
if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('indexdetail',array(
			'podetail'=>$podetail,
			'prheader'=>$this->prheader,
					'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure,
					'sloc'=>$this->sloc,
					'currency'=>$this->currency,
					'tax'=>$this->tax
		));
	}
    
    public function actionDownload()
	{
	parent::actionDownload();
		if ($_GET['id'] !== '0') {
				$sql = "update poheader set printke = ifnull(printke,0) + 1 
	  where poheaderid = ".$_GET['id'];
		} else
		{
		$sql = "update poheader set printke = ifnull(printke,0) + 1";
		}
	  $command=$this->connection->createCommand($sql);
	  $command->execute();
	  $sql = "select b.fullname, a.pono, a.docdate,b.addressbookid,a.poheaderid,c.paymentname,a.headernote,a.printke
      from poheader a
      left join addressbook b on b.addressbookid = a.addressbookid
      left join paymentmethod c on c.paymentmethodid = a.paymentmethodid ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.poheaderid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
$this->pdf->isheader=false;
	  $this->pdf->title='Purchase Order';
	  $this->pdf->AddPage('P');
	  $this->pdf->setFont('Arial','B',8);
	  $this->pdf->isprint=true;

    foreach($dataReader as $row)
    {
	$this->pdf->printke = $row['printke'];
      $sql1 = "select b.addresstypename, a.addressname, c.cityname, a.phoneno, a.faxno
        from address a
        left join addresstype b on b.addresstypeid = a.addresstypeid
        left join city c on c.cityid = a.cityid
        where addressbookid = ".$row['addressbookid'].
        " order by addressid ".
        " limit 1";
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      foreach($dataReader1 as $row1)
      {
	  $sql2 = "select a.addresscontactname, a.phoneno, a.mobilephone
        from addresscontact a
        where addressbookid = ".$row['addressbookid'].
        " order by addresscontactid ".
        " limit 1";
      $command2=$this->connection->createCommand($sql2);
      $dataReader2=$command2->queryAll();
	  $contact = '';

      foreach($dataReader2 as $row2)
      {
		$contact = $row2['addresscontactname'];
	  }
        $this->pdf->setFont('Arial','B',8);
        $this->pdf->Rect(10,60,196,30);
        $this->pdf->setFont('Arial','',8);
        $this->pdf->text(15,65,'Supplier');$this->pdf->text(40,65,': '.$row['fullname']);
        $this->pdf->text(15,70,'Attention');$this->pdf->text(40,70,': '.$contact);
        $this->pdf->text(15,75,'Address');$this->pdf->text(40,75,': '.$row1['addressname']);
        $this->pdf->text(15,80,'Phone');$this->pdf->text(40,80,': '.$row1['phoneno']);
        $this->pdf->text(15,85,'Fax');$this->pdf->text(40,85,': '.$row1['faxno']);
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->text(120,65,'Purchase Order No ');$this->pdf->text(150,65,$row['pono']);
      $this->pdf->text(120,70,'PO Date ');$this->pdf->text(150,70,date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));

      }

      $sql1 = "select a.poheaderid,c.uomcode,a.poqty,a.delvdate,a.netprice,(poqty * netprice + (taxvalue * poqty * netprice) / 100) as total,b.productname,
        d.symbol,e.taxvalue,a.itemtext
        from podetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        left join currency d on d.currencyid = a.currencyid
        left join tax e on e.taxid = a.taxid
        where poheaderid = ".$row['poheaderid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $total = 0;
      $this->pdf->sety($this->pdf->gety()+80);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(15,10,50,24,23,26,18,30));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
	  $this->pdf->colheader = array('Qty','Units','Item', 'Unit Price','Tax','Total','Delivery Date','Remarks');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('R','C','L','R','R','R','R','L');
	  $symbol = '';
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array(
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['poqty']),
			$row1['uomcode'],
			iconv("UTF-8", "ISO-8859-1", $row1['productname']),
            Yii::app()->numberFormatter->formatCurrency($row1['netprice'], iconv("UTF-8", "ISO-8859-1",$row1['symbol'])),
			Yii::app()->numberFormatter->formatCurrency(($row1['taxvalue']*$row1['netprice']*$row1['poqty'])/100,  iconv("UTF-8", "ISO-8859-1",$row1['symbol'])),
            Yii::app()->numberFormatter->formatCurrency($row1['total'],  iconv("UTF-8", "ISO-8859-1",$row1['symbol'])),
			date(Yii::app()->params['dateviewfromdb'], strtotime($row1['delvdate'])),
			$row1['itemtext']));
        $total = $row1['total'] + $total;
$symbol = $row1['symbol'];
      }
	  $this->pdf->row(array('','','','','Total',
            Yii::app()->numberFormatter->formatCurrency($total, iconv("UTF-8", "ISO-8859-1",$symbol)),'',''));
	  $this->pdf->title='';
	  $this->pdf->checknewpage(100);
		$this->pdf->sety($this->pdf->gety()+5);
	  
	 $this->pdf->setFont('Arial','',7);
	 $company = Company::model()->findbysql('select * from company limit 1');
	 $this->pdf->CheckPageBreak(60);
	  $this->pdf->sety($this->pdf->gety()+5);
      $this->pdf->text(10,$this->pdf->gety()+5,'Thanking you and assuring our best attention we remain.');
      $this->pdf->text(10,$this->pdf->gety()+10,'Sincerrely Yours');
      $this->pdf->text(10,$this->pdf->gety()+15,$company->companyname);$this->pdf->text(135,$this->pdf->gety()+15,'Confirmed and Accepted by Supplier');
	  $this->pdf->setFont('Arial','B',8);
      $this->pdf->text(10,$this->pdf->gety()+35,'');
      $this->pdf->text(10,$this->pdf->gety()+36,'____________________');$this->pdf->text(135,$this->pdf->gety()+36,'__________________________');
	  $this->pdf->setFont('Arial','',7);
      $this->pdf->text(10,$this->pdf->gety()+40,'Director');
      $this->pdf->text(10,$this->pdf->gety()+45,'cc : Finance & Purchasing Manager');

	  $this->pdf->setFont('Arial','BU',7);
	  $this->pdf->text(10,$this->pdf->gety()+55,'#Note: Mohon tidak memberikan gift atau uang kepada staff kami#');
    }
	  $this->pdf->Output();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Poheader::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Podetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='poheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
