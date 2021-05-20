<?php

namespace app\controllers;

use app\models\Currency;
use app\models\Products;
use app\models\PurchaseItem;
use app\models\SaleHasPurchase;
use app\models\Warehousebranch;
use yii\base\BaseObject;
use yii\db\Expression;

class ApiProductController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionSale()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($_GET['cid'])) {
            if (!empty($_GET['cid'])) {
                if (Yii::$app->user->identity->branch_id) {
                    $model = Products::find()->innerJoin('warehouse_branch', 'products.id=warehouse_branch.products_id')
                        ->where(['status' => 1, 'category_id' => $_GET['cid'], 'branch_id' => Yii::$app->user->identity->branch_id])
                        ->orderBy('id ASC')
                        ->limit(60)->all();
                } else {
                    $model = Products::find()->where(['status' => 1, 'category_id' => $_GET['cid']])->orderBy('id ASC')->all();
                }
            } else {
                if (Yii::$app->user->identity->branch_id) {
                    $model = Products::find()->innerJoin('warehouse_branch', 'products.id=warehouse_branch.products_id')
                        ->where(['status' => 1, 'branch_id' => Yii::$app->user->identity->branch_id])
                        ->orderBy('id ASC')
                        ->limit(60)->all();
                } else {
                    $model = Products::find()->where(['status' => 1])->orderBy('id ASC')->limit(5)->all();
                }
            }
            return $model;
        } else {
            if (\Yii::$app->request->post('branch_id')) {
                $model = Products::find()->innerJoin('warehouse_branch', 'products.id=warehouse_branch.products_id')
                    ->where(['status' => 1, 'branch_id' => \Yii::$app->request->post('branch_id')])
                    ->orderBy(new Expression('rand()'))
                    ->limit(60)->all();
            } else {
                $model = Products::find()->where(['status' => 1])
                    ->orderBy(new Expression('rand()'))
                    ->limit(60)->all();
            }
            return $model;
        }
    }

    public function actionPay()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (\Yii::$app->request->post('totalprice')) {
            \Yii::$app->session['totalprice'] = \Yii::$app->request->post('totalprice') - \Yii::$app->session['discount'];
            unset(\Yii::$app->session['payprice']);
            unset(\Yii::$app->session['paypriceth']);
            unset(\Yii::$app->session['paypriceusd']);
            unset(\Yii::$app->session['paystill']);
            unset(\Yii::$app->session['paychange']);

            \Yii::$app->session['payprice_lak_exh'] = 0;
            \Yii::$app->session['payprice_th_exh'] = 0;
            \Yii::$app->session['payprice_usd_exh'] = 0;

        }

        if (\Yii::$app->request->post('pricelak')) {

            \Yii::$app->session['payprice'] = (float)str_replace(",", "",\Yii::$app->request->post('pricelak'));
            $currency = Currency::find()->where(['id' => 1])->one(); /// KIP

            $vl = \Yii::$app->session['payprice'];
            $ra = $currency->rate;
            $str = $currency->code;
            eval("\$str = \"$str\";");
            $exh = eval("return $str;");
            \Yii::$app->session['payprice_lak_exh'] = $exh;
            $total_usd_th_lak = \Yii::$app->session['payprice_lak_exh'] + \Yii::$app->session['payprice_th_exh'] + \Yii::$app->session['payprice_usd_exh'];
            if (\Yii::$app->session['totalprice'] - $total_usd_th_lak > 0) {
                \Yii::$app->session['paystill'] = \Yii::$app->session['totalprice'] - $total_usd_th_lak;
            } else {
                \Yii::$app->session['paystill'] = 0;
            }
            if (($total_usd_th_lak - \Yii::$app->session['totalprice']) > 0) {
                \Yii::$app->session['paychange'] = $total_usd_th_lak - \Yii::$app->session['totalprice'];
            } else {
                \Yii::$app->session['paychange'] = 0;
            }
        }

        if (\Yii::$app->request->post('priceth')) {
            \Yii::$app->session['paypriceth'] = (float)str_replace(",", "", \Yii::$app->request->post('priceth'));
            $currency = Currency::find()->where(['id' => 3])->one(); /// BATH
            $vl = \Yii::$app->session['paypriceth'];
            $ra = $currency->rate;
            $str = $currency->code;
            eval("\$str = \"$str\";");
            $exh = eval("return $str;");
            \Yii::$app->session['payprice_th_exh'] = $exh;
            $total_usd_th_lak = \Yii::$app->session['payprice_lak_exh'] + \Yii::$app->session['payprice_th_exh'] + \Yii::$app->session['payprice_usd_exh'];
            if (\Yii::$app->session['totalprice'] - $total_usd_th_lak > 0) {
                \Yii::$app->session['paystill'] = \Yii::$app->session['totalprice'] - $total_usd_th_lak;
            } else {
                \Yii::$app->session['paystill'] = 0;
            }
            if (($total_usd_th_lak - \Yii::$app->session['totalprice']) > 0) {
                \Yii::$app->session['paychange'] = $total_usd_th_lak - \Yii::$app->session['totalprice'];
            } else {
                \Yii::$app->session['paychange'] = 0;
            }
        }

        if (\Yii::$app->request->post('priceusd')) {
            \Yii::$app->session['paypriceusd'] = (float)str_replace(",", "", \Yii::$app->request->post('priceusd'));
            $currency = Currency::find()->where(['id' => 2])->one(); /// BATH
            $vl = \Yii::$app->session['paypriceusd'];
            $ra = $currency->rate;
            $str = $currency->code;
            eval("\$str = \"$str\";");
            $exh = eval("return $str;");
            \Yii::$app->session['payprice_usd_exh'] = $exh;
            $total_usd_th_lak = \Yii::$app->session['payprice_lak_exh'] + \Yii::$app->session['payprice_th_exh'] + \Yii::$app->session['payprice_usd_exh'];
            if (\Yii::$app->session['totalprice'] - $total_usd_th_lak > 0) {
                \Yii::$app->session['paystill'] = \Yii::$app->session['totalprice'] - $total_usd_th_lak;
            } else {
                \Yii::$app->session['paystill'] = 0;
            }
            if (($total_usd_th_lak - \Yii::$app->session['totalprice']) > 0) {
                \Yii::$app->session['paychange'] = $total_usd_th_lak - \Yii::$app->session['totalprice'];
            } else {
                \Yii::$app->session['paychange'] = 0;
            }
        }
        $data=['pay_lak'=>\Yii::$app->session['payprice'],
            'pay_th'=>\Yii::$app->session['paypriceth'],
            'pay_usd'=>\Yii::$app->session['paypriceusd'],
            'pay_still'=>\Yii::$app->session['paystill'],
            'pay_change'=>\Yii::$app->session['paychange']];
        return $data;
    }

    public function actionOrdercomfirm()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $total_prince = 0;
        $pro_id = [];
        if (!empty(\Yii::$app->request->post('product'))) {

            $invioce = new \app\models\Invoice();
            $lastinvoice = \app\models\Invoice::find()->where('year(date)="' . date('Y') . '"')->orderBy('id DESC')->one();
            if (!empty($lastinvoice)) {
                $code = substr($lastinvoice->code, 0, -3);
                $invioce->code = sprintf('%08d', $code + 1) . '/' . date('y');
            } else {
                $invioce->code = sprintf('%08d', 1) . '/' . date('y');
            }
            $invioce->date = date('Y-m-d');
            $invioce->user_id =\Yii::$app->request->post('user_id');
            $invioce->save();

            if (\Yii::$app->request->post('discount') != 0) {
                $discount = new \app\models\Discount();
                $discount->discount = \Yii::$app->request->post('discount');
                $discount->invoice_id = $invioce->id;
                $discount->save();
            }

            /*=== Save multi currency ==*/
            $pay_multi_currency = new \app\models\PayMultiCurency;
            $pay_multi_currency->invoice_id = $invioce->id;
            if (is_null(\Yii::$app->request->post('payprice'))) {
                $pay_lak = 0;
            }else{
                $pay_lak=\Yii::$app->request->post('payprice');
            }
            if (is_null(\Yii::$app->request->post('paypriceth'))) {
                $pay_th = 0;
            }else{
                $pay_th=\Yii::$app->request->post('paypriceth');
            }
            if (is_null(\Yii::$app->request->post('paypriceusd'))) {
                $pay_usd= 0;
            }else{
                $pay_usd=\Yii::$app->request->post('paypriceusd');
            }
            $pay_multi_currency->amount_kip = "" . $pay_lak . "";
            $pay_multi_currency->amount_th = "" . $pay_th . "";
            $pay_multi_currency->amount_usd = "" . $pay_usd . "";
            $pay_multi_currency->save();
            foreach (\Yii::$app->request->post('product') as $index=> $pro) {
                if (!in_array($pro['id'], $pro_id)) {
                    $product = \app\models\Products::find()->where(['id' => $pro['id']])->one();
                    $pro_id[] = $pro['id'];
                    $sale = new \app\models\Sale();
                    $sale->user_id = \Yii::$app->request->post('user_id');
                    $sale->products_id = $pro['id'];
                    $sale->qautity = $pro['qautity'];
                    $sale->date = date('Y-m-d');
                    $sale->price = '' . $product->pricesale * $pro['qautity']. '';
                    $sale->profit_price = '0';
                    $sale->invoice_id = $invioce->id;
                    $sale->branch_id =\Yii::$app->request->post('branch_id');
                    if ($sale->save()) {
                        $purchaseitems = PurchaseItem::find()->where('qautity>0')->andwhere(['products_id' => $sale->products_id])->orderBy('id ASC')->all();
                        $qtt_same = 0;
                        foreach ($purchaseitems as $purchaseitem) {
                            if ($purchaseitem->qautity >= $pro['qautity'] && $pro['qautity']!= 0) {
                                $item = PurchaseItem::find()->where(['id' => $purchaseitem->id])->one();
                                $item->qautity = $purchaseitem->qautity - $pro['qautity'];
                                $item->qtt_saled = $pro['qautity'];
                                if ($item->save()) {
                                    $ext = Products::exchage($purchaseitem->purchase->currency_id, $item->pricebuy);
                                    $cal = (($product->pricesale - $ext) * $item->qtt_saled) + $sale->profit_price;
                                    $sale->profit_price = '' . $cal . '';
                                    $sale->save();

                                    $sale_has_purchase = new SaleHasPurchase();

                                    $sale_has_purchase->purchase_item_id = $item->id;
                                    $sale_has_purchase->sale_id = $sale->id;
                                    $sale_has_purchase->qautity = $item->qtt_saled;
                                    $sale_has_purchase->pricebuy = $item->pricebuy;
                                    $sale_has_purchase->save();
                                }
                            } elseif ($purchaseitem->qautity < $pro['qautity'] && $pro['qautity'] != 0) {
                                $item = PurchaseItem::find()->where(['id' => $purchaseitem->id])->one();
                                $item->qautity = 0;
                                $item->qtt_saled = $purchaseitem->qautity;
                                if ($item->save()) {
                                    $ext = Products::exchage($purchaseitem->purchase->currency_id, $item->pricebuy);
                                    $cal = (($product->pricesale - $ext) * $item->qtt_saled) + $sale->profit_price;
                                    $sale->profit_price = '' . $cal . '';
                                    $sale->save();

                                    $sale_has_purchase = new SaleHasPurchase();
                                    $sale_has_purchase->purchase_item_id = $item->id;
                                    $sale_has_purchase->sale_id = $sale->id;
                                    $sale_has_purchase->qautity = $item->qtt_saled;
                                    $sale_has_purchase->pricebuy = $item->pricebuy;
                                    $sale_has_purchase->save();
                                    $pro['qautity'] = $pro['qautity'] - $purchaseitem->qautity;
                                }
                            }
                        }
                    }

                    if (\Yii::$app->request->post('branch_id')) {
                        $wh_b = Warehousebranch::find()->where(['products_id' => $product->id, 'branch_id' => \Yii::$app->request->post('branch_id')])->one();
                        $wh_b->qautity = $wh_b->qautity - $sale->qautity;
                        $wh_b->save();
                    } else {
                        $product->qautity = $product->qautity - $sale->qautity;
                        $product->pricesale = number_format($product->pricesale, 2);
                        $product->save();
                    }
                }
            }
        }
        return $invioce;
    }

}
