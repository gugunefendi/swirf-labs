import { fetchEmployees } from './employeeRequests.js';

// load employees
export async function loadEmployees() {
    const employeeTable = document.getElementById('employeeTable');
    employeeTable.innerHTML = '';

    try {
        const employees = await fetchEmployees();

        if (employees.success && Array.isArray(employees.data)) {
            employees.data.forEach(employee => {
                const row = `<tr>
                                <td class="right">${employee.name}</td>
                                <td class="center">${employee.age}</td>
                                <td>${employee.address}</td>
                                <td class="right">${employee.occupation}</td>
                            </tr>`;
                employeeTable.innerHTML += row;
            });
        }
        
    } catch (error) {
        console.error('Error loading employees:', error);
    }
}

loadEmployees();
