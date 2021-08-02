<?php
declare(strict_types=1);

namespace App;

/**
 * Trait FileTrait
 * @package App
 * @author  Abolarin Stephen <hackzlord@gmail.com>
 */
trait FileTrait
{
    /**
     * @param string $filePath
     * @return string
     */
    public function getMimeType(string $filePath): string
    {
        if (!file_exists($filePath)) {
            return '';
        }

        $file_info = new \finfo(FILEINFO_MIME_TYPE);
        return $file_info->file($filePath);
    }
}
