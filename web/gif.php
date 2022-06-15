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
    'dejavu'=>'/usr/share/fonts/truetype/dejavu/DejaVuSerif.ttf'
    #'dejavu'=>'/usr/share/fonts/ttf-dejavu/DejaVuSans.ttf'


);

$image_source_url = $_GET['image'];
// Remove CDN if needed
if (strpos($image_source_url, 'http://d2ln81zewtf5w3.cloudfront.net/tmb.php')===0 ||
    strpos($image_source_url, 'https://d2ln81zewtf5w3.cloudfront.net/tmb.php')===0){
    $qs_str = strtok($image_source_url, '?');
    $qs_str = strtok('?');
    $qs = array();
    parse_str($qs_str, $qs);
    $image_source_url = @$qs['url'];
}

// Disabled in relation to this support issue - https://ometria.atlassian.net/browse/IASS-165
if (strpos($image_source_url, 'footasylum.com%2Fimages%2Fproducts%2Fsmall%2') !== false ||
    strpos($image_source_url, 'footasylum.com/images/products/small/') !== false) {
    do_error('Not allowed');
}

$image_source_url = str_replace(' ', '%20', $image_source_url);
if (!$image_source_url) do_error('URL missing');

$title = @$_GET['title'];
$price = @$_GET['price'];
$currency = @$_GET['currency'];
// change it to opensans
$font= @$_GET['font'] ?: 'dejavu';

$title_font_size = @$_GET['ts'] ?: 15;
$price_font_size = @$_GET['ps'] ?: 14;
if ($title_font_size>40) $title_font_size=40;
if ($price_font_size>40) $price_font_size=40;

$title_font_color = @$_GET['tc'] ?: '000';
$price_font_color = @$_GET['pc'] ?: '000';

$output_padded_colour = @$_GET['bgcolor'] ?: 'fff';

$output_image_type = @$_GET['output'] ?: 'gif';

$image_to_label_ratio = 0.50;

// Parse parameters
$size_str = null;
if (@$_GET['default_size']) $size_str = $_GET['default_size'];
if (@$_GET['size']) $size_str = $_GET['size'];

if ($size_str){
    $is_resized = true;
    @list($output_width, $output_height) = explode('x', $size_str);
    if (!is_numeric($output_width) || !is_numeric($output_height)) {
        do_error('Dimensions invalid');
    }
}

$image_rescale = @$_GET['scale'] ? intval($_GET['scale']) : 1;
if ($image_rescale>=4) $image_rescale = 4;
$output_width = $output_width * $image_rescale;
$output_height = $output_height * $image_rescale;
$title_font_size = $title_font_size * $image_rescale;
$price_font_size = $price_font_size * $image_rescale;

$resize_shapness = 0.75;
if ($output_width>400 || $output_height>400) $resize_shapness = 0.9;


$w = $output_width;
$h = $output_height;

// Sanity check
if ($title_font_size>($h*0.1)) {
    $title_font_size = 8;
    $price_font_size = 8;
}

$price_formatted = null;
if (!$currency)
    $price_formatted = $price;
elseif ($price){
    if ($price==intval($price)) {
        $price = floor($price).'';
    } else {
        $price = number_format((float)$price, 2, '.', '');
    }

    if ($currency=='GBP') {
        $price_formatted = '£'.$price;
    } elseif ($currency=='USD'){
        $price_formatted = '$'.$price;
    } elseif ($currency=='EUR'){
        $price_formatted = '€'.$price;
    } else {
        $price_formatted = $currency.' '.$price;
    }
}

$output_image_width = floor($output_width*0.9);

$output_image_title_height = floor($output_height*(1-$image_to_label_ratio));
$output_image_title_height = min($output_image_title_height, 70*$image_rescale);

$output_image_height = $output_height-$output_image_title_height;

$image = new Imagick();
$image->setBackgroundColor(new ImagickPixel(fix_hex_color($output_padded_colour)));

//$Imagick->setResourceLimit(imagick::RESOURCETYPE_MEMORY, 8192);
//$Imagick->setResourceLimit(imagick::RESOURCETYPE_MAP, 256);
//$Imagick->setResourceLimit(imagick::RESOURCETYPE_AREA, 1512);
//$Imagick->setResourceLimit(imagick::RESOURCETYPE_FILE, 768);
//$Imagick->setResourceLimit(imagick::RESOURCETYPE_DISK, 256);
// $Imagick->setResourceLimit(6, 1024);

$image->readImageBlob(file_get_contents($image_source_url));

