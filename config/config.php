<?php

return [

    /**
     * When the patch number reaches this value, 
     * the minor version number will be incremented and the patch number will be reset.
     * i.e. 1.0.99 -> 1.1.0
     * Defaults to 99
     */
    'max_patch' => 99,

    /**
     * When the minor number reaches this value, 
     * the major version number will be incremented and the minor number will be reset.
     * i.e. 1.99.0 -> 2.0.0
     * Defaults to 99
     */
    'max_minor' => 99,
];