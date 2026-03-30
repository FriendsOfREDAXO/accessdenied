// Adds the current user's IP to the IP allowlist textarea on the settings page.
$(document).on('rex:ready', function () {
    $(document)
        .off('click.accessdenied')
        .on('click.accessdenied', '.accessdenied-add-ip-btn', function () {
            var $btn = $(this);
            var ip = $btn.data('ip');
            var $textarea = $('.accessdenied-ip-whitelist');
            if (!$textarea.length) { return; }

            var current = $textarea.val().trim();
            var ips = current
                ? current.split('\n').map(function (s) { return s.trim(); }).filter(Boolean)
                : [];

            if (!ips.includes(ip)) {
                ips.push(ip);
                $textarea.val(ips.join('\n'));
            }
            $btn.prop('disabled', true);
        })
        // Adds a locale|label preset entry to the offline_labels textarea.
        .on('click.accessdenied', '.accessdenied-add-locale-btn', function () {
            var entry = $(this).data('locale'); // e.g. "de_de|offline"
            var $textarea = $('.accessdenied-offline-labels');
            if (!$textarea.length) { return; }

            var lang = entry.split('|')[0];
            var lines = $textarea.val().trim()
                ? $textarea.val().trim().split('\n').map(function (l) { return l.trim(); }).filter(Boolean)
                : [];
            // Replace existing entry for this locale, or append
            var found = false;
            lines = lines.map(function (l) {
                if (l.split('|')[0].trim() === lang) { found = true; return entry; }
                return l;
            });
            if (!found) { lines.push(entry); }
            $textarea.val(lines.join('\n'));
        });
});
