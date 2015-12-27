<?php

namespace Cebera\ImageManager;

class ImageController
{
    public static function uploadAction()
    {
        \Cebera\Helpers::exit404If(!(count($_FILES) > 0));

        $file = $_FILES[0];

        $target_folder_in_images = '';

        if (array_key_exists('target_folder', $_POST)){
            $target_folder_in_images = $_POST['target_folder'];
        }

        echo self::processUpload($file, $target_folder_in_images);

        return;
    }

	public static function uploadToImagesAction()
    {
        \Cebera\Helpers::exit404If(!(count($_FILES) > 0));

        $file = $_FILES['file'];

        $root_images_folder = \Cebera\ImageManager\ImageConstants::IMG_ROOT_FOLDER;

        $target_folder_in_images = '';

        if (array_key_exists('target_folder', $_POST)){
            $target_folder_in_images = $_POST['target_folder'];
        }

        /*
        $force_file_extension = true;
        if (array_key_exists('not_force_file_extension', $_POST)){
            $force_file_extension = false;
        }
        */
        $force_file_extension = false;

        $file_name = self::processUpload($file, $target_folder_in_images, $root_images_folder, $force_file_extension);

        $response = array(
            'fileName' => $file_name,
            'filePath' => $root_images_folder,
        );

        header('Content-Type: application/json');

        echo json_encode($response);

        return;
    }

    /**
     * Returns internal file name
     * 
     * @param $file
     * @param $target_folder_in_images
     * @param string $root_images_folder
     * @param bool|true $force_file_extension
     * @return string
     */
    public static function processUpload($file, $target_folder_in_images, $root_images_folder = '', $force_file_extension = true)
    {
        $allowed_extensions = array("gif", "jpeg", "jpg", "png");
        $allowed_types = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");

        $pathinfo = pathinfo($file["name"]);
        $file_extension = mb_strtolower($pathinfo['extension']);

        \Cebera\Helpers::exit404If(!in_array($file["type"], $allowed_types));
        \Cebera\Helpers::exit404If(!in_array($file_extension, $allowed_extensions));

        \Cebera\Helpers::exit404If($file["error"] > 0);

        $image_manager = new \Cebera\ImageManager\ImageManager($root_images_folder);
        $internal_file_name = $image_manager->storeUploadedImageFile($file["name"], $file["tmp_name"], $target_folder_in_images, $force_file_extension);
        \Cebera\Helpers::exit404If(!$internal_file_name);

        return $internal_file_name;
    }
} 