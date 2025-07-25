<h1>Banned IPs</h1>
<table id="bannedIpsTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>IP Address</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($banned_ips as $ip): ?>
            <tr>
                <td><?php echo $ip['ip_address']; ?></td>
                <td>
                    <a href="<?php echo site_url('admin/unban_ip/' . $ip['id']); ?>" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to unban this IP address?')">Unban</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
