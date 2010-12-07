<?php

    // VERSION
    $conf['VERSION'] = 000001;

    // LOCATION
    $conf['ROOT_PATH']  = 'http://localhost/opipop/';
    $conf['ROOT_DIR']   = '/Users/USER_NAME/Sites/opipop/';
    $conf['MEDIA_PATH'] = 'http://localhost/opipop/media/';
    $conf['MEDIA_DIR']  = '/Users/USER_NAME/Sites/opipop/media/';

    // DATABASE
    $conf['DB_NAME']     = 'opipop';
    $conf['DB_HOST']     = 'localhost';
    $conf['DB_USER']     = 'root';
    $conf['DB_PASS']     = '';
    $conf['DB_PRE']      = '';
    $conf['DB_READONLY'] = false;

    // CACHE
    $conf['CACHE_TIMECOEF'] = 0;

    // ENV
    $conf['PROD'] = false;

    // AUTH
    $conf['AUTH_ENABLED']  = false;
    $conf['AUTH_USER']     = '';
    $conf['AUTH_PASSWORD'] = '';

    // EMAIL
    $conf['ADMIN_EMAIL'] = '';

    // IMAGES
    $conf['AVATAR_SMALL_SIZE']    = '24x24';
    $conf['AVATAR_MEDIUM_SIZE']   = '50x50';
    $conf['AVATAR_LARGE_SIZE']    = '160x160';
    $conf['QUESTION_MEDIUM_SIZE'] = '315x145';

    // CONTENT
    $conf['SITE_NAME']         = 'Opipop';
    $conf['PAGE_TITLE']        = utf8_encode('Opipop');
    $conf['PAGE_DESCRIPTION']  = utf8_encode('');
    $conf['PAGE_KEYWORDS']     = utf8_encode('');
    $conf['QUESTION_DURATION'] = 86400 * 7;
    $conf['QUESTION_PER_PAGE'] = 4;
    $conf['USER_PER_PAGE']     = 8;
    $conf['MAIN_CATEGORY']     = 1;

    // GRAPH
    $conf['GRAPH_COLORS'] = array
    (
        '#42ABE1',
        '#E7579A',
        '#42ABE1',
        '#E7579A',
        '#42ABE1',
        '#E7579A',
    );

