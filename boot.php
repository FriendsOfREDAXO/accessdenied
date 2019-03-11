<?php

/**
 * accessdenied Addon.
 *
 * @author Friends Of REDAXO
 *
 * @var rex_addon
 */
if (rex::isBackend()) {
    rex_extension::register(['ART_STATUS_TYPES', 'CAT_STATUS_TYPES'], function (rex_extension_point $ep) {
        $subject = $ep->getSubject();
        $subject[] = array(rex_i18n::msg('accessdenied_blocked'), 'rex-offline', 'rex-icon-offline');
        $ep->setSubject($subject);

        return $ep->getSubject();
    });
    if (rex_addon::get('quick_navigation')->isAvailable()) {
        rex_view::addCssFile($this->getAssetsUrl('accessdenied_quicknavi.css'));
    }
} else {
    rex_extension::register('PACKAGES_INCLUDED', function () {
        if (rex_article::getCurrent() instanceof rex_article && rex_article::getCurrent()->getValue('status') == 2 && !rex_backend_login::hasSession()) {
            rex_redirect(rex_article::getNotfoundArticleId(), rex_clang::getCurrentId());
        }
    }, rex_extension::LATE);
}
