<?php

// INDEX PREVENT in SEARCH_IT

if (rex_addon::get('search_it')->isAvailable()) {
    rex_extension::register('SEARCH_IT_INDEX_ARTICLE', function (rex_extension_point $ep) {
        $package = rex_addon::get('accessdenied');
        $article = $ep->getParam('article');
        $cat = $article->getCategory();
        if ($article->getValue('status') == 2) {
            return false; 
        }
        if ($package->getConfig('inherit') == true && $cat->getClosest(fn (rex_category $cat) => 2 == $cat->getValue('status')) ) {
            return false; 
        }
    });
}


// Add status for locked articles and categories
if (rex::isBackend()) {
    rex_extension::register(['ART_STATUS_TYPES', 'CAT_STATUS_TYPES'], function (rex_extension_point $ep) {
        $subject = $ep->getSubject();
        $subject[] = array(rex_i18n::msg('accessdenied_locked'), 'rex-offline', 'fa fa-exclamation-triangle');
        $ep->setSubject($subject);
        return $ep->getSubject();
    });
    if (rex_addon::get('quick_navigation')->isAvailable()) {
        rex_view::addCssFile($this->getAssetsUrl('accessdenied_qn.css'));
    }
}

// redirect to not foundArticle if not logged in or link parameter not set. 
if (rex::isFrontend()) {
    rex_extension::register('PACKAGES_INCLUDED', function () {
        $package = rex_addon::get('accessdenied');
        $linkparameter = $package->getConfig('linkparameter') ?? 'preview';
        // check inherit category status
        if ($package->getConfig('inherit') == true &&  rex_category::getCurrent() != null) {
            $cat = rex_category::getCurrent();
            if ($cat->getClosest(fn (rex_category $cat) => 2 == $cat->getValue('status')) && rex_request($linkparameter, 'string', '')  != 'id-' . rex_article::getCurrent()->getId()  && !rex_backend_login::hasSession()) {
                rex_response::setStatus(rex_response::HTTP_MOVED_TEMPORARILY);
                rex_redirect(rex_article::getNotfoundArticleId(), rex_clang::getCurrentId());
            }
        }
        if (rex_article::getCurrent() instanceof rex_article && rex_request($linkparameter, 'string', '') != 'id-' . rex_article::getCurrent()->getId() && rex_article::getCurrent()->getValue('status') == 2 && !rex_backend_login::hasSession()) {
            rex_response::setStatus(rex_response::HTTP_MOVED_TEMPORARILY);
            rex_redirect(rex_article::getNotfoundArticleId(), rex_clang::getCurrentId());
        }
    }, rex_extension::LATE);
}

if (rex::isBackend()) {
    // set a default status on new articles
    rex_extension::register('ART_ADDED', ['accessdenied', 'setDefaultArticleStatus']);
    rex_extension::register('CAT_ADDED', ['accessdenied', 'setDefaultCategoryStatus']);

    $catclocked = false;
    $cat = rex_category::getCurrent();
    $package = rex_addon::get('accessdenied');
    $linkparameter = $package->getConfig('linkparameter');
    // check inherit category status
    if ($package->getConfig('inherit') == true && $cat && $cat->getClosest(fn (rex_category $cat) => 2 == $cat->getValue('status'))) {
        $catclocked = true;
    }
    $art = rex_article::getCurrent();
    if ($art && $art->getValue('status') == 2 || true == $catclocked) {
        rex_extension::register('STRUCTURE_CONTENT_SIDEBAR', function (rex_extension_point $ep) {
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
        });
    }
}
