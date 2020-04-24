<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Main directory
    |--------------------------------------------------------------------------
    | 
    | Location where your files will be stored
    |
    */

    'main_dir' => 'uploads',

    /*
    |--------------------------------------------------------------------------
    | Thumb directory
    |--------------------------------------------------------------------------
    | 
    | Location where your thumb files will be stored
    |
    */

    'thumb_dir' => 'uploads/thumb',

    /*
    |--------------------------------------------------------------------------
    | Image sizes
    |--------------------------------------------------------------------------
    | 
    | Thumb images sizes for crop
    |
    */
   
    'image_sizes' => [
        // Catalog
        'image' => [
            // Sizes
            // 'folder_name' => [w,h]
            '200x200' => [200, 200],
        ],

        'review' => [
            
            '300x300' => [300, 300],
        ]
        
    ],

    /*
    |--------------------------------------------------------------------------
    | Alphabet
    |--------------------------------------------------------------------------
    |
    | This alphabet is used by the Upload class and should be set
    | to a random, 64 character string array, otherwise these encrypted folders
    | will not be safe. Please do this before deploying an application!
    |
    */
   
    'alphabet' => ['T','o','m','u','z','j', 'p', '_', 'B', 'f', 'S', 'c', 'O', '6', '-', '3', 'R', 'w', 'l', 'A', 'M',  'I', 'J', 'k', 'y', 'E', 'v', '4', '5', '2',  'C',  'H',  'K', 'b', 'W', '7', 'q', 'P', 'U', 's', 'h', 'V', 'Q', '0', 'G', 'n', 'F', 'x', 'e', 't',  'Y', '1', 'd', '8', 'L', 'i', 'a', 'D', 'Z', 'g', 'X', 'N', '9', 'r']

];
