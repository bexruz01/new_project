<?php

use App\Models\Additional\Language;
use Illuminate\Support\Facades\File;
use Intervention\Image\Image;

function formatDate($date_string, $format = 'd-m-Y')
{
    if ($date_string == null || $date_string == '')
        return '';
    return date($format, strtotime($date_string));
}

function formatDateTime($date_string, $format = 'd.m.Y H:i:s')
{
    if ($date_string == null || $date_string == '')
        return '';
    return date($format, strtotime($date_string));
}

function defaultLocale()
{
    return Language::where('default', true)->first();
}

function allLanguage()
{
    return Language::all();
}

function defaultLocaleCode()
{
    return optional(defaultLocale())->url;
}

////////////////////////////////////////////////////Image APIs////////////////////////////////////////////////////////
/*
 * get image type value
 */
function getImageType()
{
    return config('app.getImageType');  // true // false in api projects
}


/*
 * get image function
 */
function getImage($photo, $config)
{
    $folder = $config['folder_resize'];
    $imagePath = $config['image_folder'];
    $width = $config['width'];
    $height = $config['height'];

    if (!$photo) return noImage();
    if (getImageType()) {
        return config('params.media_link') . '/api/' . $imagePath . '/' . $folder . '/' . $photo;
    }

    try {
        $fileName = md5($photo) . '.jpeg';
        $path = storage_path() . '/app/public/' . $folder;
        if (file_exists($path . '/' . $fileName)) {
            return config('params.media_link') . '/api/' . '/storage/' . $folder . '/' . $fileName;
        }

        $image = config('params.media_link') . '/api/' . '/storage/' . $imagePath . '/' . $photo;
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        $img = Image::make($image);
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $img->save($path . "/" . $fileName, 85);
        return config('params.media_link') . '/api/' . '/storage/' . $folder . '/' . $fileName;
    } catch (Exception $e) {
        return noImage();
    }
}


function getImageOriginal($folder, $image)
{
    if ($image) {
        return config('params.media_link') . '/storage/' . $folder . '/' . $image;
    }
    return noImage();
}


/*
 * image saved function
 */
function imageSaved($file, $fileName, $folderName, $oldFileName = null)
{
    $file = new CURLFile($file, 'image/jpeg', $fileName);
    $fields_string = [
        'file' => $file,
        'fileName' => $fileName,
        'folderName' => $folderName,
        'oldFileName' => $oldFileName,
    ];
    $url = config('app.imageUplaodUrl');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}



/*
 * file saved function
 */
function fileUpload($file, $fileName, $folderName)
{
    $file = new \CURLFile($file);
    $fields_string = [
        'file' => $file,
        'fileName' => $fileName,
        'folderName' => $folderName,
    ];
    $url = config('app.imageUplaodUrl');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


/*
 * no image function
 */
function noImage(): string
{
    return config('app.noImage');
}

////////////////////////////////////////////////////Image APIs////////////////////////////////////////////////////////

/*
 * random generate string
 */
function generateRandomString($length = 20)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}

// function university()
// {
//     return AboutUniversity::with(['type', 'form'])
//         ->where('status', 'active')
//         ->first();
// }

function firstUpperLetter($string)
{
    preg_match('/^G\'|^O\'|^S[h,H]|^C[h,H]/', $string, $matches);
    if (!$matches) {
        return substr($string, 0, 1);
    }
    return $matches[0];
}