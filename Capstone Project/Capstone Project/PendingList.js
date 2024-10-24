document.addEventListener('DOMContentLoaded', function() {
    let applications = [
        { id: 1, applicationNo: 'PA-12345', date: '2023-05-01', time: '09:30', department: 'Finance', status: 'Ongoing' },
        { id: 2, applicationNo: 'PA-12346', date: '2023-05-02', time: '10:15', department: 'HR', status: 'Ongoing' },
        { id: 3, applicationNo: 'PA-12347', date: '2023-05-03', time: '11:00', department: 'IT', status: 'Ongoing' },
        { id: 4, applicationNo: 'PA-12348', date: '2023-05-04', time: '13:45', department: 'Marketing', status: 'Approved' },
        { id: 5, applicationNo: 'PA-12349', date: '2023-05-05', time: '14:30', department: 'Sales', status: 'Rejected' },
    ];

    function renderTables() {
        renderOngoingApplications();
        renderApprovedApplications();
        renderRejectedApplications();
    }

    function renderOngoingApplications() {
        const tableBody = document.querySelector('#ongoingApplications tbody');
        tableBody.innerHTML = '';
        applications.filter(app => app.status === 'Ongoing').forEach(app => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${app.applicationNo}</td>
                <td>${app.date}</td>
                <td>${app.time}</td>
                <td>${app.department}</td>
                <td>
                    <button class="button view" data-id="${app.id}">View</button>
                    <button class="button approve" data-id="${app.id}">Approve</button>
                    <button class="button reject" data-id="${app.id}">Reject</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function renderApprovedApplications() {
        const tableBody = document.querySelector('#approvedApplications tbody');
        tableBody.innerHTML = '';
        applications.filter(app => app.status === 'Approved').forEach(app => {
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

    function renderRejectedApplications() {
        const tableBody = document.querySelector('#rejectedApplications tbody');
        tableBody.innerHTML = '';
        applications.filter(app =>app.status === 'Rejected').forEach(app => {
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

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('view')) {
            const id = e.target.getAttribute('data-id');
            alert(`Viewing application ${id}`);
        } else if (e.target.classList.contains('approve')) {
            const id = e.target.getAttribute('data-id');
            applications = applications.map(app => 
                app.id === parseInt(id) ? {...app, status: 'Approved'} : app
            );
            renderTables();
        } else if (e.target.classList.contains('reject')) {
            const id = e.target.getAttribute('data-id');
            applications = applications.map(app => 
                app.id === parseInt(id) ? {...app, status: 'Rejected'} : app
            );
            renderTables();
        }
    });

    // Initial render
    renderTables();
});