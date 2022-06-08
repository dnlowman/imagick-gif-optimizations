<?php

$FONTS = array(
    'aleo'=>'fonts/Aleo-Regular.otf',
    'amble'=>'fonts/Amble-Regular.ttf',
    'arial'=>'fonts/Arial-Regular.ttf',
    'arial-bold'=>'fonts/Arial-Bold.ttf',
    'baskerville'=>'fonts/Baskerville-01.ttf',
    'baskerville-bold'=>'fonts/Baskerville-Bold-02.ttf',
    'chunkfive'=>'fonts/Chunkfive.otf',
    'chinese'=>'fonts/STHeiTi.ttf',
    'didot'=>'fonts/Didot_regular.ttf',
    'firasans'=>'fonts/FiraSans-Regular.otf',
    'futurabt-bold'=>'fonts/FuturaBT-Bold.ttf',
    'futurabt-book'=>'fonts/FuturaBT-Book.ttf',
    'futurabt-light'=>'fonts/FuturaBT-Light.ttf',
    'futurabt-medium'=>'fonts/FuturaBT-Medium.ttf',
    'geneva'=>'fonts/Geneva.dfont',
    'georgia'=>'fonts/Georgia.ttf',
    'gillsans'=>'fonts/GillSans-01.ttf',
    'gillsans-bold'=>'fonts/GillSans-Bold-02.ttf',
    'gillsans-bold-italic'=>'fonts/GillSans-BoldItalic-04.ttf',
    'gillsans-italic'=>'fonts/GillSans-Italic-03.ttf',
    'gillsans-light-italic'=>'fonts/GillSans-LightItalic-09.ttf',
    'gillsans-semi-bold'=>'fonts/GillSans-SemiBold-05.ttf',
    'gillsans-semi-bold-italic'=>'fonts/GillSans-SemiBoldItalic-06.ttf',
    'gillsans-ultra-bold'=>'fonts/GillSans-UltraBold-07.ttf',
    'gotham-book'=>'fonts/Gotham-Book.otf',
    'gotham-light'=>'fonts/Gotham-Light.otf',
    'gotham-medium'=>'fonts/Gotham-Medium.otf',
    'gotham-narrow-bold'=>'fonts/GothamNarrow-Bold.otf',
    'gotham-narrow-book'=>'fonts/GothamNarrow-Book.otf',
    'gotham-narrow-thin'=>'fonts/GothamNarrow-Thin.otf',
    'helveticaneue'=>'fonts/HelveticaNeue-Regular.otf',
    'helveticaneue-bold'=>'fonts/HelveticaNeue-Bold.ttf',
    'lato'=>'fonts/Lato-Regular.ttf',
    'lato-bold'=>'fonts/Lato-Bold.ttf',
    'lato-italic'=>'fonts/Lato-Italic.ttf',
    'lato-light'=>'fonts/Lato-Light.ttf',
    'lato-medium'=>'fonts/Lato-Medium.woff',
    'lato-thin'=>'fonts/Lato-Thin.woff',
    'liberationserif'=>'fonts/LiberationSerif-Regular.ttf',
    'montserrat'=>'fonts/Montserrat-Regular.ttf',
    'montserrat-black'=>'fonts/Montserrat-Black.ttf',
    'montserrat-bold'=>'fonts/Montserrat-Bold.ttf',
    'montserrat-italic'=>'fonts/Montserrat-Italic.ttf',
    'montserrat-medium'=>'fonts/Montserrat-Medium.ttf',
    'opensans'=>'fonts/OpenSans-Regular.ttf',
    'opensans-bold'=>'fonts/OpenSans-Bold.ttf',
    'opensans-italic'=>'fonts/OpenSans-Italic.ttf',
    'opensans-semi-bold'=>'fonts/OpenSans-SemiBold.ttf',
    'roboto'=>'fonts/Roboto-Regular.ttf',
    'roboto-black'=>'fonts/Roboto-Black.ttf',
    'roboto-bold'=>'fonts/Roboto-Bold.ttf',
    'roboto-italic'=>'fonts/Roboto-Italic.ttf',
    'roboto-medium'=>'fonts/Roboto-Medium.ttf',
    'sourcesanspro'=>'fonts/SourceSansPro-Regular.otf',
    'timesnewroman'=>'fonts/Times-New-Roman-Normal.ttf',
    #'dejavu'=>'/usr/share/fonts/truetype/dejavu/DejaVuSerif.ttf'
    'dejavu'=>'/usr/share/fonts/ttf-dejavu/DejaVuSans.ttf'


);

$font_file = @$FONTS['dejavu'];

$image = file_get_contents($_GET['image']);

$Imagick = new Imagick();

//$Imagick->setResourceLimit(imagick::RESOURCETYPE_MEMORY, 8192);
//$Imagick->setResourceLimit(imagick::RESOURCETYPE_MAP, 256);
//$Imagick->setResourceLimit(imagick::RESOURCETYPE_AREA, 1512);
//$Imagick->setResourceLimit(imagick::RESOURCETYPE_FILE, 768);
//$Imagick->setResourceLimit(imagick::RESOURCETYPE_DISK, 256);
// $Imagick->setResourceLimit(6, 1024);

$Imagick->readImageBlob($image);


$Imagick->coalesceImages();

///* Create a drawing object and set the font size */
$ImagickDraw = new ImagickDraw();
$ImagickDraw->setFont($font_file);
$ImagickDraw->setFontSize( 32 );

/* Seek the place for the text */
$ImagickDraw->setGravity( Imagick::GRAVITY_CENTER );

$Imagick->optimizeImageLayers();

foreach ($Imagick as $frame) {
    $frame->resizeImage(480, 270, Imagick::FILTER_POINT, 1);
    // $frame->setImageCompressionQuality(10);
    $frame->annotateImage($ImagickDraw, 4, 20, 0, "Test Watermark");
}

// $Imagick->setImageCompressionQuality(10);
$Imagick->stripImage();

/* Set format to png */
$Imagick->setImageFormat( 'gif' );

/* Output */
header( "Content-Type: image/{$Imagick->getImageFormat()}" );
echo $Imagick->getImagesBlob();