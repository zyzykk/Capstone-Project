document.addEventListener('DOMContentLoaded', function() {
    const applications = [
        { id: 1, applicationNo: 'PA-12345', date: '2023-05-01', time: '09:30', department: 'Finance', status: 'Approved' },
        { id: 2, applicationNo: 'PA-12346', date: '2023-05-02', time: '10:15', department: 'HR', status: 'Rejected' },
        { id: 3, applicationNo: 'PA-12347', date: '2023-05-03', time: '11:00', department: 'IT', status: 'Pending' },
        { id: 4, applicationNo: 'PA-12348', date: '2023-05-04', time: '13:45', department: 'Marketing', status: 'Approved' },
        { id: 5, applicationNo: 'PA-12349', date: '2023-05-05', time: '14:30', department: 'Sales', status: 'Pending' },
        { id: 6, applicationNo: 'PA-12350', date: '2023-05-06', time: '09:15', department: 'Finance', status: 'Pending' },
        { id: 7, applicationNo: 'PA-12351', date: '2023-05-07', time: '11:20', department: 'HR', status: 'Approved' },
        { id: 8, applicationNo: 'PA-12352', date: '2023-05-08', time: '14:00', department: 'IT', status: 'Rejected' },
        { id: 9, applicationNo: 'PA-12353', date: '2023-05-09', time: '09:45', department: 'Operation', status: 'Rejected' },
        { id: 10, applicationNo: 'PA-12354', date: '2023-05-10', time: '10:30', department: 'Finance', status: 'Pending' },
        { id: 11, applicationNo: 'PA-12355', date: '2023-05-11', time: '11:45', department: 'IT', status: 'Approved' },
        { id: 12, applicationNo: 'PA-12356', date: '2023-05-12', time: '13:00', department: 'HR', status: 'Rejected' },
        { id: 13, applicationNo: 'PA-12357', date: '2023-05-13', time: '14:15', department: 'Marketing', status: 'Pending' },
        { id: 14, applicationNo: 'PA-12358', date: '2023-05-14', time: '15:30', department: 'Sales', status: 'Approved' },
        { id: 15, applicationNo: 'PA-12359', date: '2023-05-15', time: '16:45', department: 'Operation', status: 'Rejected' },
    ];

    const tableBody = document.querySelector('#applicationTable tbody');
    const searchInput = document.getElementById('searchInput');
    const filterButton = document.getElementById('filterButton');
    const filterOptions = document.getElementById('filterOptions');
    const sortByDateCheckbox = document.getElementById('sortByDate');
    const departmentFilters = document.getElementById('departmentFilters');
    const statusFilters = document.getElementById('statusFilters');
    const kpiCards = document.querySelectorAll('.kpi-card');

    let filteredApps = [...applications];

    function renderTable(data) {
        tableBody.innerHTML = '';
        data.forEach(app => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${app.applicationNo}</td>
                <td>${app.date}</td>
                <td>${app.time}</td>
                <td>${app.department}</td>
                <td>${app.status}</td>
                <td><button class="view-button" data-id="${app.id}">View</button></td>
            `;
            tableBody.appendChild(row);
        });
    }

    function updateKPICounts() {
        const counts = {
            'Pending': filteredApps.filter(app => app.status === 'Pending').length,
            'Approved': filteredApps.filter(app => app.status === 'Approved').length,
            'Rejected': filteredApps.filter(app => app.status === 'Rejected').length
        };

        document.getElementById('pendingCount').textContent = counts['Pending'];
        document.getElementById('approvedCount').textContent = counts['Approved'];
        document.getElementById('rejectedCount').textContent = counts['Rejected'];
    }

    function createFilterCheckboxes() {
        const departments = [...new Set(applications.map(app => app.department))];
        const statuses = [...new Set(applications.map(app => app.status))];

        departments.forEach(dept => {
            const label = document.createElement('label');
            label.innerHTML = `<input type="checkbox" name="department" value="${dept}"> ${dept}`;
            departmentFilters.appendChild(label);
        });

        statuses.forEach(status => {
            const label = document.createElement('label');
            label.innerHTML = `<input type="checkbox" name="status" value="${status}"> ${status}`;
            statusFilters.appendChild(label);
        });
    }

    function filterApplications() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedDepartments = Array.from(document.querySelectorAll('input[name="department"]:checked')).map(el => el.value);
        const selectedStatuses = Array.from(document.querySelectorAll('input[name="status"]:checked')).map(el => el.value);

        filteredApps = applications.filter(app => 
            Object.values(app).some(value => 
                value.toString().toLowerCase().includes(searchTerm)
            )
        );

        if (selectedDepartments.length > 0) {
            filteredApps = filteredApps.filter(app => selectedDepartments.includes(app.department));
        }

        if (selectedStatuses.length > 0) {
            filteredApps = filteredApps.filter(app => selectedStatuses.includes(app.status));
        }

        if (sortByDateCheckbox.checked) {
            filteredApps.sort((a, b) => new Date(b.date) - new Date(a.date));
        } else {
            filteredApps.sort((a, b) => a.id - b.id);
        }

        renderTable(filteredApps);
        updateKPICounts();
    }

    searchInput.addEventListener('input', filterApplications);
    filterButton.addEventListener('click', () => {
        filterOptions.style.display = filterOptions.style.display === 'none' ? 'block' : 'none';
    });
    sortByDateCheckbox.addEventListener('change', filterApplications);

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('view-button')) {
            const applicationId = e.target.getAttribute('data-id');
            window.location.href = `view-payment-advice.html?id=${applicationId}`;
        }
    });

    kpiCards.forEach(card => {
        card.addEventListener('click', () => {
            const status = card.getAttribute('data-status');
            const statusCheckbox = document.querySelector(`input[name="status"][value="${status}"]`);
            statusCheckbox.checked = !statusCheckbox.checked;
            filterApplications();
        });
    });

    // Initialize
    renderTable(applications);
    createFilterCheckboxes();
    filterApplications();

    // Add event listeners to dynamically created checkboxes
    departmentFilters.addEventListener('change', filterApplications);
    statusFilters.addEventListener('change', filterApplications);
});