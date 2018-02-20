<?php
    $this->title=Yii::t('app','Dashboard')
?>
<div class="row">
    <?php
        $d= date("Y-m-d", strtotime('this day')); 
        $sum_day= Yii::$app->getDb()->createCommand("select sum(price) from sale where date='".$d."'")->queryScalar();
        
        $invoices_days = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date='" . $d . "'")->queryAll();
        $sum_discount_day=0;
        foreach ($invoices_days as $invoices_day) {
        $sum_discount_day+= Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_day['invoice_id'] . "'")->queryScalar(); 
        }
    ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-calendar"></i></span>
        <div class="info-box-content">
            <span class="info-box-number"><?=Yii::t('app','​​​ຍອດ​ຂາຍມື້ນີ້')?></span>
            <span class="info-box-text"><?=number_format((int)$sum_day-$sum_discount_day,2)?><small></small></span>
        </div>
        </div>
    </div>

    <?php
        $w_first= date("Y-m-d", strtotime('monday this week '));  
        $w_last=date("Y-m-d", strtotime('sunday this week '));
        $sum_w= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$w_first."' and date<='".$w_last."' ")->queryScalar();

        $invoices_ws = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $w_first . "' and date<='" . $w_last . "' ")->queryAll();
        $sum_discount_w = 0;
        foreach ($invoices_ws as $invoices_w) {
            $sum_discount_w += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_w['invoice_id'] . "'")->queryScalar();
        }
    ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-green-active"><i class="fa fa-calendar"></i></span>
        <div class="info-box-content">
            <span class="info-box-number"><?=Yii::t('app','​​​ຍອດ​ຂາຍທິດນີ້')?></span>
            <span class="info-box-text"><?=number_format((int)$sum_w-$sum_discount_w,2)?><small></small></span>
        </div>
        </div>
    </div>

    <?php
        $m_first=date('Y-m-d', strtotime("first day of this month"));
        $m_last=date('Y-m-d', strtotime("last day of this month"));
        $sum_m= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$m_first."' and date<='".$m_last."' ")->queryScalar();

        $invoices_ms = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $m_first . "' and date<='" . $m_last . "' ")->queryAll();
        $sum_discount_m = 0;
        foreach ($invoices_ms as $invoices_m) {
            $sum_discount_m += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_m['invoice_id'] . "'")->queryScalar();
        }
    ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-light-blue-active"><i class="fa fa-calendar"></i></span>
        <div class="info-box-content">
            <span class="info-box-number"><?=Yii::t('app','​​​ຍອດ​ຂາຍເດືອນນີ້')?></span>
            <span class="info-box-text"><?=number_format((int)$sum_m-$sum_discount_m,2)?><small></small></span>
        </div>
        </div>
    </div>

    <?php
        $y_first=date("Y-m-d",strtotime("this year January 1st"));
        $y_last=date("Y-m-d",strtotime("this year December 31st"));
        $sum_y= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$y_first."' and date<='".$y_last."' ")->queryScalar();

        $invoices_ys = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $y_first . "' and date<='" . $y_last . "' ")->queryAll();
        $sum_discount_y = 0;
        foreach ($invoices_ys as $invoices_y) {
            $sum_discount_y += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_y['invoice_id'] . "'")->queryScalar();
        }
    ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
        <div class="info-box-content">
            <span class="info-box-number"><?=Yii::t('app','​​​ຍອດ​ຂາຍປີນີ້')?></span>
            <span class="info-box-text"><?=number_format((int)$sum_y-$sum_discount_y,2)?><small></small></span>
        </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box" style="border-top: 3px solid #c5ba03 !important;">
        <div class="box-header with-border" style="background:#c5ba03; color:#fff">
            <h3 class="box-title"><?=Yii::t('app','​ເບີງ​​ຍອດ​ຂາຍຍ້ອນຫຼັງ 5 ມື້')?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col-md-12">
                <?php
                    $d= date("Y-m-d", strtotime('this day')); 
                    $d1= date("Y-m-d", strtotime('-1 day')); 
                    $d2= date("Y-m-d", strtotime('-2 day')); 
                    $d3= date("Y-m-d", strtotime('-3 day'));
                    $d4= date("Y-m-d", strtotime('-4 day'));  

                    $rd= Yii::$app->getDb()->createCommand("select sum(price) from sale where date='".$d."'")->queryScalar();
                    $invoices_ds = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date='" . $d . "'")->queryAll();
                    $sum_discount_d = 0;
                    foreach ($invoices_ds as $invoices_d) {
                        $sum_discount_d += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_d['invoice_id'] . "'")->queryScalar();
                    }
                    $rd=$rd-$sum_discount_d;
                    
                    $rd1= Yii::$app->getDb()->createCommand("select sum(price) from sale where date='".$d1."'")->queryScalar();
                    $invoices_d1s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date='" . $d1 . "'")->queryAll();
                    $sum_discount_d1 = 0;
                    foreach ($invoices_d1s as $invoices_d1) {
                        $sum_discount_d1 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_d1['invoice_id'] . "'")->queryScalar();
                    }
                    $rd1 = $rd1 - $sum_discount_d1;
                    
                    $rd2= Yii::$app->getDb()->createCommand("select sum(price) from sale where date='".$d2."'")->queryScalar();
                    $invoices_d2s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date='" . $d2 . "'")->queryAll();
                    $sum_discount_d2 = 0;
                    foreach ($invoices_d2s as $invoices_d2) {
                        $sum_discount_d2 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_d2['invoice_id'] . "'")->queryScalar();
                    }
                    $rd2 = $rd2 - $sum_discount_d2;
                    
                    $rd3= Yii::$app->getDb()->createCommand("select sum(price) from sale where date='".$d3."'")->queryScalar();
                    $invoices_d3s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date='" . $d3 . "'")->queryAll();
                    $sum_discount_d3 = 0;
                    foreach ($invoices_d3s as $invoices_d3) {
                        $sum_discount_d3 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_d3['invoice_id'] . "'")->queryScalar();
                    }
                    $rd3 = $rd3 - $sum_discount_d3;

                    $rd4= Yii::$app->getDb()->createCommand("select sum(price) from sale where date='".$d4."'")->queryScalar();
                    $invoices_d4s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date='" . $d4 . "'")->queryAll();
                    $sum_discount_d4 = 0;
                    foreach ($invoices_d4s as $invoices_d4) {
                        $sum_discount_d4 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_d4['invoice_id'] . "'")->queryScalar();
                    }
                    $rd4 = $rd4 - $sum_discount_d4;
                    
                    $sum=number_format((int)$rd + (int)$rd1 + (int)$rd2 + (int)$rd3 + (int)$rd4,2);
                ?>
                <?php echo \yii2mod\c3\chart\Chart::widget([
                    'options' => [
                            'id' => 'd_chart'
                    ],
                    'clientOptions' => [
                    'data' => [
                            'x' => 'x',
                            'columns' => [
                                ['x', ''.$d4.'' , ''.$d3.'', ''.$d2.'' , ''.$d1.'' , ''.$d.''],
                                [''.Yii::t('app','ສີນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ').'('.$sum.')', (int)$rd4, (int)$rd3, (int)$rd2, (int)$rd1, (int)$rd],
                            ],
                            'colors' => [
                                ''. Yii::t('app','ສີນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ').' ('.$sum.')' => '#e4122b',
                            ],
                            'type'=>'area-spline',
                        ],
                        'axis' => [
                            'x' => [
                                'label' => '',
                                'type' => 'category'
                            ],
                            'y' => [
                                'label' => [
                                    'text' => Yii::t('app', 'ຈຳ​ນວນ​ເງີນ'),
                                    'position' => 'outer-top'
                                ],
                                'min' => 0,
                                //'max' =>'',
                                'padding' => ['top' => 10, 'bottom' => 0]
                            ]
                        ]
                    ]
                ]); ?>
            </div>
            </div>
        </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box" style="border-top: 3px solid #0f7014 !important;">
        <div class="box-header with-border" style="background:#0f7014; color:#fff">
            <h3 class="box-title"><?=Yii::t('app','ການ​ເບີງ​ຍ້ອນຫຼັງ​ຍອດ​ຂາຍ 4 ອາ​ທິດ')?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col-md-12">
                <?php
                    $w_first= date("Y-m-d", strtotime('monday this week '));  
                    $w_last=date("Y-m-d", strtotime('sunday this week '));

                    $w1_first=date("Y-m-d", strtotime('monday 0 week ago '));
                    $w1_last=date("Y-m-d", strtotime('sunday 0 week ago'));

                    $w2_first=date("Y-m-d", strtotime('monday 1 week ago '));
                    $w2_last=date("Y-m-d", strtotime('sunday 1 week ago'));

                    $w3_first=date("Y-m-d", strtotime('monday 2 week ago '));
                    $w3_last=date("Y-m-d", strtotime('sunday 2 week ago'));

                    $w= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$w_first."' and date<='".$w_last."' ")->queryScalar();
                    $invoices_ws = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $w_first . "' and date<='" . $w_last . "' ")->queryAll();
                    $sum_discount_w = 0;
                    foreach ($invoices_ws as $invoices_w) {
                        $sum_discount_w += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_w['invoice_id'] . "'")->queryScalar();
                    }
                    $w=$w-$sum_discount_w;

                    $w1= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$w1_first."' and date<='".$w1_last."' ")->queryScalar();
                    $invoices_w1s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $w1_first . "' and date<='" . $w1_last . "' ")->queryAll();
                    $sum_discount_w1 = 0;
                    foreach ($invoices_w1s as $invoices_w1) {
                        $sum_discount_w1 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_w1['invoice_id'] . "'")->queryScalar();
                    }
                    $w1 = $w1 - $sum_discount_w1;
                    
                    $w2= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$w2_first."' and date<='".$w2_last."' ")->queryScalar();
                    $invoices_w2s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $w2_first . "' and date<='" . $w2_last . "' ")->queryAll();
                    $sum_discount_w2 = 0;
                    foreach ($invoices_w2s as $invoices_w2) {
                        $sum_discount_w2 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_w2['invoice_id'] . "'")->queryScalar();
                    }
                    $w2 = $w2 - $sum_discount_w2;

                    $w3= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$w3_first."' and date<='".$w3_last."' ")->queryScalar();
                    $invoices_w3s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $w3_first . "' and date<='" . $w3_last . "' ")->queryAll();
                    $sum_discount_w3 = 0;
                    foreach ($invoices_w3s as $invoices_w3) {
                        $sum_discount_w3 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_w3['invoice_id'] . "'")->queryScalar();
                    }
                    $w3 = $w3 - $sum_discount_w3;
                    
                    $sum=number_format((int)$w + (int)$w1 + (int)$w2 + (int)$w3,2);
                ?>
                <?php echo \yii2mod\c3\chart\Chart::widget([
                    'options' => [
                            'id' => 'w_chart'
                    ],
                    'clientOptions' => [
                    'data' => [
                            'x' => 'x',
                            'columns' => [
                                ['x', Yii::t('app', 'ອາ​ທິດ4'), Yii::t('app', 'ອາ​ທິດ3') , Yii::t('app', 'ອາ​ທິດ2'), Yii::t('app', 'ອາ​ທິດ1')],
                                ['ສີນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ ('.$sum.')', (int)$w3, (int)$w2, (int)$w1, (int)$w],
                            ],
                            'colors' => [''. Yii::t('app','ສີນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ').' ('.$sum.')' => '#06067c',
                            ],
                            'type'=>'area-spline',
                        ],
                        'axis' => [
                            'x' => [
                                'label' => '',
                                'type' => 'category'
                            ],
                            'y' => [
                                'label' => [
                                    'text' => Yii::t('app','ຈຳ​ນວນ​ເງີນ'),
                                    'position' => 'outer-top'
                                ],
                                'min' => 0,
                                //'max' =>'',
                                'padding' => ['top' => 10, 'bottom' => 0]
                            ]
                        ]
                    ]
                ]); ?>
            </div>
            </div>
        </div>
        </div>
        
    </div>

    <div class="col-md-6">
        <div class="box" style="border-top: 3px solid #153479 !important;">
        <div class="box-header with-border" style="background:#153479; color:#fff">
            <h3 class="box-title"><?=Yii::t('app','​ເບີງ​​ຍອດ​ຂາຍຍ້ອນຫຼັງ 4 ເດືອນ')?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col-md-12">
                <?php
                    $m3_first=date('Y-m-d', strtotime("first day of -3 month"));
                    $m3_last=date('Y-m-d', strtotime("last day of -3 month"));
                    
                    $m2_first=date('Y-m-d', strtotime("first day of -2 month"));
                    $m2_last=date('Y-m-d', strtotime("last day of -2 month"));

                    $m1_first=date('Y-m-d', strtotime("first day of -1 month"));
                    $m1_last=date('Y-m-d', strtotime("last day of -1 month"));

                    $m_first=date('Y-m-d', strtotime("first day of this month"));
                    $m_last=date('Y-m-d', strtotime("last day of this month"));

                    $m= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$m_first."' and date<='".$m_last."' ")->queryScalar();
                    $invoices_ms = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $m_first . "' and date<='" . $m_last . "' ")->queryAll();
                    $sum_discount_m = 0;
                    foreach ($invoices_ms as $invoices_m) {
                        $sum_discount_m += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_m['invoice_id'] . "'")->queryScalar();
                    }
                    $m = $m - $sum_discount_m;

                    $m1= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$m1_first."' and date<='".$m1_last."' ")->queryScalar();
                    $invoices_m1s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $m1_first . "' and date<='" . $m1_last . "' ")->queryAll();
                    $sum_discount_m1 = 0;
                    foreach ($invoices_m1s as $invoices_m1) {
                        $sum_discount_m1 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_m1['invoice_id'] . "'")->queryScalar();
                    }
                    $m1 = $m1 - $sum_discount_m1;

                    $m2= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$m2_first."' and date<='".$m2_last."' ")->queryScalar();
                    $invoices_m2s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $m2_first . "' and date<='" . $m2_last . "' ")->queryAll();
                    $sum_discount_m2 = 0;
                    foreach ($invoices_m2s as $invoices_m2) {
                        $sum_discount_m2 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_m2['invoice_id'] . "'")->queryScalar();
                    }
                    $m2 = $m2 - $sum_discount_m2; 
                
                    $m3= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$m3_first."' and date<='".$m3_last."' ")->queryScalar();
                    $invoices_m3s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $m3_first . "' and date<='" . $m3_last . "' ")->queryAll();
                    $sum_discount_m3 = 0;
                    foreach ($invoices_m3s as $invoices_m3) {
                        $sum_discount_m3 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices3_m['invoice_id'] . "'")->queryScalar();
                    }
                    $m3 = $m3 - $sum_discount_m3;
                    
                    $sum=number_format((int)$m + (int)$m1 + (int)$m2 + (int)$m3,2);
                ?>
                <?php echo \yii2mod\c3\chart\Chart::widget([
                    'options' => [
                            'id' => 'm_chart'
                    ],
                    'clientOptions' => [
                    'data' => [
                            'x' => 'x',
                            'columns' => [
                                ['x', date('Y-m',strtotime($m3_last)), date('Y-m',strtotime($m2_last)), date('Y-m',strtotime($m1_last)), date('Y-m',strtotime($m_last))],
                                [''.Yii::t('app','ສີນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ').' ('.$sum.')', (int)$m3, (int)$m2, (int)$m1, (int)$m],
                            ],
                            'colors' => [
                                ''. Yii::t(
                                    'app',
                                    'ສີນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ').' ('.$sum.')' => '#066334',
                            ],
                            'type'=>'area-spline',
                        ],
                        'axis' => [
                            'x' => [
                                'label' => '',
                                'type' => 'category'
                            ],
                            'y' => [
                                'label' => [
                                    'text' => Yii::t(
                                        'app',
                                        'ຈຳ​ນວນ​ເງີນ'),
                                    'position' => 'outer-top'
                                ],
                                'min' => 0,
                                //'max' =>'',
                                'padding' => ['top' => 10, 'bottom' => 0]
                            ]
                        ]
                    ]
                ]); ?>
            </div>
            </div>
        </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box" style="border-top: 3px solid #d5081c !important;">
        <div class="box-header with-border" style="background:#d5081c; color:#fff">
            <h3 class="box-title"><?=Yii::t('app','​ເບີງ​​ຍອດ​ຂາຍຍ້ອນຫຼັງ 4 ປີ')?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col-md-12">
                <?php
                    $y3_first=date("Y-m-d",strtotime("-3 year January 1st"));
                    $y3_last=date("Y-m-d",strtotime("-3 year December 31st"));

                    $y2_first=date("Y-m-d",strtotime("-2 year January 1st"));
                    $y2_last=date("Y-m-d",strtotime("-2 year December 31st"));

                    $y1_first=date("Y-m-d",strtotime("-1 year January 1st"));
                    $y1_last=date("Y-m-d",strtotime("-1 year December 31st"));

                    $y_first=date("Y-m-d",strtotime("this year January 1st"));
                    $y_last=date("Y-m-d",strtotime("this year December 31st"));

                    $y= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$y_first."' and date<='".$y_last."' ")->queryScalar();
                    $invoices_ys = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $y_first . "' and date<='" . $y_last . "' ")->queryAll();
                    $sum_discount_y = 0;
                    foreach ($invoices_ys as $invoices_y) {
                        $sum_discount_y += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_y['invoice_id'] . "'")->queryScalar();
                    }
                    $y = $y - $sum_discount_y;
                    
                    $y1= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$y1_first."' and date<='".$y1_last."' ")->queryScalar();
                    $invoices_y1s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $y1_first . "' and date<='" . $y1_last . "' ")->queryAll();
                    $sum_discount_y1 = 0;
                    foreach ($invoices_y1s as $invoices_y1) {
                        $sum_discount_y1 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_y1['invoice_id'] . "'")->queryScalar();
                    }
                    $y1 = $y1 - $sum_discount_y1;
                    
                    $y2= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$y2_first."' and date<='".$y2_last."' ")->queryScalar();
                    $invoices_y2s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $y2_first . "' and date<='" . $y2_last . "' ")->queryAll();
                    $sum_discount_y2 = 0;
                    foreach ($invoices_y2s as $invoices_y2) {
                        $sum_discount_y2 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_y2['invoice_id'] . "'")->queryScalar();
                    }
                    $y2 = $y2 - $sum_discount_y2;
                    
                    $y3= Yii::$app->getDb()->createCommand("select sum(price) from sale where date>='".$y3_first."' and date<='".$y3_last."' ")->queryScalar();
                    $invoices_y3s = Yii::$app->getDb()->createCommand("select DISTINCT invoice_id from sale where date>='" . $y3_first . "' and date<='" . $y3_last . "' ")->queryAll();
                    $sum_discount_y3 = 0;
                    foreach ($invoices_y3s as $invoices_y) {
                        $sum_discount_y3 += Yii::$app->getDb()->createCommand("select sum(discount) from discount where invoice_id='" . $invoices_y3['invoice_id'] . "'")->queryScalar();
                    }
                    $y3 = $y3 - $sum_discount_y3;
                    
                    $sum=number_format((int)$y + (int)$y1 + (int)$y2 + (int)$y3,2);
                ?>
                <?php echo \yii2mod\c3\chart\Chart::widget([
                    'options' => [
                            'id' => 'y_chart'
                    ],
                    'clientOptions' => [
                    'data' => [
                            'x' => 'x',
                            'columns' => [
                                ['x', ''.date("Y",strtotime("-3 year")).'', ''.date("Y",strtotime("-2 year")).'', ''.date("Y",strtotime("-1 year")).'', ''.date("Y",strtotime("this year")).''],
                                [''. Yii::t('app', 'ສີນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ').' ('.$sum.')', (int)$y3, (int)$y2, (int)$y1, (int)$y],
                            ],
                            'colors' => [
                                ''. Yii::t(
                                    'app',
                                    'ສີນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ').' ('.$sum.')' => '#d7a306',
                            ],
                            'type'=>'area-spline',
                        ],
                        'axis' => [
                            'x' => [
                                'label' => '',
                                'type' => 'category'
                            ],
                            'y' => [
                                'label' => [
                                    'text' => Yii::t('app', 'ຈຳ​ນວນ​ເງີນ'),
                                    'position' => 'outer-top'
                                ],
                                'min' => 0,
                                //'max' =>'',
                                'padding' => ['top' => 10, 'bottom' => 0]
                            ]
                        ]
                    ]
                ]); ?>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>