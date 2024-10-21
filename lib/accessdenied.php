<?php

namespace FriendsOfRedaxo\Accessdenied;

use rex_category_service;
use rex_article_service;
use rex_config;
use rex_extension_point;

class Accessdenied
{
    public static function setDefaultCategoryStatus(rex_extension_point $ep): void
    {
        $categoryId = $ep->getParams()['id'];
        $clangId = $ep->getParams()['clang'];
        $defaultStatus = rex_config::get("accessdenied", "default_status");

        rex_category_service::categoryStatus($categoryId, $clangId, $defaultStatus);
    }

    public static function setDefaultArticleStatus(rex_extension_point $ep): void
    {
        $articleId = $ep->getParams()['id'];
        $clangId = $ep->getParams()['clang'];
        $defaultStatus = rex_config::get("accessdenied", "default_status");

        rex_article_service::articleStatus($articleId, $clangId, $defaultStatus);
    }
}
