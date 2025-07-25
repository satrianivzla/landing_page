<h1>Audit Trail</h1>
<table id="auditTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>User</th>
            <th>Action</th>
            <th>Table</th>
            <th>Record ID</th>
            <th>Old Values</th>
            <th>New Values</th>
            <th>Timestamp</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($audit_trail as $log): ?>
            <tr>
                <td><?php echo $log['username']; ?></td>
                <td><?php echo $log['action']; ?></td>
                <td><?php echo $log['table_name']; ?></td>
                <td><?php echo $log['record_id']; ?></td>
                <td><pre><?php echo json_encode(json_decode($log['old_values']), JSON_PRETTY_PRINT); ?></pre></td>
                <td><pre><?php echo json_encode(json_decode($log['new_values']), JSON_PRETTY_PRINT); ?></pre></td>
                <td><?php echo $log['timestamp']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
