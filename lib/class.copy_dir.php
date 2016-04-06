<?php

/**
 * Copies a Directory Contents to new Directory
 * http://www.fijiwebdesign.com/blog/copy-folders-and-files-php-filesystem-functions.html
 */
class copy_dir {

    private $dir1;
    private $dir2;
    private $errtxt;
    private $overwrite_files;
    private $recurse;
    private $copy_callback;
    private $copy;

    public function __construct() {

        $this->overwrite_files = false;
        $this->recursive = false;
        $this->copy_callback = false;
        $this->copy = new stdClass();
    }

    /**
     * Set the directory to copy from
     */
    public function setCopyFromDir($dir) {
        if (!is_dir($dir)) {
            $this->_error('The supplied argument, ' . $dir . ', is not a valid directory path!');
            return false;
        }
        $this->dir1 = $dir;
        return true;
    }

    /**
     * Set the directory to copy to
     */
    public function setCopyToDir($dir) {
        if (!is_dir($dir)) {
            if (!mkdir($dir)) {
                $this->_error('Could not create directory, ' . $dir);
                return false;
            }
        }
        $this->dir2 = $dir;
        return true;
    }

    /**
     * Set if we want to copy sub folders or not
     * @param bool TRUE or FALSE
     */
    public function copySubFolders($bool = true) {
        $this->recurse = $bool;
    }

    /**
     * Set if we want to overwrite existing files or not
     * @param bool TRUE or FALSE
     */
    public function overWriteFiles($bool = true) {
        $this->overwrite_files = $bool;
    }

    /**
     * Set a callback function to be executed each time a file or sub folder is copied
     * @param string callback function name
     */
    public function setCopyCallback($fn) {
        $this->copy_callback = $fn;
    }

    /**
     * Create the directory copy
     * @param bool Recurse through sub directories?
     */
    public function createCopy() {
        if (!is_dir($this->dir1)) {
            $this->_error('Directory to copy from is not a directory. Set the directory using setCopyFromDir()');
            return false;
        }
        if (!is_dir($this->dir2)) {
            $this->_error('Directory to copy to is not a directory. Set the directory using setCopyToDir()');
            return false;
        }

        // all set, start copy
        if ($this->_makeCopy($this->dir1, $this->dir2)) {
            return true;
        }
        return false;
    }

    private function _makeCopy($dir1, $dir2) {
        if ($dh = opendir($dir1)) {
            $i = 0;
            $dirArr = array();
            while ($el = readdir($dh)) {
                $path1 = $dir1 . '/' . $el;
                $path2 = $dir2 . '/' . $el;
                $this->_setCopyStatus($path1, $path2);

                if (is_dir($path1) && $el != '.' && $el != '..') {
                    if (is_dir($path2)) {
                        if (!$this->recurse) continue;
                    }
                    if (!is_dir($path2) && !mkdir($path2)) {
                        $this->_error('Could not create new directory, ' . $path2);
                        return false;
                    }
                    if ($this->recurse) { // copy sub directories recursively
                        $this->_makeCopy($path1, $path2);
                    }
                } elseif (is_file($path1)) {
                    if (is_file($path2) && !$this->overwrite_files) {
                        $this->_error("Duplicate File Exists, when trying to copy file: $path1, to $path2.<br /> Set overWriteFiles() if you need to overwrite existing files.");
                        return false;
                    }
                    if (!copy($path1, $path2)) {
                        $this->_error('Could not copy file, ' . $path1 . ', to ' . $path2);
                        return false;
                    }
                }
                $i++;
            }
            closedir($dh);
            return true;
        } else {
            $this->_error('Could not open the directory, ' . $dir1);
        }
        return false;
    }

    private function _setCopyStatus($path1, $path2) {
        $this->copy->oldfile = $path1;
        $this->copy->newfile = $path2;
        $this->_callback();
    }

    private function _callback() {
        if ($this->copy_callback) {
            call_user_func($this->copy_callback, $this->copy);
        }
    }

    private function _error($txt) {
        $this->errtxt = $txt;
    }

    /**
     * View the last error logged
     */
    public function viewError() {
        return $this->errtxt;
    }

}

// this is our custom function which is called each time we are about to make a new file copy
// or create a new sub directory
function updateCopyProgress($copy) {
    $file1 = $copy->oldfile;
    $file2 = $copy->newfile;
    $type = is_dir($file1) ? 'dir' : 'file';

    if ($type == 'dir') {
        echo "Creating new Directory, $file2<br />";
    } else {
        echo "Copying $file1 to $file2<br />";
    }
    flush(); // send this to the browser
}

?>
