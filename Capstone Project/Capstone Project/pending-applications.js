document.addEventListener('DOMContentLoaded', function() {
    const pendingApplications = [
        { id: 1, applicationNo: 'PA-12347', date: '2023-05-03', time: '11:00', department: 'IT' },
        { id: 2, applicationNo: 'PA-12349', date: '2023-05-05', time: '14:30', department: 'Sales' },
        { id: 3, applicationNo: 'PA-12350', date: '2023-05-06', time: '09:15', department: 'Finance' },
    ];

    const tableBody = document.querySelector('#pendingApplicationTable tbody');
    const searchInput = document.getElementById('searchInput');
    const filterButton = document.getElementById('filterButton');

    function renderTable(data) {
        tableBody.innerHTML = '';
        data.forEach(app => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${app.applicationNo}</td>
                <td>${app.date}</td>
                <td>${app.time}</td>
                <td>${app.department}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    function filterApplications() {
        const searchTerm = searchInput.value.toLowerCase();
        const filteredApps = pendingApplications.filter(app => 
            Object.values(app).some(value => 
                value.toString().toLowerCase().includes(searchTerm)
            )
        );
        renderTable(filteredApps);
    }

    searchInput.addEventListener('input', filterApplications);
    filterButton.addEventListener('click', filterApplications);

    // Initial render
    renderTable(pendingApplications);
});