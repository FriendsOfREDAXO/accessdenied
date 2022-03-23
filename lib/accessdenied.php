<?php

class accesdenied {
    
    public static function setDefaultStatus($ep)
    {
        return rex_article_service::articleStatus($ep->getParams()['id'], rex_config::get("accessdenied", "default_status"));
    }
}
