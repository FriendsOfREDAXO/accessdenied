<?php
// set locked articles to offline 
$uninstall = rex_sql::factory();
$uninstall->setQuery('UPDATE '.rex::getTablePrefix().'article SET status=0 WHERE status = 2');
rex_addon::get('structure')->clearCache();
