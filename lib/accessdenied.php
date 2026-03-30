<?php

namespace FriendsOfRedaxo\Accessdenied;

use rex;
use rex_addon;
use rex_extension_point;
use rex_article;
use rex_category;
use rex_clang;
use rex_response;
use function rex_redirect;
use function rex_server;
use rex_backend_login;
use rex_i18n;
use rex_fragment;
use rex_url;
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
        if ($cat !== null && $package->getConfig('inherit') == true && $cat->getClosest(static fn (rex_category $cat) => 2 == $cat->getValue('status'))) {
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

    private static function getClientIp(): string
    {
        return rex_server('REMOTE_ADDR', 'string', '');
    }

    private static function isIpWhitelisted(): bool
    {
        $whitelist = (string) rex_addon::get('accessdenied')->getConfig('ip_whitelist', '');
        if ($whitelist === '') {
            return false;
        }
        $clientIp = self::getClientIp();
        if ($clientIp === '') {
            return false;
        }
        $ips = array_map('trim', explode("\n", $whitelist));
        return array_find($ips, static fn(string $ip) => $ip === $clientIp) !== null;
    }

    public static function handleFrontendRedirect(): void
    {
        $package = rex_addon::get('accessdenied');
        $linkparameter = $package->getConfig('linkparameter') ?? 'preview';

        if (self::isIpWhitelisted()) {
            return;
        }

        if ($package->getConfig('inherit') == true && rex_category::getCurrent() != null) {
            $cat = rex_category::getCurrent();
            if ($cat->getClosest(static fn (rex_category $cat) => 2 == $cat->getValue('status')) && 
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
        $articleId = (int) $params['article_id'];
        $clangId = (int) ($params['clang'] ?? rex_clang::getCurrentId());

        $art = rex_article::get($articleId, $clangId);
        $cat = $art?->getCategory();

        // Detect whether the lock is inherited from a parent category
        $inheritedFromCat = null;
        if ($package->getConfig('inherit') && $cat !== null && $art?->getValue('status') != 2) {
            $inheritedFromCat = $cat->getClosest(static fn (rex_category $c) => 2 == $c->getValue('status'));
        }

        if (rex_addon::get('yrewrite')->isAvailable()) {
            $baseUrl = rex_yrewrite::getFullUrlByArticleId($articleId);
        } else {
            $baseUrl = rtrim(\rex::getServer(), '/') . \rex_getUrl($articleId);
        }

        $shareUrl = $baseUrl . '?' . rex_escape((string) $linkparameter) . '=id-' . $articleId;
        $inputId = 'sharelink-' . $articleId;

        $panel = '<div class="alert alert-info">'
            . rex_i18n::msg('accessdenied_share')
            . '<br><strong id="' . $inputId . '">' . rex_escape($shareUrl) . '</strong>'
            . '<p><clipboard-copy for="' . $inputId . '" class="btn btn-sm btn-primary">'
            . rex_i18n::msg('copy_to_clipboard')
            . '</clipboard-copy></p>'
            . '</div>';

        // If locked via inheritance: show navigation link to the source category
        if ($inheritedFromCat instanceof rex_category) {
            $catUrl = rex_url::backendController([
                'page' => 'structure',
                'category_id' => $inheritedFromCat->getParentId(),
                'clang' => $clangId,
            ]);
            $panel .= '<p class="text-muted" style="margin:8px 0 4px">'
                . '<i class="fa fa-sitemap"></i> '
                . rex_i18n::msg('accessdenied_inherited_from')
                . ' <strong>' . rex_escape($inheritedFromCat->getName() ?? '') . '</strong>'
                . '</p>'
                . '<a href="' . $catUrl . '" class="btn btn-sm btn-warning">'
                . '<i class="fa fa-arrow-right"></i> '
                . rex_i18n::msg('accessdenied_goto_source_category')
                . '</a>';
        }

        $fragment = new rex_fragment();
        $fragment->setVar('title', '<i class="fa fa-exclamation-triangle accessdenied-warning-icon"></i> ' . rex_i18n::msg('accessdenied_info'), false);
        $fragment->setVar('body', $panel, false);
        $fragment->setVar('article_id', $articleId, false);

        $fragment->setVar('collapse', true);
        $fragment->setVar('collapsed', false);
        $content = $fragment->parse('core/page/section.php');

        return $content . $subject;
    }
}
