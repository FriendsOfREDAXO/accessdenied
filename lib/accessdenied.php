<?php

namespace FriendsOfRedaxo\Accessdenied;

use rex_addon;
use rex_extension_point;
use rex_article;
use rex_category;
use rex_clang;
use rex_response;
use rex_redirect;
use rex_backend_login;
use rex_i18n;
use rex_fragment;
use rex_yrewrite;

class Accessdenied
{
    public static function initializeSearchItPrevention(): void
    {
        if (rex_addon::get('search_it')->isAvailable()) {
            \rex_extension::register('SEARCH_IT_INDEX_ARTICLE', [self::class, 'preventSearchItIndexing']);
        }
    }

    public static function preventSearchItIndexing(rex_extension_point $ep): bool
    {
        $package = rex_addon::get('accessdenied');
        $article = $ep->getParam('article');
        $cat = $article->getCategory();
        if ($article->getValue('status') == 2) {
            return false;
        }
        if ($package->getConfig('inherit') == true && $cat->getClosest(fn (rex_category $cat) => 2 == $cat->getValue('status'))) {
            return false;
        }
        return true;
    }

    public static function addLockedStatus(rex_extension_point $ep): array
    {
        $subject = $ep->getSubject();
        $subject[] = [rex_i18n::msg('accessdenied_locked'), 'rex-offline', 'fa fa-exclamation-triangle'];
        return $subject;
    }

    public static function handleFrontendRedirect(): void
    {
        $package = rex_addon::get('accessdenied');
        $linkparameter = $package->getConfig('linkparameter') ?? 'preview';
        
        if ($package->getConfig('inherit') == true && rex_category::getCurrent() != null) {
            $cat = rex_category::getCurrent();
            if ($cat->getClosest(fn (rex_category $cat) => 2 == $cat->getValue('status')) && 
                rex_request($linkparameter, 'string', '') != 'id-' . rex_article::getCurrent()->getId() && 
                !rex_backend_login::hasSession()) {
                self::redirectToNotFound();
            }
        }
        
        if (rex_article::getCurrent() instanceof rex_article && 
            rex_request($linkparameter, 'string', '') != 'id-' . rex_article::getCurrent()->getId() && 
            rex_article::getCurrent()->getValue('status') == 2 && 
            !rex_backend_login::hasSession()) {
            self::redirectToNotFound();
        }
    }

    private static function redirectToNotFound(): void
    {
        rex_response::setStatus(rex_response::HTTP_MOVED_TEMPORARILY);
        rex_redirect(rex_article::getNotfoundArticleId(), rex_clang::getCurrentId());
    }

    public static function setDefaultArticleStatus(rex_extension_point $ep): void
    {
        $articleId = $ep->getParams()['id'];
        $clangId = $ep->getParams()['clang'];
        $defaultStatus = rex_addon::get('accessdenied')->getConfig('default_status');

        \rex_article_service::articleStatus($articleId, $clangId, $defaultStatus);
    }

    public static function setDefaultCategoryStatus(rex_extension_point $ep): void
    {
        $categoryId = $ep->getParams()['id'];
        $clangId = $ep->getParams()['clang'];
        $defaultStatus = rex_addon::get('accessdenied')->getConfig('default_status');

        \rex_category_service::categoryStatus($categoryId, $clangId, $defaultStatus);
    }

    public static function addContentSidebar(rex_extension_point $ep): string
    {
        $params = $ep->getParams();
        $subject = $ep->getSubject();
        $package = rex_addon::get('accessdenied');
        $linkparameter = $package->getConfig('linkparameter');
        $panel = '<div class="alert alert-info">' . rex_i18n::msg('accessdenied_share') . '<br><strong id="sharelink">' . rex_yrewrite::getFullUrlByArticleId($params["article_id"]) . '?'.$linkparameter.'=id-' . rex_article::getCurrent()->getId() . '</strong>
        <p><clipboard-copy for="sharelink" class="btn btn-small btn-copy btn-primary">'. rex_i18n::msg('copy_to_clipboard') .'</clipboard-copy></p> </div>';

        $fragment = new rex_fragment();
        $fragment->setVar('title', '<i class="fa fa-exclamation-triangle" style="color: red"></i> ' . rex_i18n::msg('accessdenied_info'), false);
        $fragment->setVar('body', $panel, false);
        $fragment->setVar('article_id', $params["article_id"], false);

        $fragment->setVar('collapse', true);
        $fragment->setVar('collapsed', false);
        $content = $fragment->parse('core/page/section.php');

        return $subject . $content;
    }
}
