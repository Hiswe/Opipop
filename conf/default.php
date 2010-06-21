<?php

    // VERSION
    $conf['VERSION'] = 000001;

    // LOCATION
    $conf['ROOT_PATH'] = 'http://localhost/sondage/';
    $conf['ROOT_DIR']  = '/Users/USER_NAME/Sites/sondage/';

    // DATABASE
    $conf['DB_NAME']   = 'sondage';
    $conf['DB_HOST']   = 'localhost';
    $conf['DB_USER']   = 'root';
    $conf['DB_PASS']   = '';
    $conf['DB_PRE']    = '';

    // CACHE
    $conf['CACHE_TIMECOEF'] = 0;

    // ENV
    $conf['PROD'] = false;

    // EMAIL
    $conf['ADMIN_EMAIL'] = '';

    // IMAGES
    $conf['AVATAR_SMALL_SIZE']    = '25x25';
    $conf['AVATAR_MEDIUM_SIZE']   = '50x50';
    $conf['AVATAR_LARGE_SIZE']    = '140x140';
    $conf['QUESTION_MEDIUM_SIZE'] = '315x145';

    // CONTENT
    $conf['SITE_NAME']         = 'Opipop';
    $conf['PAGE_TITLE']        = utf8_encode ('Opipop');
    $conf['PAGE_DESCRIPTION']  = utf8_encode ('');
    $conf['PAGE_KEYWORDS']     = utf8_encode ('');
    $conf['QUESTION_DURATION'] = 86400 * 7;
    $conf['QUESTION_PER_PAGE'] = 4;
    $conf['MAIN_CATEGORY']     = 1;

    // GRAPH
    $conf['GRAPH_COLORS'] = array
    (
        'CornflowerBlue',
        'Fuchsia',
        'AliceBlue',
        'Lavender',
        'PaleGreen',
    );

