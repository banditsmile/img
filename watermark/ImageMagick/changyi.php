<?php
$imageSrc="..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."demo".DIRECTORY_SEPARATOR."changyi2.jpg";
//$imageSrc='D:\商用车资料最新整理\ggzj\车身模块\车身模块电路图\BCM\东风\东风柳汽\乘龙H7\柳汽乘龙H7_低配BCM_照明_雨刮_电路图\1.jpg';
$image = new Imagick($imageSrc);
$imageIterator = $image->getPixelIterator();
echo $image->getImageWidth(),PHP_EOL;
echo $image->getImageHeight(),PHP_EOL;

$i=0;
foreach ($imageIterator as $row => $pixels) { /* Loop through pixel rows */
    if($row<600){
        continue;
    }
    foreach ($pixels as $column => $pixel) { /* Loop through the pixels in the row (columns) */
        /** @var $pixel \ImagickPixel */
        //echo $pixel->getColorAsString(),PHP_EOL;
        $color = $pixel->getColor();
        //将非黑白二色的部分调整成背景色
/*        $total = abs($color['r']-141)+abs($color['g']-221)+abs($color['b']-231);
        if($color['b']>200 && ($total <100)){
            $pixel->setColor("rgba(255, 255, 255, 0)");
        }

        $total = abs($color['r']-140)+abs($color['g']-164)+abs($color['b']-168);
        if( ($total <50)){
            $pixel->setColor("rgba(255, 255, 255, 0)");
        }*/
        $total = abs($color['r']-$color['g'])+abs($color['g']-$color['b'])+abs($color['b']-$color['r']);
        if($total>10){
            $pixel->setColor("rgba(255, 255, 255, 0)");
        }
        /*//将浅色水印调整成背景色
        if($color['r']>225){
            $pixel->setColor("rgba(255, 255, 255, 0)");
        }*/
    }
    $imageIterator->syncIterator();
}

$image->writeImage('output'.DIRECTORY_SEPARATOR.'changyi2.jpg');
$image->clear();
$image->destroy();

