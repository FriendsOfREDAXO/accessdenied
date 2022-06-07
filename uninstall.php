<?php
// set locked articles to offline 
$update = rex_sql::factory();
$update->setQuery('UPDATE '.rex::getTablePrefix().'article SET status=0 WHERE status = 2');
rex_addon::get('structure')->clearCache();
