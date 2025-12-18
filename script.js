// Simple client-side form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let valid = true;
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (!input.value) {
                    valid = false;
                    input.style.border = "2px solid red";
                } else {
                    input.style.border = "";
                }
            });
            if (!valid) {
                e.preventDefault();
                alert("Please fill all required fields!");
            }
        });
    });
});
