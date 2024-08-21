import { validateFormData, calculateAge } from './formValidations.js';
import { submitEmployeeData } from './employeeRequests.js';
import { loadEmployees } from './employeeLoader.js';

// Event form submit
document.getElementById('employeeForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    // get data dari form dan simpan dalam objek
    const dob = document.getElementById('dob').value;
    const formData = {
        name: document.getElementById('name').value.trim(),
        number_identification: document.getElementById('number_identification').value.trim(),
        dob: dob,
        age: document.getElementById('age').value.trim(),
        address: document.getElementById('address').value.trim(),
        occupation: document.getElementById('occupation').value,
        place: document.getElementById('place').value.trim(),
        errorMessage: document.getElementById('errorMessage'),
        successMessage: document.getElementById('successMessage'),
    };

    // Validasi form
    if (!validateFormData(formData)) {
        return; // Jika validasi gagal, stop proses submit
    }

    try {
        const result = await submitEmployeeData(formData);

        if (result.success) {
            formData.successMessage.textContent = 'Success added employee.';
            setTimeout(() => formData.successMessage.textContent = '', 3000);
            document.getElementById('employeeForm').reset();
            loadEmployees();
        } else {
            formData.errorMessage.textContent = result.message || 'Failed to submit the form.';
            setTimeout(() => formData.errorMessage.textContent = '', 3000);
        }
    } catch (error) {
        formData.errorMessage.textContent = error.message;
        setTimeout(() => formData.errorMessage.textContent = '', 3000);
    }
});

// Mengupdate umur
document.getElementById('dob').addEventListener('change', function() {
    const dob = this.value;
    const ageInput = document.getElementById('age');
    if (dob) {
        const age = calculateAge(dob);
        ageInput.value = age;
    } else {
        ageInput.value = '';
    }
});