const validateForm = () => {
    let isValid = true;
    document.querySelectorAll('.formMember').forEach(elem => {
        const inputElem = elem.querySelector('input');
        const displayMsg = elem.querySelector('a');
        const showError = (message) => {
            displayMsg.innerText = message;
            isValid = false;
        };
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (inputElem) {
            const text = inputElem.value;
            if (text === '') { //validation for empty fields
                showError('This Field is Required');
            } else if (inputElem.id === 'First_Name' && text.length < 3) { //validation for length of first name
                showError('First Name must contain 3 or more characters');
            } else if (inputElem.id === 'Last_Name' && text.length < 3) { //validation for length of last name
                showError('Last Name must contain 3 or more characters');
            } else if (inputElem.id === 'email' && !emailRegex.test(text)) { // Validation for email format
                showError('Invalid Email Address');
            } else if (inputElem.id === 'password') { // Validation for password
                if (text.length < 8) {
                    showError('Password must be at least 8 characters long');
                } else if (!/[A-Z]/.test(text) || !/[a-z]/.test(text) || !/[0-9]/.test(text)) {
                    showError('Password must contain at least one uppercase letter, one lowercase letter, and one digit');
                } else {
                    displayMsg.innerText = ''; // Clear the error message for the password field
                }
            } else if (inputElem.name == 'image') {
                let imgName = inputElem.files[0].name;
                const allowedExtensions = ['.jpg', '.jpeg', '.png'];
                if (!imgName.endsWith(allowedExtensions[0]) && !imgName.endsWith(allowedExtensions[1]) && !imgName.endsWith(allowedExtensions[2])) {
                    showError('Please upload a valid image extension'); // validation for image
                } else {
                    displayMsg.innerText = '';
                }
            } else if (inputElem.id === 'reenter_password'){
                    
            }  else {
                displayMsg.innerText = ''; //remove error msg
            }
        }

    });
    return isValid;
};

//calling the function when submitted
document.getElementById('myform').addEventListener('submit', (e) => {
    if (!validateForm()) {
        e.preventDefault();
    }
});

