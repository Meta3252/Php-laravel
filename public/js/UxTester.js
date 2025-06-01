// resources/js/UxTester.js หรือ public/js/UxTester.js
// อ้างอิง window.appData แทน ไม่อ้าง PHP
document.addEventListener("DOMContentLoaded", () => {
    const images = window.appData.images;
    const regionNames = window.appData.regionNames;

    let columns = 3;
    let autoPlay = false;
    let currentIndex = 0;
    let fadeTimeouts = [];
    let autoPlayInterval = null;

    const columnsSelect = document.getElementById('columnsSelect');
    const autoPlayToggle = document.getElementById('autoPlayToggle');
    const imageContainer = document.getElementById('imageContainer');
    const bulletContainer = document.getElementById('bulletContainer');

    function clearFadeTimeouts() {
        fadeTimeouts.forEach(t => clearTimeout(t));
        fadeTimeouts = [];
    }

    function renderImages() {
        clearFadeTimeouts();
        imageContainer.innerHTML = '';

        for (let i = 0; i < columns; i++) {
            const idx = (currentIndex + i) % images.length;

            const div = document.createElement('div');
            div.className = 'item';

            const img = document.createElement('img');
            img.src = images[idx];
            img.alt = `Wat col ${i + 1}`;
            img.style.opacity = 0;

            const timeoutId = setTimeout(() => {
                img.style.opacity = 1;
            }, 50 + i * 150);

            fadeTimeouts.push(timeoutId);

            const label = document.createElement('div');
            label.className = 'image-label';
            label.textContent = regionNames[idx];

            div.appendChild(img);
            div.appendChild(label);
            imageContainer.appendChild(div);
        }
    }

    function renderBullets() {
        bulletContainer.innerHTML = '';
        for (let i = 0; i < images.length; i++) {
            const span = document.createElement('span');
            span.className = 'bullet' + (i === currentIndex ? ' active' : '');
            span.title = `รูปที่ ${i + 1}`;
            span.addEventListener('click', () => {
                currentIndex = i;
                renderImages();
                renderBullets();
                resetAutoPlay();
            });
            bulletContainer.appendChild(span);
        }
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        renderImages();
        renderBullets();
    }

    function resetAutoPlay() {
        if (autoPlayInterval) clearInterval(autoPlayInterval);
        if (autoPlay) {
            autoPlayInterval = setInterval(nextImage, 5000);
        }
    }

    columnsSelect.addEventListener('change', (e) => {
        columns = Number(e.target.value);
        if (columns > images.length) columns = images.length;
        renderImages();
        resetAutoPlay();
    });

    autoPlayToggle.addEventListener('change', (e) => {
        autoPlay = e.target.checked;
        resetAutoPlay();
    });

    renderImages();
    renderBullets();
});
