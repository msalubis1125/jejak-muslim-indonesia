/**
 * Chart.js Integration for Keuangan
 */
document.addEventListener('DOMContentLoaded', function() {
    const chartDataScript = document.getElementById('chart-data');
    if (!chartDataScript) return;
    
    try {
        const rawData = JSON.parse(chartDataScript.textContent);
        
        // Trend Chart (Bar)
        const ctxTrend = document.getElementById('trendChart');
        if (ctxTrend && rawData.trend) {
            const labels = rawData.trend.map(d => d.bulan);
            const pemasukan = rawData.trend.map(d => d.pemasukan);
            const pengeluaran = rawData.trend.map(d => d.pengeluaran);
            
            new Chart(ctxTrend, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: pemasukan,
                            backgroundColor: '#10b981', // emerald-500
                            borderRadius: 4
                        },
                        {
                            label: 'Pengeluaran',
                            data: pengeluaran,
                            backgroundColor: '#ef4444', // red-500
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value === 0) return '0';
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000) + 'Jt';
                                    if (value >= 1000) return 'Rp ' + (value / 1000) + 'Rb';
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Doughnut Chart (Kategori Pemasukan)
        const ctxKat = document.getElementById('kategoriChart');
        if (ctxKat && rawData.kategori) {
            new Chart(ctxKat, {
                type: 'doughnut',
                data: {
                    labels: rawData.kategori.labels,
                    datasets: [{
                        data: rawData.kategori.data,
                        backgroundColor: [
                            '#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#06b6d4', '#64748b'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const val = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed);
                                    return ` ${context.label}: ${val}`;
                                }
                            }
                        }
                    }
                }
            });
        }
    } catch (e) {
        console.error('Error rendering chart:', e);
    }
});
