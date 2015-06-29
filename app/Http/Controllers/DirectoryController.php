<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

class DirectoryController extends BaseController
{

    public function lookup(Filesystem $files, Request $request)
    {
        // Set up our variables.
        $query     = null;
        $directory = urldecode($request->get('query')) ?: '/';
        $up        = (bool)$request->get('up');

        // If we are going up one directory, handle it.
        if ($up == true) {
            list($directory, $query) = $this->removeLastDirectory($directory);
        }

        // Get all directories in the given directory.
        // If it fails, the directory does not exist, so return an empty array.
        try {
            $directories = $files->directories($directory);
        } catch (\Exception $e) {
            $directories = [];
        }

        return [
            'directories' => $directories,
            'query'       => $query
        ];
    }

    /**
     * Remove the last directory from a string.
     *
     * @param $directory
     *
     * @return array
     */
    protected function removeLastDirectory($directory)
    {
        // Separate the directory and remove the last element of the array
        $directoryParts = explode('/', $directory);
        array_pop($directoryParts);

        // Push the directory back together and set the new query string
        $directory = implode('/', $directoryParts);
        $query     = $directory;

        return [$directory, $query];
    }
}