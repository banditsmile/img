<?php
ini_set('memory_limit','1024M');
$imageSrc = ".." . DIRECTORY_SEPARATOR . "demo" . DIRECTORY_SEPARATOR . "table.jpg";
$im = ImageCreateFromjpeg($imageSrc);
list($width, $height, $type, $attr) = getimagesize($imageSrc);

$color = [];
$length = $_GET['length'];
$count = 0;
for($i=$width/2;$i<$width;$i++){
    for($j=$height/2;$j<$height;$j++){
        $rgb = ImageColorAt($im, 100, 100);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $color[]=[$r,$g,$b];
        if($count++>$length){
            break 2;
        }
    }
}
header("Content-type:application/json");
echo json_encode($color,0,1000);
exit();