<?php

namespace Core\Resource;

use Core\Helpers\Logger;

final class Resource
{
    protected string $dir;

    final public function get(string $fileName, array $subFolder = [], int $type = BASE64_RESOURCES)
    {
        $path = $this->dir . "/" . implode("/", $subFolder) . "/" . $fileName;
        $this->dir = null;

        return resources($path, $type);
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
            $fileError = $file["error"];
            $fileTmpName = $file["tmp_name"];
            $path = $this->dir . "/" . implode("/", $subFolder) . "/";
            $path = str_replace("/", "\\", __ROOT__ . "\\resources\\" . $path);
            $dir = $path . $fileName;
            if (!is_dir($path)) mkdir($path);
            if ($fileError === UPLOAD_ERR_OK) move_uploaded_file($fileTmpName, $dir);
            $this->dir = null;

            return $dir;
        } catch (\Throwable $th) {
            Logger::write($th, "resource");

            return null;
        }
    }
}
