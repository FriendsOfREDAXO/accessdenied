<?php

use FriendsOfRedaxo\Accessdenied\Accessdenied;

// Initialize SearchIt prevention
Accessdenied::initializeSearchItPrevention();

// Add status for locked articles and categories
if (rex::isBackend()) {
    rex_extension::register(['ART_STATUS_TYPES', 'CAT_STATUS_TYPES'], [Accessdenied::class, 'addLockedStatus']);
    if (rex_addon::get('quick_navigation')->isAvailable()) {
        rex_view::addCssFile($this->getAssetsUrl('accessdenied_qn.css'));
    }
}

// Handle frontend redirects
if (rex::isFrontend()) {
    rex_extension::register('PACKAGES_INCLUDED', [Accessdenied::class, 'handleFrontendRedirect'], rex_extension::LATE);
}

if (rex::isBackend()) {
    // Set default status on new articles and categories
    rex_extension::register('ART_ADDED', [Accessdenied::class, 'setDefaultArticleStatus']);
    rex_extension::register('CAT_ADDED', [Accessdenied::class, 'setDefaultCategoryStatus']);

    $catclocked = false;
    $cat = rex_category::getCurrent();
    $package = rex_addon::get('accessdenied');
    // Check inherit category status
    if ($package->getConfig('inherit') == true && $cat && $cat->getClosest(fn (rex_category $cat) => 2 == $cat->getValue('status'))) {
        $catclocked = true;
    }
    $art = rex_article::getCurrent();
    if ($art && $art->getValue('status') == 2 || true == $catclocked) {
        rex_extension::register('STRUCTURE_CONTENT_SIDEBAR', [Accessdenied::class, 'addContentSidebar']);
    }
}
