
// Basic search functionality
document.querySelector('.search-box input').addEventListener('input', function (e) {
    const searchTerm = e.target.value.toLowerCase();
    displaySearchItem(searchTerm);
});
function displaySearchItem(searchTerm) {
    document.querySelectorAll('.exam-header').forEach(card => {
        const title = card.querySelector('.exam-title').textContent.toLowerCase();
        const tagline = card.querySelector('.exam-tagline').textContent.toLowerCase();

        card.parentElement.style.display = 'block';

        if (searchTerm === '') {
            card.style.display = 'block';
        } else if (title.includes(searchTerm) || tagline.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.parentElement.style.display = 'none';
        }
    });
}



// Basic filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const categoryCheckboxes = document.querySelectorAll('input[name="category"]');
    const examElements = document.querySelectorAll('.exam-card');
    
    const categoryMap = {
        'mathematics': '1',
        'english': '2',
        'history': '3', 
        'language': '4',
        'technology': '5'
    };
    
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterExams);
    });
    
    function filterExams() {
        const selectedCategories = Array.from(categoryCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => categoryMap[checkbox.value] || checkbox.value);
        
        if (selectedCategories.length === 0) {
            examElements.forEach(exam => exam.style.display = 'block');
            return;
        }
        
        examElements.forEach(exam => {
            const examCategoryElement = exam.querySelector('.exam-category');
            if (!examCategoryElement) return;
            
            const examCategory = examCategoryElement.textContent.trim();
            
            if (selectedCategories.includes(examCategory)) {
                exam.style.display = 'block';
            } else {
                exam.style.display = 'none';
            }
        });
    }
});