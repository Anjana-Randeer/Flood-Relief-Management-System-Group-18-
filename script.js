document.addEventListener('DOMContentLoaded', () => {
    // 1. Request form submission and checking if there any empty required areas.
    const reliefForm = document.getElementById('reliefForm');
    if (reliefForm) {
        reliefForm.addEventListener('submit', function(event) {
            if (!this.checkValidity()) {
                event.preventDefault();
                alert("Please fill out all required fields before submitting.");
            }
        });
    }

    // 2. User Registraion form submission 
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        signupForm.addEventListener('submit', function() {
            
        });
    }
});

 //3.User delete confimation alert
 
function confirmDeletion(type) {
    const action = type === 'user' ? 'delete this user' : 'remove this relief request';
    return confirm(`Are you sure you want to ${action}?`);
}
