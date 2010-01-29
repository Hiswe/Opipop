<?php

include 'page/block/top.php';

$friendList = array();
$waitingList = array();

// If a user are connected
if (isOk($_SESSION['user']))
{
    $userId = $_SESSION['user']['id'];

    // Select all my friends
    $rs_friend = $db->select('
        SELECT `user_id_1`, `user_id_2`, `valided`
        FROM `friend`
        WHERE `user_id_1`="' . $userId . '" OR `user_id_2`="' . $userId . '"
    ');
    foreach ($rs_friend['data'] as $friend)
    {
        $friendId = ($userId == $friend['user_id_1']) ? $friend['user_id_2'] : $friend['user_id_1'];
        if ($friend['valided'] == 0)
        {
            $waitingList[] = $friendId;
        }
        else
        {
            $friendList[] = $friendId;
        }
    }
}


$where = 'u.valided="1"';

// If we made a search
if (isOk($_GET['query']))
{
    $where .= ' AND u.login LIKE(\'' . getLikeList($_GET['query']) . '\')';

    $tpl->assignVar(array
    (
        'search_query' => utf8_encode(htmlspecialchars(rawurldecode(stripslashes($_GET['query']))))
    ));
}

// Select all user and count votes for each
$rs_user = $db->select('
    SELECT u.id, u.login, u.register_date, COUNT(u.id) AS `vote`
    FROM `user` AS `u`
    JOIN `user_result` AS `r` ON r.user_id=u.id
    WHERE ' . $where . '
    GROUP BY u.id
    ORDER BY u.register_date DESC
', (($_GET['p'] > 0) ? $_GET['p'] - 1 : $_GET['p']) * USER_PER_PAGE, USER_PER_PAGE);

// List all users
foreach ($rs_user['data'] as $user)
{
    if (in_array($user['id'], $waitingList))
    {
        $friendMessage = 'Cancel friend request';
        $friendAction  = 'cancel';
    }
    else if (in_array($user['id'], $friendList))
    {
        $friendMessage = 'Remove from friends';
        $friendAction  = 'remove';
    }
    else
    {
        $friendMessage = 'Add to friends';
        $friendAction  = 'add';
    }

    $tpl->assignLoopVar('user', array
    (
        'id'             => $user['id'],
        'login'          => $user['login'],
        'register_since' => timeWarp($user['register_date']),
        'vote'           => $user['vote'],
        'avatar'         => (file_exists(ROOT_DIR . 'media/avatar/' . AVATAR_SMALL_SIZE . '/' . $user['id'] . '.jpg')) ? AVATAR_SMALL_SIZE . '/' . $user['id'] . '.jpg' : AVATAR_SMALL_SIZE . '/0.jpg',
    ));

    // If a user are connected
    if (isOk($userId) && $userId != $user['id'])
    {
        $tpl->assignLoopVar('user.friendRequest', array
        (
            'message' => $friendMessage,
            'action'  => $friendAction,
        ));
    }
}

// Dress the pagination
$totalPage = ceil($rs_user['total'] / USER_PER_PAGE);
$n = 1;
if ($_GET['p'] > 0)
{
    $_GET['p'] --;
}
for ($p = 0; $p < $totalPage; $p ++)
{
    if ($p > 2 && $p < $_GET['p'] - 4)
    {
        $p = $_GET['p'] - 4;
        $tpl->assignSection('pagination_space' . $n);
        $n ++;
    }
    if ($p < $totalPage - 3 && $p > $_GET['p'] + 4)
    {
        $p = $totalPage - 3;
        $tpl->assignSection('pagination_space' . $n);
        $n ++;
    }
    $tpl->assignLoopVar('pagination_' . $n, array
    (
        'n'      => $p + 1,
        'link'   => 'users/' . ((isOk($_GET['query'])) ? 'search/' . $_GET['query'] . '/' : '') . (($p == 0) ? '' : $p + 1),
        'class'  => ($p == $_GET['p']) ? 'on' : 'off'
    ));
}
if ($totalPage > 1)
{
    if ($_GET['p'] > 0)
    {
        $tpl->assignSection('pagination_prev');
    }
    if ($_GET['p'] < $totalPage - 1)
    {
        $tpl->assignSection('pagination_next');
    }
    $tpl->assignSection('pagination');
    $tpl->assignVar(array
    (
        'pagination_next' => 'users/'. ((isOk($_GET['query'])) ? 'search/' . $_GET['query'] . '/' : '') . ($_GET['p'] + 2),
        'pagination_prev' => 'users/' . ((isOk($_GET['query'])) ? 'search/' . $_GET['query'] . '/' : '') . (($_GET['p'] == 1) ? '' : '/' . $_GET['p'])
    ));
}

