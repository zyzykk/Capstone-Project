document.addEventListener('DOMContentLoaded', function() {
    const approvedApplications = [
        { id: 1, applicationNo: 'PA-12345', date: '2023-05-01', time: '09:30', department: 'Finance' },
        { id: 2, applicationNo: 'PA-12348', date: '2023-05-04', time: '13:45', department: 'Marketing' },
        { id: 3, applicationNo: 'PA-12351', date: '2023-05-07', time: '11:20', department: 'HR' },
    ];

    const tableBody = document.querySelector('#approvedApplicationTable tbody');
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
        const filteredApps = approvedApplications.filter(app => 
            Object.values(app).some(value => 
                value.toString().toLowerCase().includes(searchTerm)
            )
        );
        renderTable(filteredApps);
    }

    searchInput.addEventListener('input', filterApplications);
    filterButton.addEventListener('click', filterApplications);

    // Initial render
    renderTable(approvedApplications);
});