<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container" id="page">
	<?php 
	$this->widget('application.extensions.mbmenu.MbMenu',array(
            'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index'),'image'=>Yii::app()->request->baseUrl.'/images/home.png'),
                array('label'=>'System','visible'=>Groupmenu::model()->GetReadMenu('system'),
					'items'=>array(
						array('label'=>'Authentication','visible'=>Groupmenu::model()->GetReadMenu('objectauth'),
							'items'=>array(
								array('label'=>'User Access', 'url'=>array('/useraccess/index'),'visible'=>Groupmenu::model()->GetReadMenu('useraccess')),
								array('label'=>'Menu Access', 'url'=>array('/menuaccess/index'),'visible'=>Groupmenu::model()->GetReadMenu('menuaccess')),
								array('label'=>'Menu Object', 'url'=>array('/menuauth/index'),'visible'=>Groupmenu::model()->GetReadMenu('menuauth')),
								array('label'=>'Group Access', 'url'=>array('/groupaccess/index'),'visible'=>Groupmenu::model()->GetReadMenu('groupaccess')),
								array('label'=>'Group Menu Object', 'url'=>array('/groupmenuauth/index'),'visible'=>Groupmenu::model()->GetReadMenu('groupmenuauth')),
								array('label'=>'User Group', 'url'=>array('/usergroup/index'),'visible'=>Groupmenu::model()->GetReadMenu('usergroup')),
								array('label'=>'Group Menu', 'url'=>array('/groupmenu/index'),'visible'=>Groupmenu::model()->GetReadMenu('groupmenu')),
								array('label'=>'User Menu', 'url'=>array('/usermenu/index'),'visible'=>Groupmenu::model()->GetReadMenu('usermenu')),
							)
						),
						array('label'=>'Company', 'url'=>array('/company/index'),'visible'=>Groupmenu::model()->GetReadMenu('company')),
						array('label'=>'Transaction Log', 'url'=>array('/translog/index'),'visible'=>Groupmenu::model()->GetReadMenu('translog')),
						array('label'=>'Transaction Lock', 'url'=>array('/translock/index'),'visible'=>Groupmenu::model()->GetReadMenu('translock')),
						array('label'=>'Specific Number Range Object', 'url'=>array('/snro/index'),'visible'=>Groupmenu::model()->GetReadMenu('snro')),
						array('label'=>'Detail of Specific Number Range Object', 'url'=>array('/snrodet/index'),'visible'=>Groupmenu::model()->GetReadMenu('snrodet')),
						array('label'=>'Workflow', 'url'=>array('/workflow/index'),'visible'=>Groupmenu::model()->GetReadMenu('workflow')),
						array('label'=>'Workflow Group', 'url'=>array('/wfgroup/index'),'visible'=>Groupmenu::model()->GetReadMenu('wfgroup')),
						array('label'=>'Workflow Status', 'url'=>array('/wfstatus/index'),'visible'=>Groupmenu::model()->GetReadMenu('wfstatus')),
						array('label'=>'Parameter', 'url'=>array('/parameter/index'),'visible'=>Groupmenu::model()->GetReadMenu('parameter')),
						array('label'=>'Language', 'url'=>array('/language/index'),'visible'=>Groupmenu::model()->GetReadMenu('language')),
						array('label'=>'Messages', 'url'=>array('/messages/index'),'visible'=>Groupmenu::model()->GetReadMenu('messages')),
						array('label'=>'Catalog Translation', 'url'=>array('/catalogsys/index'),'visible'=>Groupmenu::model()->GetReadMenu('catalogsys')),
					)
				),
				array('label'=>'Common','visible'=>Groupmenu::model()->GetReadMenu('common'),
					'items'=>array(
						array('label'=>'Citizen','visible'=>Groupmenu::model()->GetReadMenu('citizen'),
							'items'=>array(
								array('label'=>'Country', 'url'=>array('/country/index'),'visible'=>Groupmenu::model()->GetReadMenu('country')),
								array('label'=>'Province', 'url'=>array('/province/index'),'visible'=>Groupmenu::model()->GetReadMenu('province')),
								array('label'=>'City', 'url'=>array('/city/index'),'visible'=>Groupmenu::model()->GetReadMenu('city')),
								array('label'=>'Subdistrict', 'url'=>array('/subdistrict/index'),'visible'=>Groupmenu::model()->GetReadMenu('subdistrict')),
								array('label'=>'Sub Subdistrict', 'url'=>array('/kelurahan/index'),'visible'=>Groupmenu::model()->GetReadMenu('kelurahan')),
							)
						),
						array('label'=>'Currency', 'url'=>array('/currency/index'),'visible'=>Groupmenu::model()->GetReadMenu('currency')),
						array('label'=>'Address Type', 'url'=>array('/addresstype/index'),'visible'=>Groupmenu::model()->GetReadMenu('addresstype')),
						array('label'=>'Contact Type', 'url'=>array('/contacttype/index'),'visible'=>Groupmenu::model()->GetReadMenu('contacttype')),
						array('label'=>'Identity Type', 'url'=>array('/identitytype/index'),'visible'=>Groupmenu::model()->GetReadMenu('identitytype')),
						array('label'=>'Rome Type', 'url'=>array('/romawi/index'),'visible'=>Groupmenu::model()->GetReadMenu('romawi')),
						array('label'=>'Industry', 'url'=>array('/industry/index'),'visible'=>Groupmenu::model()->GetReadMenu('industry')),
						array('label'=>'Plant', 'url'=>array('/plant/index'),'visible'=>Groupmenu::model()->GetReadMenu('plant')),
						array('label'=>'Storage Location', 'url'=>array('/sloc/index'),'visible'=>Groupmenu::model()->GetReadMenu('sloc')),
						array('label'=>'Unit of Measure', 'url'=>array('/unitofmeasure/index'),'visible'=>Groupmenu::model()->GetReadMenu('unitofmeasure')),
						array('label'=>'Material Master','visible'=>Groupmenu::model()->GetReadMenu('materialmaster'),
							'items'=>array(
								array('label'=>'Material Type', 'url'=>array('/materialtype/index'),'visible'=>Groupmenu::model()->GetReadMenu('materialtype')),
								array('label'=>'Material Group', 'url'=>array('/materialgroup/index'),'visible'=>Groupmenu::model()->GetReadMenu('materialgroup')),
								array('label'=>'Material Status', 'url'=>array('/materialstatus/index'),'visible'=>Groupmenu::model()->GetReadMenu('materialstatus')),
								array('label'=>'Ownership', 'url'=>array('/ownership/index'),'visible'=>Groupmenu::model()->GetReadMenu('ownership')),
								array('label'=>'Material Main Data', 'url'=>array('/product/index'),'visible'=>Groupmenu::model()->GetReadMenu('product')),
								array('label'=>'Material Detail Data', 'url'=>array('/productbasic/index'),'visible'=>Groupmenu::model()->GetReadMenu('productbasic')),
								array('label'=>'Material Purchasing Data', 'url'=>array('/productpurchase/index'),'visible'=>Groupmenu::model()->GetReadMenu('productpurchase')),
								array('label'=>'Material Storage Location Data', 'url'=>array('/productplant/index'),'visible'=>Groupmenu::model()->GetReadMenu('productplant')),
								array('label'=>'Material Unit Conversion', 'url'=>array('/productconversion/index'),'visible'=>Groupmenu::model()->GetReadMenu('productconversion')),
							)
						),
						array('label'=>'Address Book', 'url'=>array('/addressbook/index'),'visible'=>Groupmenu::model()->GetReadMenu('addressbook')),
						array('label'=>'Supplier', 'visible'=>Groupmenu::model()->GetReadMenu('supplier'),'url'=>array('/supplier/index')),
						array('label'=>'Customer - scu','visible'=>Groupmenu::model()->GetReadMenu('customer'),'url'=>array('/customer/index')),
						array('label'=>'Insurance - cins','url'=>array('/insurance/index'),'visible'=>Groupmenu::model()->GetReadMenu('insurance')),
						array('label'=>'Bank - cobn','url'=>array('/bank/index'),'visible'=>Groupmenu::model()->GetReadMenu('bank')),							
					)
				),
				array('label'=>'Accounting','visible'=>Groupmenu::model()->GetReadMenu('accounting'),
					'items'=>array(
						array('label'=>'Accounting Period', 'url'=>array('/accperiod/index'),'visible'=>Groupmenu::model()->GetReadMenu('accperiod')),
						array('label'=>'Account Type', 'url'=>array('/accounttype/index'),'visible'=>Groupmenu::model()->GetReadMenu('accounttype')),
						array('label'=>'Payment Method', 'url'=>array('/paymentmethod/index'),'visible'=>Groupmenu::model()->GetReadMenu('paymentmethod')),
						array('label'=>'Tax', 'url'=>array('/tax/index'),'visible'=>Groupmenu::model()->GetReadMenu('tax')),
						array('label'=>'Chart of Account', 'url'=>array('/account/index'),'visible'=>Groupmenu::model()->GetReadMenu('account')),
						array('label'=>'General Journal', 'visible'=>Groupmenu::model()->GetReadMenu('reportgl'),
									'items'=>array(
										array('label'=>'General Journal - agj', 'url'=>array('/genjournal/index'),'visible'=>Groupmenu::model()->GetReadMenu('genjournal')),
										array('label'=>'Report General Journal - agjrep', 'url'=>array('/reportgl/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportgl')),
									)
								),
						array('label'=>'Account Payable', 'visible'=>Groupmenu::model()->GetReadMenu('ap'),
									'items'=>array(
												array('label'=>'Invoice - aiap', 'visible'=>Groupmenu::model()->GetReadMenu('invoiceap'),'url'=>array('/invoiceap/index')),
												array('label'=>'Report Invoice - agjrep', 'visible'=>Groupmenu::model()->GetReadMenu('repinvap'),'url'=>array('/repinvap/index')),
												array('label'=>'Request Payment Report - arprp', 'visible'=>Groupmenu::model()->GetReadMenu('repreqpay'),'url'=>array('/repreqpay/index')),
												array('label'=>'Realization Payment Report - arprr', 'visible'=>Groupmenu::model()->GetReadMenu('reprealpay'),'url'=>array('/reprealpay/index')),
												array('label'=>'VAT Input Report - arvir', 'visible'=>Groupmenu::model()->GetReadMenu('repvatinput'),'url'=>array('/repvatinput/index')),
									)
								),
						array('label'=>'Account Receivable', 'visible'=>Groupmenu::model()->GetReadMenu('ar'),
									'items'=>array(
												array('label'=>'Invoice - aiar', 'visible'=>Groupmenu::model()->GetReadMenu('invoicear'),'url'=>array('/invoicear/index')),
												array('label'=>'Report Invoice - agjrep', 'visible'=>Groupmenu::model()->GetReadMenu('repinvar'),'url'=>array('/repinvar/index')),
												array('label'=>'Customer Tax - aiar', 'visible'=>Groupmenu::model()->GetReadMenu('fakturpajak'),'url'=>array('/fakturpajak/index')),
												array('label'=>'VAT Output Report - arvout', 'visible'=>Groupmenu::model()->GetReadMenu('repvatoutput'),'url'=>array('/repvatoutput/index')),
									)
								),
						array('label'=>'Cash / Bank', 'visible'=>Groupmenu::model()->GetReadMenu('cashbank'),
									'items'=>array(
										array('label'=>'Cash / Bank Receipt', 'visible'=>Groupmenu::model()->GetReadMenu('repcbin'),									
											'items'=>array(
												array('label'=>'Cash / Bank Receipt - cbin', 'visible'=>Groupmenu::model()->GetReadMenu('cbin'),'url'=>array('/cashbankin/index')),
												array('label'=>'Report Cash / Bank Receipt - repcbin', 'visible'=>Groupmenu::model()->GetReadMenu('repcbin'),'url'=>array('/repcbin/index')),
											)
										),
										array('label'=>'Cash / Bank Payment', 'visible'=>Groupmenu::model()->GetReadMenu('repcbout'),									
											'items'=>array(
												array('label'=>'Cash / Bank Payment - cbout', 'visible'=>Groupmenu::model()->GetReadMenu('cbout'),'url'=>array('/cashbankout/index')),
												array('label'=>'Report Cash / Bank Payment - repcbout', 'visible'=>Groupmenu::model()->GetReadMenu('repcbout'),'url'=>array('/repcbout/index')),
											)
										),
										array('label'=>'Cash / Bank List Report - cbcl', 'visible'=>Groupmenu::model()->GetReadMenu('repcashbank'),'url'=>array('/repcashbank/index')),
										array('label'=>'Daily Transaction Report - cbdtr', 'visible'=>Groupmenu::model()->GetReadMenu('repdaily'),'url'=>array('/repdaily/index')),
										array('label'=>'Sundry Debtor Report - cbsdr', 'visible'=>Groupmenu::model()->GetReadMenu('repsundry'),'url'=>array('/repsundry/index')),
										array('label'=>'Monthly Sales Report - cbmsr', 'visible'=>Groupmenu::model()->GetReadMenu('repsales'),'url'=>array('/repsales/index')),
										array('label'=>'Reconciliation Bank Report - cbrbr', 'visible'=>Groupmenu::model()->GetReadMenu('reprekonbank'),'url'=>array('/reprekonbank/index')),
									)
								),
						array('label'=>'Reports','visible'=>!Yii::app()->user->isGuest,
									'items'=>array(					
										array('label'=>'General Ledger', 'url'=>array('/genledger/index'),'visible'=>Groupmenu::model()->GetReadMenu('genledger')),
										array('label'=>'VAT In', 'url'=>array('/reportppnmasuk/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportppnmasuk')),
										array('label'=>'VAT Out', 'url'=>array('/reportppnkeluar/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportppnkeluar')),
										array('label'=>'Profit / Loss (standard)  - ','url'=>array('/repprofitloss/index'),	'visible'=>Groupmenu::model()->GetReadMenu('repprofitloss')),
										array('label'=>'Balance Sheet (standard)','url'=>array('/repneraca/index'),	'visible'=>Groupmenu::model()->GetReadMenu('repneraca')),
									)
								),
						)
				),
				array('label'=>'Human Resource','visible'=>Groupmenu::model()->GetReadMenu('hr'),
							'items'=>array(
								array('label'=>'Organization Management','visible'=>Groupmenu::model()->GetReadMenu('orgmanagement'),
									'items'=>array(
										array('label'=>'Position - hompo', 'url'=>array('/position/index'),'visible'=>Groupmenu::model()->GetReadMenu('position')),
										array('label'=>'Level - holo', 'url'=>array('/levelorg/index'),'visible'=>Groupmenu::model()->GetReadMenu('levelorg')),
										array('label'=>'Jobs - hoos', 'url'=>array('/jobs/index'),'visible'=>Groupmenu::model()->GetReadMenu('jobs')),
										array('label'=>'Organization Structure - homjo', 'url'=>array('/orgstructure/index'),'visible'=>Groupmenu::model()->GetReadMenu('orgstructure')),
									)
								),
								array('label'=>'Personnel Management','visible'=>Groupmenu::model()->GetReadMenu('hrmp1'),
									'items'=>array(
										array('label'=>'Master Personnel','visible'=>Groupmenu::model()->GetReadMenu('hrmp1'),
											'items'=>array(
												array('label'=>'Family Relation - hrmfr', 'url'=>array('/familyrelation/index'),'visible'=>Groupmenu::model()->GetReadMenu('familyrelation')),
												array('label'=>'Occupation - hmoc', 'url'=>array('/occupation/index'),'visible'=>Groupmenu::model()->GetReadMenu('occupation')),
												array('label'=>'Sex - hmsx', 'url'=>array('/sex/index'),'visible'=>Groupmenu::model()->GetReadMenu('sex')),
												array('label'=>'Religion - hmre', 'url'=>array('/religion/index'),'visible'=>Groupmenu::model()->GetReadMenu('religion')),
												array('label'=>'Education - hrme', 'url'=>array('/education/index'),'visible'=>Groupmenu::model()->GetReadMenu('education')),
												array('label'=>'Education Major - hrmem', 'url'=>array('/educationmajor/index'),'visible'=>Groupmenu::model()->GetReadMenu('educationmajor')),
												array('label'=>'Marital Status - hmms', 'url'=>array('/maritalstatus/index'),'visible'=>Groupmenu::model()->GetReadMenu('maritalstatus')),
												array('label'=>'Employee Type - hrmet', 'url'=>array('/employeetype/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeetype')),
												array('label'=>'Language Value - hmlv', 'url'=>array('/languagevalue/index'),'visible'=>Groupmenu::model()->GetReadMenu('languagevalue')),
												array('label'=>'SP Letter - hmsp', 'url'=>array('/splettertype/index'),'visible'=>Groupmenu::model()->GetReadMenu('splettertype')),
											)
										),
										array('label'=>'Employee - hee', 'url'=>array('/employee/index'),'visible'=>Groupmenu::model()->GetReadMenu('employee')),
										array('label'=>'Employee Address', 'url'=>array('/employeeaddress/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeeaddress')),
										array('label'=>'Employee Education - heee', 'url'=>array('/employeeeducation/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeeeducation')),
										array('label'=>'Employee Course/Training/Skill - hremif', 'url'=>array('/employeeinformal/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeeinformal')),
										array('label'=>'Employee Working Experience - hremif', 'url'=>array('/employeewo/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeewo')),
										array('label'=>'Man Power - hee', 'url'=>array('/reportkekuatan/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportkekuatan')),
										array('label'=>'Employee Family - heef', 'url'=>array('/employeefamily/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeefamily')),
										array('label'=>'Employee Identity - hremi', 'url'=>array('/employeeidentity/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeeidentity')),
										array('label'=>'Employee Foreign Language - heefr', 'url'=>array('/employeeforeignlanguage/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeeforeignlanguage')),
										array('label'=>'Employee Insurance - heei', 'url'=>array('/employeeinsurance/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeeinsurance')),
										array('label'=>'Employee Jamsostek - heej', 'url'=>array('/employeejamsostek/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeejamsostek')),
									)
								),
								array('label'=>'Time Management','visible'=>Groupmenu::model()->GetReadMenu('timemgmt'), 
									'items'=>array(
										array('label'=>'Time Schedule','visible'=>Groupmenu::model()->GetReadMenu('hrpermitexit'),
											'items'=>array(
												array('label'=>'Absence Status - hrtas', 'url'=>array('/absstatus/index'),'visible'=>Groupmenu::model()->GetReadMenu('absstatus')),
												array('label'=>'Schedule Master - hrtmas', 'url'=>array('/absschedule/index'),'visible'=>Groupmenu::model()->GetReadMenu('absschedule')),
												array('label'=>'Absence Rule - hrtmar', 'url'=>array('/absrule/index'),'visible'=>Groupmenu::model()->GetReadMenu('absrule')),
												array('label'=>'Employee Schedule - htes', 'url'=>array('/employeeschedule/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeeschedule')),
												array('label'=>'Absence Transaction', 'url'=>array('/abstrans/index'),'visible'=>Groupmenu::model()->GetReadMenu('abstrans')),
												array('label'=>'Employee Claim - heec', 'url'=>array('/employeeclaim/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeeclaim')),
												array('label'=>'Employee Sanctions / Warning  - heesp', 'url'=>array('/employeespletter/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeespletter')),
												array('label'=>'Report Absence - hrtrin', 'url'=>array('/reportin/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportin')),
												array('label'=>'Report Per Day - hrtrp', 'url'=>array('/reportperday/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportperday')),
												array('label'=>'Present Attendance Accumulation - htmrta', 'url'=>array('/reportabs/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportabs')),
													)
										),										
										array('label'=>'Permit Exit','visible'=>Groupmenu::model()->GetReadMenu('hrpermitexit'),
											'items'=>array(
												array('label'=>'Permit Exit Reason', 'url'=>array('/permitexit/index'), 'visible'=>Groupmenu::model()->GetReadMenu('permitexit')),
												array('label'=>'Permit Exit Transaction', 'url'=>array('/permitexittrans/index'),'visible'=>Groupmenu::model()->GetReadMenu('permitexittrans')),
												array('label'=>'Report Permit Exit Transaction', 'url'=>array('/reportpermitexittrans/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportpermitexittrans')),
											)
										),
										array('label'=>'Permit In','visible'=>Groupmenu::model()->GetReadMenu('hrpermitin'),
											'items'=>array(
												array('label'=>'Permit In Reason', 'url'=>array('/permitin/index'),'visible'=>Groupmenu::model()->GetReadMenu('permitin')),
												array('label'=>'Permit In Transaction', 'url'=>array('/permitintrans/index'),'visible'=>Groupmenu::model()->GetReadMenu('permitintrans')),
												array('label'=>'Report Permit In', 'url'=>array('/reportpermitintrans/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportpermitintrans')),
											)
										),
										array('label'=>'Sickness','visible'=>Groupmenu::model()->GetReadMenu('hrsickness'),
											'items'=>array(
												array('label'=>'Hospital','visible'=>Groupmenu::model()->GetReadMenu('hospital'),'url'=>array('/hospital/index')),
												array('label'=>'Sickness Transaction', 'url'=>array('/sicktrans/index'),'visible'=>Groupmenu::model()->GetReadMenu('sicktrans')),
												array('label'=>'Report Sickness Transaction', 'url'=>array('/reportsicktrans/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportsicktrans')),
											)
										),
										array('label'=>'Onleave','visible'=>Groupmenu::model()->GetReadMenu('hronleave'),
											'items'=>array(
												array('label'=>'Onleave Type - hpaolt', 'url'=>array('/onleavetype/index'),'visible'=>Groupmenu::model()->GetReadMenu('onleavetype')),
												array('label'=>'Onleave Transaction - hrpaot', 'url'=>array('/onleavetrans/index'),'visible'=>Groupmenu::model()->GetReadMenu('onleavetrans')),
												array('label'=>'Employee Onleave - hpaoeo', 'url'=>array('/employeeonleave/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeeonleave')),
												array('label'=>'Report Onleave Transaction - hrrot', 'url'=>array('/reportonleavetrans/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportonleavetrans')),
											)
										),
										array('label'=>'Overtime', 'visible'=>Groupmenu::model()->GetReadMenu('hremployeeover'),
											'items'=>array(
												array('label'=>'Employee Overtime','url'=>array('/employeeover/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeeover')),
												array('label'=>'Report Overtime','url'=>array('/repempover/index'),'visible'=>Groupmenu::model()->GetReadMenu('repempover')),
											)
										),
									)
								),
								array('label'=>'Facility','visible'=>Groupmenu::model()->GetReadMenu('hrfacility'),                        
									'items'=>array(
										array('label'=>'Facility Type - hrfft', 'url'=>array('/facilitytype/index'),'visible'=>Groupmenu::model()->GetReadMenu('facilitytype')),
										array('label'=>'Employee Facility - hrfef', 'url'=>array('/employeefacility/index'), 'visible'=>Groupmenu::model()->GetReadMenu('employeefacility')),
									)
								),
								array('label'=>'Payroll','visible'=>Groupmenu::model()->GetReadMenu('hrpayroll'),
									'items'=>array(
										array('label'=>'Benefit Type - hrpwt', 'url'=>array('/wagetype/index'),'visible'=>Groupmenu::model()->GetReadMenu('wagetype')),
										array('label'=>'Employee Status - hrmes', 'url'=>array('/employeestatus/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeestatus')),
										array('label'=>'Payroll Period - hrpyp', 'url'=>array('/payrollperiod/index'),'visible'=>Groupmenu::model()->GetReadMenu('payrollperiod')),
										array('label'=>'Tax Wage Progressif - hrptwp', 'url'=>array('/taxwageprogressif/index'),'visible'=>Groupmenu::model()->GetReadMenu('taxwageprogressif')),
										array('label'=>'Employee Benefit - hrpeb', 'url'=>array('/employeebenefit/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeebenefit')),
										array('label'=>'Payroll Process - hrppp', 'url'=>array('/payrollprocess/index'),'visible'=>Groupmenu::model()->GetReadMenu('payrollprocess')),
										array('label'=>'Employee Wage - hrpew', 'url'=>array('/employeewage/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeewage')),
										array('label'=>'Employee Tax - hrpet', 'url'=>array('/employeetax/index'),'visible'=>Groupmenu::model()->GetReadMenu('employeetax')),
										array('label'=>'Payroll Report','visible'=>Groupmenu::model()->GetReadMenu('hrpayroll'),
											'items'=>array(
												array('label'=>'Report Employee Total Salary','url'=>array('/rinciangaji/index'),'visible'=>Groupmenu::model()->GetReadMenu('rinciangaji')),
												//array('label'=>'Total Gaji','url'=>array('/totalgaji/index'),'visible'=>Groupmenu::model()->GetReadMenu('totalgaji')),
												array('label'=>'Rincian Gaji berdasarkan Jenis Benefit','url'=>array('/totalrincigaji/index'),'visible'=>Groupmenu::model()->GetReadMenu('totalrincigaji')),
												array('label'=>'Report Jamsostek','url'=>array('/reportjamsostek/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportjamsostek')),
												array('label'=>'Report DPLK','url'=>array('/reportdplk/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportdplk')),
											)
										)
									)
								)
							)
				),
				array('label'=>'Purchasing','visible'=>Groupmenu::model()->GetReadMenu('purchasing'),
					'items'=>array(
						array('label'=>'Purchasing Organization - ppo', 'url'=>array('/purchasingorg/index'),'visible'=>Groupmenu::model()->GetReadMenu('purchasingorg')),
						array('label'=>'Purchasing Group - ppg', 'url'=>array('/purchasinggroup/index'),'visible'=>Groupmenu::model()->GetReadMenu('purchasinggroup')),
					)
				),
				array('label'=>'Inventory','visible'=>Groupmenu::model()->GetReadMenu('inventory'),
					'items'=>array(
						array('label'=>'Requested By - ireby', 'url'=>array('/requestedby/index'),'visible'=>Groupmenu::model()->GetReadMenu('requestedby')),
						array('label'=>'Form Request (goods/service/delivery)', 'visible'=>Groupmenu::model()->GetReadMenu('reportda'),
							'items'=>array(
								array('label'=>'Form Request (goods/service/delivery) - ida', 'url'=>array('/deliveryadvice/index'),'visible'=>Groupmenu::model()->GetReadMenu('deliveryadvice')),
								array('label'=>'Report Form Request (goods/service/delivery) - irda', 'url'=>array('/reportda/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportda')),
							)
						),
						array('label'=>'Purchase Requisition','visible'=>Groupmenu::model()->GetReadMenu('reportpr'),
							'items'=>array(
								array('label'=>'Purchase Requisition - ipr', 'url'=>array('/prheader/index'),'visible'=>Groupmenu::model()->GetReadMenu('prheader')),
                                array('label'=>'Report PR', 'url'=>array('/reportpr/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportpr')),
							)
						),
						array('label'=>'Goods Received', Groupmenu::model()->GetReadMenu('reportgr'), 
							'items'=>array(							
								array('label'=>'Goods Received', 'visible'=>Groupmenu::model()->GetReadMenu('grheader'), 'url'=>array('/grheader/index')),
								array('label'=>'Report GR', 'url'=>array('/reportgr/index'),'visible'=>Groupmenu::model()->GetReadMenu('reportgr'))
							)
						),
						array('label'=>'Goods Issue', 'visible'=>Groupmenu::model()->GetReadMenu('reportgi'), 
							'items'=>array(							
								array('label'=>'Goods Issue - igi','visible'=>Groupmenu::model()->GetReadMenu('giheader'),'url'=>array('/giheader/index')),
								array('label'=>'Report Goods Issue - irgi','visible'=>Groupmenu::model()->GetReadMenu('reportgi'),'url'=>array('/reportgi/index'))
							)
						),
						array('label'=>'Tools Stock', 'visible'=>Groupmenu::model()->GetReadMenu('beginningstock'), 
							'items'=>array(
								array('label'=>'Tools Stock - ibs', 'visible'=>Groupmenu::model()->GetReadMenu('bsheader'), 'url'=>array('/bsheader/index')),
								array('label'=>'Report Tools Stock - irbs', 'visible'=>Groupmenu::model()->GetReadMenu('reportbs'),'url'=>array('/reportbs/index')),
							)
						),
						array('label'=>'Transfer Stock Exchange', 'visible'=>Groupmenu::model()->GetReadMenu('transferstock'),
							'items'=>array(
								array('label'=>'Transfer Stock Exchange - its','visible'=>Groupmenu::model()->GetReadMenu('transstock'),'url'=>array('/transstock/index')),
								array('label'=>'Report Transfer Stock Exchange - irts','visible'=>Groupmenu::model()->GetReadMenu('reportts'),'url'=>array('/reportts/index')),
							)
						),
						array('label'=>'Material Detail - mmmd', 'url'=>array('/productdetail/index'),'visible'=>Groupmenu::model()->GetReadMenu('productdetail')),
						array('label'=>'Material Stock Overview - mmps', 'url'=>array('/productstock/index'),'visible'=>Groupmenu::model()->GetReadMenu('productstock')),
					)
				),
				array('label'=>'Order','visible'=>Groupmenu::model()->GetReadMenu('ordermanagement'),
					'items'=>array(
						array('label'=>'Sales Order - sdso', 'url'=>array('/soheader/index'),'visible'=>Groupmenu::model()->GetReadMenu('soheader')),
						array('label'=>'Report Sales Order - sdrso', 'url'=>array('/reportso/index'),'visible'=>Groupmenu::model()->GetReadMenu('soheader')),
					)
				),
				array('label'=>'Help',
                  'items'=>array(
                      array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                      array('label'=>'Contact', 'url'=>array('/site/contact')),
                  )
                ), 
				array('label'=>Yii::app()->user->id, 'visible'=>!Yii::app()->user->isGuest,
					'url'=>array('/site/changeprofile'),
					'items'=>array(
						array('label'=>'Change Profile','url'=>array('/site/changeprofile')),
						array('label'=>'Logout','url'=>array('/site/logout')),
					)),			
			),
	)
		);
