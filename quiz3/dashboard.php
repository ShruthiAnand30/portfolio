<?php
include('db.php');

// --- Query 1: Total visits per page ---
$result = $conn->query(
    "SELECT page_url, COUNT(*) AS visit_count 
     FROM page_visits 
     GROUP BY page_url 
     ORDER BY visit_count DESC"
);

$pages = [];
while ($row = $result->fetch_assoc()) {
    $pages[] = $row;
}
$result->free();

// --- Query 2: Visits over the last 7 days ---
$stmt = $conn->prepare(
    "SELECT DATE(visit_time) AS day, COUNT(*) AS total
     FROM page_visits
     WHERE visit_time >= ?
     GROUP BY day
     ORDER BY day ASC"
);
$cutoff = date('Y-m-d', strtotime('-7 days'));
$stmt->bind_param("s", $cutoff);
$stmt->execute();
$recent = $stmt->get_result();

$daily = [];
while ($row = $recent->fetch_assoc()) {
    $daily[] = $row;
}
$stmt->close();

// --- Query 3: Most recent visits ---
$latest = $conn->query(
    "SELECT page_url, visit_time, ip_address 
     FROM page_visits 
     ORDER BY visit_time DESC 
     LIMIT 10"
);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Analytics Dashboard</title>
    <link rel="stylesheet" href="/iit/website/style.css">
    <style>
        .card { background: #f4f4f4; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.5rem; text-align: left; border-bottom: 1px solid #ddd; }
        .bar { background: #4a90d9; height: 20px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Site Analytics Dashboard</h1>

    <div class="card">
        <h2>Page Visit Counts</h2>
        <table>
            <tr><th>Page</th><th>Visits</th><th>Bar</th></tr>
            <?php
            $max = $pages[0]['visit_count'] ?? 1;
            foreach ($pages as $p):
                $width = round(($p['visit_count'] / $max) * 200);
            ?>
            <tr>
                <td><?php echo htmlspecialchars($p['page_url']); ?></td>
                <td><?php echo (int)$p['visit_count']; ?></td>
                <td><div class="bar" style="width:<?php echo $width; ?>px"></div></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="card">
        <h2>Last 10 Visits</h2>
        <table>
            <tr><th>Page</th><th>Time</th><th>IP</th></tr>
            <?php while ($row = $latest->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['page_url']); ?></td>
                <td><?php echo htmlspecialchars($row['visit_time']); ?></td>
                <td><?php echo htmlspecialchars($row['ip_address']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- JSON for JavaScript chart -->
    <div class="card">
        <h2>Last 7 Days</h2>
        <canvas id="trendChart" width="600" height="200"></canvas>
    </div>

    <script>
        // Pass PHP data to JavaScript safely
        const dailyData = <?php echo json_encode($daily); ?>;
    </script>
    <script src="assets/dashboard.js"></script>
</body>
</html>