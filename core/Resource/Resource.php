<?php

namespace Core\Resource;

use Core\Helpers\Logger;
use Core\Helpers\Str;

final class Resource
{
    protected string $dir;

    final public function get(string $fileName, array $subFolder = [], int $type = BASE64_RESOURCES)
    {
        $path = $this->dir . "/" . implode("/", $subFolder) . "/" . $fileName;
        $this->dir = null;

        return resources($path, false, $type);
    }

    final public function dir(string $dir)
    {
        $this->dir = $dir;

        return $this;
    }

    final public function save($file, string $fileName = null, array $subFolder = [])
    {
        try {
            $fileName = $fileName ? $fileName : $file["name"];
            $fileName = str_replace(" ", "_", Str::generateRandomString() . "_" . $fileName);
            $fileError = $file["error"];
            $fileTmpName = $file["tmp_name"];
            $path = $this->dir . "/" . implode("/", $subFolder);
            $path = str_replace("/", "\\", __ROOT__ . "\\resources\\files\\" . $path);
            $dir = $path . $fileName;
            if (!is_dir($path)) mkdir($path, 0777, true);
            if ($fileError === UPLOAD_ERR_OK) move_uploaded_file($fileTmpName, $dir);
            $this->dir = "";

            return $dir;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