?>
<div id="leftbar">
<?php
$menus = Groupmenu::model()->findallbysql('select a.*
	from groupmenu a
	inner join menuaccess b on b.menuaccessid = a.menuaccessid
	inner join usergroup c on c.groupaccessid = a.groupaccessid
	inner join useraccess d on d.useraccessid = c.useraccessid
	inner join usermenu e on e.useraccessid = d.useraccessid and e.menuaccessid = b.menuaccessid
	where lower(d.username) = lower("'. Yii::app()->user->id.'") and a.isread = 1'); 

	foreach ($menus as $menu)
	{
	echo '<div id="icon">';
    echo "<a href='index.php?r=".$menu->menuaccess->menuurl."'><img style='width:64px;height:64px;' src='".Yii::app()->request->baseUrl."/images/".$menu->menuaccess->menuicon."'></img></a>";
	echo '<div class="iconname">';
	echo $menu->menuaccess->description;
	echo '</div>';
	echo "</div>";
	}
?>
</div>
	<?php echo $content; ?>
<?php
    $this->widget('ext.etoastr.EToastr',array(
        'flashMessagesOnly'=>true, //default to false
        'message'=>'will be ignored', //because flashOnlyMessages is true
        //the options passed to the plugin
        'options'=>array(
            'positionClass'=>'toast-bottom-right',
            'fadeOut'   =>  1000,
            'timeOut'   =>  2000,
            'fadeIn'    =>  1000
            )
        ));
    ?>
	<div class="clear"></div>
</div><!-- page -->

</body>
</html>
