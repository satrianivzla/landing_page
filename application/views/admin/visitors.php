<h1>Visitors</h1>
<table id="visitorsTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>IP Address</th>
            <th>User Agent</th>
            <th>Page URL</th>
            <th>Timestamp</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($visitors as $visitor): ?>
            <tr>
                <td><?php echo $visitor['ip_address']; ?></td>
                <td><?php echo $visitor['user_agent']; ?></td>
                <td><?php echo $visitor['page_url']; ?></td>
                <td><?php echo $visitor['timestamp']; ?></td>
                <td>
                    <a href="<?php echo site_url('admin/ban_ip/' . $visitor['ip_address']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to ban this IP address?')">Ban</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
