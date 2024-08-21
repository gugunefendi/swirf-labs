// POST request ke backend
export async function submitEmployeeData(formData) {
    try {
        const response = await fetch('app/HandleRequest.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });

        return await response.json();
    } catch (error) {
        throw new Error('Error processing the request.');
    }
}

// GET request dari backend
export async function fetchEmployees() {
    try {
        const response = await fetch('app/HandleRequest.php');
        
        if (response.ok) {
            const data = await response.json();
            console.log(data);
            return data;
        }

    } catch (error) {
        throw new Error('Error loading employees.');
    }
}
