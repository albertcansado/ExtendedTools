<?php

class ecache {

    public $dir;
    public $expires;
    public $file;

    public function __construct($expires = 1800) {
        $config = cmsms()->GetConfig();
        $this->expires = $expires;
        $this->dir = TMP_CACHE_LOCATION;
    }

    private function _file($key) {
        return $this->file = $this->dir . '/' . munge_string_to_url($key, true) . '.cache';
    }

    private function _set($key, $data) {
        if (!is_dir($this->dir) || !is_writable($this->dir))
            return false;

        // begin caching.
        if (!file_exists($this->file) || (filemtime($this->file) < (time() - $this->expires))) {
            $src = $data;
            $fh = fopen($this->file, 'w');
            fwrite($fh, $src);
            fclose($fh);
        }

        // ugly hacking ftw.
        return true;
    }

    public function get($key, $data, $expires = 1800) {
        $this->expires = $expires;
        $this->_file($key);
        if ($this->_set($key, $data))
            $cache = file_get_contents($this->file);

        $this->flush();
        return $cache ? $cache : $data;
    }

    public function is_cached($key) {
        $this->_file($key);

        if (file_exists($this->file) && filemtime($this->file) < (time() - $this->expires)) {
            return false;
        }
        return @file_get_contents($this->file);
    }

    public function clear($key) {
        $this->_file($key);

        return unlink($this->file);
    }

    private function flush() {
        clearstatcache();
    }

    public function __destruct() {
        $this->dir = null;
        $this->expires = null;
        $this->file = null;
    }

}

?>