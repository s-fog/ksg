<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

class Pagination
{
    public static function pagination($allProductCount, $page, $limit) {
        if ($limit >= $allProductCount) {
            return [
                'html' => '',
                'prev' => '',
                'next' => ''
            ];
        } else {
            $pages = [];
            $_GET['page'] = (isset($_GET['page']))? $_GET['page'] : 1;
            $lastPage = ceil($allProductCount / $limit);
            $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
            $differentParams = [];
            foreach($_GET as $name => $value) {
                if ($name == 'sort' || $name == 'per_page') {
                    $differentParams[] = "$name=$value";
                }
            }

            $difPQ = (!empty($differentParams)) ? '?'.implode('&', $differentParams) : '';
            $difPB = (!empty($differentParams)) ? '&'.implode('&', $differentParams) : '';
            $prev = (($_GET['page'] - 1) == 1)? $uri_parts[0] . $difPQ : $uri_parts[0] . $difPQ . '?page=' . ($_GET['page'] - 1) . $difPB;

            if ($page != 1) {
                $pages[] = '<li><a href="' . $uri_parts[0] . $difPQ . '" class="pagination__item pagination__first">&lt;&lt;</a></li>';
                $pages[] = '<li><a href="' . $prev . '" class="pagination__item pagination__first">&lt;</a></li>';
            }

            for($i = 1; $i <= $lastPage; $i++) {
                $link = ($i == 1)? $uri_parts[0].$difPQ : $uri_parts[0] . '?page=' . $i . $difPB;
                if ($i == $page) {
                    $pages[] = '<li class="active"><span class="pagination__item">' . $i . '</span></li>';
                } else {
                    $pages[] = '<li><a href="' . $link . '" class="pagination__item">' . $i . '</a></li>';
                }
            }

            if ($page != $lastPage) {
                $pages[] = '<li><a href="' . $uri_parts[0] . '?page=' . ($page + 1) . $difPB . '" class="pagination__item pagination__last">&gt;</a></li>';
                $pages[] = '<li><a href="' . $uri_parts[0] . '?page=' . ($lastPage) . $difPB . '" class="pagination__item pagination__last">&gt;&gt;</a></li>';
            }

            $prev = '';
            $next = '';

            if ($page != 1) {
                $prev = 'https://'.$_SERVER['HTTP_HOST'].$uri_parts[0] . '?page='. ($page - 1) . $difPB;
            }

            if ($page != $lastPage) {
                $next = 'https://'.$_SERVER['HTTP_HOST'].$uri_parts[0] . '?page='. ($page + 1) . $difPB;
            }

            return [
                'html' => '<div class="pagination"><ul class="pagination__inner">'.implode('', $pages).'</ul></div>',
                'prev' => $prev,
                'next' => $next
            ];
        }
    }
}