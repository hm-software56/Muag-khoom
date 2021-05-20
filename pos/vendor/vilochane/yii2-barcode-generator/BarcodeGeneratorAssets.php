<?php

/**
 * Assets Class
 * Wrapper  for BarCode Coder Library (BCC Library)
 *  BCCL Version 2.0
 *    
 *  Porting : jQuery barcode plugin 
 *  Version : 2.0.3
 *   
 *  Date    : 2013-01-06
 *  Author  : DEMONTE Jean-Baptiste <jbdemonte@gmail.com>
 *            HOUREZ Jonathan
 *             
 *  Web site: http://barcode-coder.com/
 *  dual licence :  http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html
 *                  http://www.gnu.org/licenses/gpl.html * 
 * @author Vilochane <vilochane@gmail.com>
 * @link GitHub https://github.com/Vilochane
 * @link yii http://www.yiiframework.com/forum/index.php/user/223499-vilo/
 */

namespace barcode\barcode;

use yii\web\AssetBundle;

class BarcodeGeneratorAssets extends AssetBundle {

    /**
     * @inherit doc
     */
    public function init() {
        $this->sourcePath = __DIR__ . '/assets';
        $this->js = ['jquery-barcode.min.js'];
        $this->depends = ['yii\web\YiiAsset' ];
        parent::init();
    }

}
