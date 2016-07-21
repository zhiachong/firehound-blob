<?php

namespace PaperG\ScenarioBlob;


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
