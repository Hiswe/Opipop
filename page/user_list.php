<?php

include 'page/block/top.php';

// Select all user and count votes for each
$rs_user = $db->select('
    SELECT u.id, u.login, u.register_date, COUNT(u.id) AS `vote`
    FROM `user` AS `u`
    JOIN `user_result` AS `r` ON r.user_id=u.id
    GROUP BY u.id
    ORDER BY u.register_date DESC
', (($_GET['p'] > 0) ? $_GET['p'] - 1 : $_GET['p']) * USER_PER_PAGE, USER_PER_PAGE);

// List all users
foreach ($rs_user['data'] as $user)
{
    $tpl->assignLoopVar('user', array
    (
        'login' => $user['login'],
        'register_since' => timeWarp($user['register_date']),
        'vote' => $user['vote'],
    ));
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
        'link'   => 'users/' . (($p == 0) ? '' : $p + 1),
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
        'pagination_next' => 'users/' . ($_GET['p'] + 2),
        'pagination_prev' => 'users/' . (($_GET['p'] == 1) ? '' : '/' . $_GET['p'])
    ));
}

