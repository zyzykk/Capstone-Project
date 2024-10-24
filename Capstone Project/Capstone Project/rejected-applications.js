document.addEventListener('DOMContentLoaded', function() {
    const rejectedApplications = [
        { id: 1, applicationNo: 'PA-12346', date: '2023-05-02', time: '10:15', department: 'HR' },
        { id: 2, applicationNo: 'PA-12352', date: '2023-05-08', time: '14:00', department: 'IT' },
        { id: 3, applicationNo: 'PA-12353', date: '2023-05-09', time: '09:45', department: 'Sales' },
    ];

    const tableBody = document.querySelector('#rejectedApplicationTable tbody');
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
        const filteredApps = rejectedApplications.filter(app => 
            Object.values(app).some(value => 
                value.toString().toLowerCase().includes(searchTerm)
            )
        );
        renderTable(filteredApps);
    }

    searchInput.addEventListener('input', filterApplications);
    filterButton.addEventListener('click', filterApplications);

    // Initial render
    renderTable(rejectedApplications);
});