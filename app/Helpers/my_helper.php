<?php

// use chillerlan\QRCode\{QRCode, QROptions};
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeNone;

function kodeRapat()
{
    $length = 3; // Length of the random string
    $characters = '0123456789';
    $segment1 = substr(str_shuffle($characters), 0, $length);
    $segment2 = substr(str_shuffle($characters), 0, $length);
    $kode = $segment1 . '-' . $segment2;
    return $kode;
}

function expiredTime($date, $time)
{
    $datetimeStr = $date . ' ' . $time;
    $interval = '4 hours'; // The interval you want to add

    // Convert the datetime string to a DateTime object
    $datetime = new DateTime($datetimeStr);

    // Add the interval to the datetime
    $datetime->add(new DateInterval('PT4H'));

    // Format the new datetime as 'Y-m-d H:i'
    $expiredDateTime = $datetime->format('Y-m-d H:i');

    $currentDateTime = new DateTime();
    // dd($currentDateTime->format('Y-m-d H:i'), $expiredDateTime);
    if ($currentDateTime->format('Y-m-d H:i') > $expiredDateTime) {
        // Meeting has expired
        return true;
    } else {
        // Meeting is still valid
        return false;
    }

    // return $expiredDateTime;
}

function statusRapat($date, $time)
{
    $expiredCheck = expiredTime($date, $time);
    // dd($currentDateTime->format('Y-m-d H:i'), $expiredDateTime);
    if (!$expiredCheck) {
        // Meeting is still valid
        return 'tersedia';
    } else {
        // Meeting has expired
        return 'selesai';
    }
}

function getCurrentTimeRounded()
{
    // Calculate the current time rounded to the nearest 30-minute interval
    $currentMinutes = date('i');
    $roundedMinutes = $currentMinutes + (30 - $currentMinutes % 30);
    $roundedCurrentTime = date('H:') . str_pad($roundedMinutes, 2, '0', STR_PAD_LEFT);
    return $roundedCurrentTime;
}

function generateQrCode($linkRapat)
{
    // add logo to qr
    $logoPath = FCPATH . 'assets/img/pemkab.png';

    $qr = QrCode::create($linkRapat)
        ->setSize(500)
        ->setForegroundColor(new Color(0, 0, 0, 0))
        ->setMargin(10)
        ->setBackgroundColor(new Color(255, 255, 255, 0));

    $logo = Logo::create($logoPath)
        ->setResizeToWidth(120)
        ->setResizeToHeight(120);

    // $label = Label::create('Scan QR Code untuk mengikuti rapat', 16)

    $writer = new  PngWriter();
    $result = $writer->write($qr, $logo)->getDataUri();

    return $result;
}

function loopIteration($pager, $group)
{
    $counter = $pager->getDetails($group)['currentPage'] === 1 ? 1 : ($pager->getDetails($group)['currentPage'] - 1) * 5 + 1;

    return $counter;
}

// captcha server side
function verifyCaptcha($token)
{

    $client = service('curlrequest');
    $secretKey = env('RECAPTCHA_SECRET_KEY_V2');

    $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
        'form_params' => [
            'secret'   => $secretKey,
            'response' => $token,
        ],
    ]);

    if ($response->getStatusCode() === 200) {
        $result = json_decode($response->getBody());
        // dd($result);
        return $result;
    }
    return null;
}

function image_to_base64($path)
{
    // $path = 'myfolder/myimage.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}

function elipsis($str, $length = 80)
{
    if (strlen(strip_tags($str)) > $length) {
        return substr(strip_tags($str), 0, $length) . '...';
    } else {
        return strip_tags($str);
    }
}
