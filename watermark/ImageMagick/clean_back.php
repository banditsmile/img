<?php
$imageSrc="..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."demo".DIRECTORY_SEPARATOR."chart.jpg";
$image = new Imagick($imageSrc);

$image->borderImage(new ImagickPixel("white"),1,1);
$image->floodFillPaintImage('transparent',2000,new ImagickPixel("#FFEAEF"),0,0,false);
$draw = new ImagickDraw();
$draw->color(0,0,imagick::PAINT_FLOODFILL);
$image->drawImage($draw);
$image->shaveImage(1,1);
//header("Content-Type: image/{$image->getImageFormat()}");
//echo $image->getImageBlob( );
$image->writeImage('output'.DIRECTORY_SEPARATOR.'clean_back.jpg');
$image->clear();
$image->destroy();
