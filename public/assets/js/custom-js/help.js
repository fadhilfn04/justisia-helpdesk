document.addEventListener('DOMContentLoaded', function() {

    // help fag js

    const buttons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('[data-category]');
    const searchInput = document.getElementById('faqSearchInput');

    // === FILTER BUTTON ===
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            buttons.forEach(b => {
                b.classList.remove('btn-dark');
                b.classList.add('btn-primary');
            });
            this.classList.remove('btn-primary');
            this.classList.add('btn-dark');

            const target = this.getAttribute('data-target');
            cards.forEach(card => {
                if (target === 'all' || card.getAttribute('data-category') === target) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            searchInput.value = '';
        });
    });

    // === LIVE SEARCH ===
    searchInput.addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        const notFoundCard = document.getElementById('notfoundfaq');
        let anyVisible = false;

        cards.forEach(card => {
            const accordionItems = card.querySelectorAll('.accordion-item');
            let visibleItems = [];

            accordionItems.forEach(item => {
                const text = item.innerText.toLowerCase();

                if (text.includes(query)) {
                    item.style.display = '';
                    visibleItems.push(item);
                } else {
                    item.style.display = 'none';
                }
            });

            card.style.display = visibleItems.length > 0 ? 'block' : 'none';

            if (visibleItems.length > 0) {
                anyVisible = true;
            }

            accordionItems.forEach(item => {
                if (visibleItems.length === 1 && visibleItems.includes(item)) {
                    item.style.borderBottom = 'none';
                } else if (item.style.display !== 'none') {
                    item.style.borderBottom = '1px solid #dee2e6';
                }
            });
        });

        // Tampilkan / sembunyikan "Tidak ada FAQ"
        if (!anyVisible && query !== '') {
            notFoundCard.classList.remove('d-none');
        } else {
            notFoundCard.classList.add('d-none');
        }
    });

});
