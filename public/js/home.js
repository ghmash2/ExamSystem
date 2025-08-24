
// Basic search functionality
document.querySelector('.search-box input').addEventListener('input', function (e) {
    const searchTerm = e.target.value.toLowerCase();
    document.querySelectorAll('.exam-card').forEach(card => {
        const title = card.querySelector('.exam-title').textContent.toLowerCase();
        const tagline = card.querySelector('.exam-tagline').textContent.toLowerCase();
        if (title.includes(searchTerm) || tagline.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Basic filter functionality
document.querySelectorAll('.filter-option input').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const category = this.value;
        const isChecked = this.checked;

        // This is a basic implementation - you'll need to enhance it
        // based on your actual filtering requirements
        document.querySelectorAll('.exam-card').forEach(card => {
            const cardCategory = card.querySelector('.exam-category').textContent.toLowerCase();
            if (cardCategory.includes(category.toLowerCase())) {
                card.style.display = isChecked ? 'block' : 'none';
            }
        });
    });
});