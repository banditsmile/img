<?php
ini_set('memory_limit','1024M');
$imageSrc = ".." . DIRECTORY_SEPARATOR . "demo" . DIRECTORY_SEPARATOR . "table.jpg";
//$imageSrc='D:\商用车资料最新整理\ggzj\车身模块\车身模块电路图\BCM\东风\东风柳汽\乘龙H7\柳汽乘龙H7_低配BCM_照明_雨刮_电路图\1.jpg';
$image = new Imagick($imageSrc);
$imageIterator = $image->getPixelIterator();

$data=[["red","green","blue","a"],[1,2,3,4],[2,2,3,4]];
$data=[];
foreach ($imageIterator as $row => $pixels) { /* Loop through pixel rows */
    foreach ($pixels as $column => $pixel) { /* Loop through the pixels in the row (columns) */
        /** @var $pixel \ImagickPixel */
        $color = array_values($pixel->getColor());
        if($color[0]==$color[1] && $color[1]==$color[2] && $color[2]==255){
            continue;
        }
        $color = array_values($pixel->getColor());
        $data[] = array_slice($color, 0, 3);
    }
}
$data = array_slice($data,0,100);
header("Content-type:application/json");
echo json_encode($data,0,1000);
exit();
