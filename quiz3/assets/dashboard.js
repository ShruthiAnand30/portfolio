// dashboard.js — draws a trend chart from the daily visit data

(function() {
    if (!dailyData || dailyData.length === 0) return;

    const canvas = document.getElementById('trendChart');
    const ctx = canvas.getContext('2d');
    const max = Math.max(...dailyData.map(d => parseInt(d.total)));
    const barWidth = Math.floor(canvas.width / dailyData.length) - 10;

    // Draw bars
    dailyData.forEach((day, i) => {
        const barHeight = Math.round((parseInt(day.total) / max) * 160);
        const x = i * (barWidth + 10) + 10;
        const y = 180 - barHeight;

        // Bar
        ctx.fillStyle = '#4a90d9';
        ctx.fillRect(x, y, barWidth, barHeight);

        // Day label
        ctx.fillStyle = '#333';
        ctx.font = '11px sans-serif';
        ctx.fillText(day.day.slice(5), x, 195); // shows MM-DD

        // Count label
        ctx.fillStyle = '#fff';
        ctx.fillText(day.total, x + 4, y + 14);
    });

    // Add a live refresh button
    const btn = document.createElement('button');
    btn.textContent = 'Refresh Data';
    btn.style.cssText = 'margin-top: 1rem; padding: 0.5rem 1rem; cursor: pointer;';
    btn.addEventListener('click', function() {
        location.reload();
    });
    canvas.parentNode.appendChild(btn);

    // Auto-highlight the top visited page row on load
    const rows = document.querySelectorAll('table tr');
    if (rows[1]) {
        rows[1].style.background = '#fff3cd';
        rows[1].title = 'Most visited page';
    }
})();