// Menghitung umur dari tanggal lahir
export function calculateAge(dob) {
    const today = new Date();
    const birthDate = new Date(dob);
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDifference = today.getMonth() - birthDate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

// Memvalidasi data form
export function validateFormData(formData) {
    const { name, number_identification, age, occupation, errorMessage } = formData;
    let errorMessages = [];

    if (!name) {
        errorMessages.push('Nama harus diisi.');
    }
    if (!number_identification) {
        errorMessages.push('NIK harus diisi.');
    }
    if (!age) {
        errorMessages.push('Usia harus diisi.');
    }
    if (parseInt(age, 10) < 18 || parseInt(age, 10) > 65) {
        errorMessages.push('Usia harus 18-65 tahun.');
    }
    if (!occupation) {
        errorMessages.push('Pekerjaan harus dipilih.');
    }

    // Memeriksa panjang dan format NIK
    if (number_identification.length !== 16 || !/^\d+$/.test(number_identification)) {
        errorMessage.textContent = 'NIK harus 16 karakter dan hanya berisi angka.';
        setTimeout(() => errorMessage.textContent = '', 3000);
        return false;
    }

    // Menampilkan semua eror
    if (errorMessages.length > 0) {
        console.log(errorMessages);
        errorMessage.innerHTML = errorMessages.join('<br>');
        setTimeout(() => errorMessage.textContent = '', 3000);
        return false;
    }   

    // validasi ok
    return true;
}
