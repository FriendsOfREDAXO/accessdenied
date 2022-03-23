<?php

class accessdenied {
    
    public static function setDefaultCategoryStatus($ep)
    {
        rex_category_service::categoryStatus($ep->getParams()['id'], $ep->getParams()['clang'], rex_config::get("accessdenied", "default_status"));
    }
    public static function setDefaultArticleStatus($ep)
    {
        rex_article_service::articleStatus($ep->getParams()['id'], $ep->getParams()['clang'], rex_config::get("accessdenied", "default_status"));
    }
}
