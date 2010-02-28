<?php

class Model_Pagination
{
    private $currentPage = 0;
    private $itemPerPage = 0;
    private $totalItem = 0;
    private $page = 0;
    private $link = '';

    public function Model_Pagination()
    {
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function setItemPerPage($itemPerPage)
    {
        $this->itemPerPage = $itemPerPage;
    }

    public function setTotalItem($totalItem)
    {
        $this->totalItem = $totalItem;
    }

    public function compute($tpl)
    {
        $n         = 1;
        $page      = ($this->page == 0) ? 0 : $this->page -1;
        $totalPage = ceil($this->totalItem / $this->itemPerPage);

        for ($p = 0; $p < $totalPage; $p ++)
        {
            if ($p > 2 && $p < $this->page - 4)
            {
                $tpl->assignSection('pagination_space' . $n);
                $p = $this->page - 4;
                $n ++;
            }
            if ($p < $totalPage - 3 && $p > $this->page + 4)
            {
                $tpl->assignSection('pagination_space' . $n);
                $p = $totalPage - 3;
                $n ++;
            }
            $tpl->assignLoopVar('pagination_' . $n, array
            (
                'n'      => $p + 1,
                'link'   => $this->link . (($p == 0) ? '' : '/' . ($p + 1)),
                'class'  => ($p == $this->page) ? 'on' : 'off'
            ));
        }

        if ($totalPage > 1)
        {
            if ($this->page > 1)
            {
                $tpl->assignSection('pagination_prev');
            }
            if ($this->page < $totalPage)
            {
                $tpl->assignSection('pagination_next');
            }
            $tpl->assignSection('pagination');
            $tpl->assignVar(array
            (
                'pagination_next' => $this->link . '/' . ($this->page + 1),
                'pagination_prev' => $this->link . (($this->page == 0) ? '' : '/' . ($this->page - 1))
            ));
        }
    }


}

