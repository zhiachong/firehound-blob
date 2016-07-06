<?php

namespace PaperG\FirehoundBlob;


interface BlobInterface {
    /**
     * @return array
     */
    public function toArray();

    /**
     * @param $array array
     */
    public function fromArray($array);
} 
