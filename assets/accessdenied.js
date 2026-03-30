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
        });
});
