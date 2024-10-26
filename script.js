function showTab(tab) {
    // Hide both forms
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'none';

    // Remove active class from both buttons
    document.querySelectorAll('.tab-button').forEach(function(button) {
        button.classList.remove('active');
    });

    // Show the selected form
    if (tab === 'login') {
        document.getElementById('login-form').style.display = 'block';
        document.getElementById('login-button').classList.add('active');
    } else if (tab === 'register') {
        document.getElementById('register-form').style.display = 'block';
        document.getElementById('register-button').classList.add('active');
    }
}

// Ensure the login form is visible by default when the page loads
document.addEventListener('DOMContentLoaded', function() {
    showTab('login');
});
/*filter*/
function toggleFilterForm() {
    const filterForm = document.getElementById('filterForm');
    const isExpanded = filterForm.style.display === 'block';
    filterForm.style.display = isExpanded ? 'none' : 'block';
}