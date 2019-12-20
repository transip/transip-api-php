<?php


namespace Transip\Api\Client;

class FilesystemAdapter
{
    /**
     * Save to a temporary file
     *
     * @param string $fileName
     * @param string $content
     */
    public function saveTempFile(string $fileName, string $content): void
    {
        file_put_contents("{$this->getSystemTempDirectory()}/{$fileName}", $content);
    }

    /**
     * Read from a temporary file
     *
     * @param string $fileName
     * @return string|null file context
     */
    public function readTempFile(string $fileName): ?string
    {
        $read = file_get_contents("{$this->getSystemTempDirectory()}/{$fileName}");
        if ($read === false) {
            return null;
        }
        return $read;
    }

    /**
     * Find the system temp directory
     *
     * @return string system temp directory path
     */
    protected function getSystemTempDirectory(): string
    {
        $systemTempDirectory = sys_get_temp_dir() . '/transip-cache';
        if (!file_exists($systemTempDirectory . '/.')) {
            @mkdir($systemTempDirectory, 0700, true);
        }
        return $systemTempDirectory;
    }
}