$image->coalesceImages();

///* Create a drawing object and set the font size */
$font_file = @$FONTS[$font];

$draw = new ImagickDraw();
$draw->setFont($font_file);
$draw->setTextEncoding('UTF-8');
$draw->setFont($font_file);
$draw->setTextAlignment(\Imagick::ALIGN_CENTER);

$actual_height = $image->getImageHeight();
$actual_width = $image->getImageWidth();
$output_image_height = $output_height - $output_image_title_height;
$x = floor(($output_width - $actual_width) / 2);
$y = floor(($output_image_height - $actual_height) / 2);
$metrics = $image->queryFontMetrics($draw, $title);
$th = $metrics['textHeight'];
$xpos = round($output_width / 2);
$ypos = round($output_image_height + $th );//+$title_font_size-15);//+5);

$image->optimizeImageLayers();
$first_iteration=true;
$default_ypos_increment=5;
if (intval($price_font_size) > intval($title_font_size) + 5) $default_ypos_increment = $title_font_size + $default_ypos_increment;
$init_value=0;

foreach ($image as $frame) {
    $frame->resizeImage($output_image_width, $output_image_height,  Imagick::FILTER_LANCZOS, $resize_shapness, true);

    if ($first_iteration) {
        $actual_height = $frame->getImageHeight();
        $actual_width = $frame->getImageWidth();
        $output_image_height = $output_height - $output_image_title_height;
        $metrics = $frame->queryFontMetrics($draw, $title);
        $th = $metrics['textHeight'];
        $xpos = round($output_width / 2);
        $ypos = round($output_image_height + $th );
    } else {
        $ypos = $init_value;
    }

    //debug_to_console('Init Y Value='.$init_value);

    $draw->setFillColor(fix_hex_color($title_font_color));
    $draw->setFontSize($title_font_size);

    $init_value=imagick_text($image, $draw, $title, 2, $output_image_width, $xpos, $ypos);

    //debug_to_console('Second Image y='.$init_value + 5);


    $draw->setFillColor(fix_hex_color($price_font_color));
    $draw->setFontSize($price_font_size);

    imagick_text($image, $draw, $price_formatted, 1, $output_image_width, $xpos, $init_value + $title_font_size);

    $first_iteration = false;

}

// $image->setImageBackgroundColor('red');
// $image->transformImageColorspace(\Imagick::CHANNEL_BLUE);
// $image->setImageAlphaChannel(9);
// $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);

// $image->deconstructImages();
// $Imagick->setImageCompressionQuality(10);
$image->stripImage();

/* Set format to png */
$image->setImageFormat($output_image_type);

/* Output */
header( "Content-Type: image/{$image->getImageFormat()}" );
echo $image->getImagesBlob();

function imagick_text($image, $draw, $text, $max_lines, $max_width, $xpos, $ypos){
    $text = html_entity_decode($text);
    $text = strip_tags($text);

    list($lines, $line_height) = imagick_word_wrap_annotation($image, $draw, $text, $max_width);

    for($i = 0; $i < count($lines); $i++) {
        if ($i>=$max_lines) break;
        $image->annotateImage($draw, $xpos, $ypos + $i*$line_height, 0, $lines[$i]);
    }

    return $i * $line_height;
}

function imagick_word_wrap_annotation($image, $draw, $text, $max_width) {
    $words = preg_split('%\s%', $text, -1, PREG_SPLIT_NO_EMPTY);
    $lines = array();
    $i = 0;
    $line_height = 0;
    $loops = 0;

    while (count($words) > 0)
    {
        $metrics = $image->queryFontMetrics($draw, implode(' ', array_slice($words, 0, ++$i)));
        $line_height = max($metrics['textHeight'], $line_height);

        if ($metrics['textWidth'] > $max_width or count($words) < $i)
        {
            if ($i==1) $i = 2; // Fix case where first word is longer than image
            $lines[] = implode(' ', array_slice($words, 0, --$i));
            $words = array_slice($words, $i);
            $i = 0;
        }

        $loops++;
        if ($loops>10) break;
    }

    return array($lines, $line_height);
}

// Make sure in #xxxxxx format
function fix_hex_color($hex){
    $hex = strtolower($hex);
    $hex = preg_replace('#[^a-z0-9]#', '', $hex);
    if (strlen($hex)==3) {
        return '#'.$hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    } elseif (strlen($hex)==6) {
        return '#'.$hex;
    } else {
        return '#ffffff';
    }
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}