<?php

use FriendsOfRedaxo\Accessdenied\Accessdenied;

// Initialize SearchIt prevention
Accessdenied::initializeSearchItPrevention();

// Add status for locked articles and categories
if (rex::isBackend()) {
    rex_extension::register('PACKAGES_INCLUDED', static function () {
        $locale = rex_i18n::getLocale();
        $raw = (string) rex_addon::get('accessdenied')->getConfig('offline_labels', '');
        foreach (array_filter(array_map('trim', explode("\n", $raw))) as $line) {
            [$lang, $label] = array_pad(explode('|', $line, 2), 2, '');
            if (trim($lang) === $locale && trim($label) !== '') {
                rex_i18n::addMsg('status_offline', trim($label));
                break;
            }
        }
    }, rex_extension::EARLY);

    rex_extension::register(['ART_STATUS_TYPES', 'CAT_STATUS_TYPES'], [Accessdenied::class, 'addLockedStatus'], rex_extension::EARLY);
    rex_view::addCssFile($this->getAssetsUrl('accessdenied_qn.css'));
    rex_view::addJsFile($this->getAssetsUrl('accessdenied.js'));
}

// Handle frontend redirects
if (rex::isFrontend()) {
    rex_extension::register('PACKAGES_INCLUDED', [Accessdenied::class, 'handleFrontendRedirect'], rex_extension::LATE);
}

if (rex::isBackend()) {
    // Set default status on new articles and categories
    rex_extension::register('ART_ADDED', [Accessdenied::class, 'setDefaultArticleStatus']);
    rex_extension::register('CAT_ADDED', [Accessdenied::class, 'setDefaultCategoryStatus']);

    // Register sidebar extension via extension point to avoid early category/article access
    rex_extension::register('PACKAGES_INCLUDED', static function() {
        $catlocked = false;
        $cat = rex_category::getCurrent();
        $package = rex_addon::get('accessdenied');
        // Check inherit category status
        if ($package->getConfig('inherit') == true && $cat && $cat->getClosest(static fn (rex_category $cat) => 2 == $cat->getValue('status'))) {
            $catlocked = true;
        }
        $art = rex_article::getCurrent();
        if ($art && $art->getValue('status') == 2 || true == $catlocked) {
            rex_extension::register('STRUCTURE_CONTENT_SIDEBAR', [Accessdenied::class, 'addContentSidebar']);
        }
    }, rex_extension::LATE);
}
