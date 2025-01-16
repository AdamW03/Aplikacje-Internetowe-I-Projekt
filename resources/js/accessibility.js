const fontSizeSelector = document.getElementById('fontSizeSelector');
const contrastButton = document.getElementById('contrastButton');
const body = document.body;

const applyTheme = () => {
    // Pobieranie zapisanych preferencji z localStorage
    const savedFontSize = localStorage.getItem('fontSize') || 'normal';
    const savedContrast = localStorage.getItem('contrast') === 'true';

    // Usuwanie poprzednich klas
    body.classList.remove('font-small', 'font-normal', 'font-large', 'contrast');

    // Dodawanie odpowiednich klas
    body.classList.add(`font-${savedFontSize}`);
    if (savedContrast) {
        body.classList.add('contrast');
    }

    // Ustawienie wartości w selektorze rozmiaru czcionki
    if (fontSizeSelector) {
        fontSizeSelector.value = savedFontSize;
    }
};

if (fontSizeSelector) {
    fontSizeSelector.addEventListener('change', function () {
        const fontSize = this.value;
        // Zapisujemy nową wartość rozmiaru czcionki do localStorage
        localStorage.setItem('fontSize', fontSize);
        applyTheme();
    });
}

if (contrastButton) {
    contrastButton.addEventListener('click', function () {
        const currentContrast = localStorage.getItem('contrast') === 'true';
        const newContrast = !currentContrast;
        // Zapisujemy nową wartość kontrastu do localStorage
        localStorage.setItem('contrast', newContrast);
        applyTheme();
    });
}

// Aplikowanie ustawień po załadowaniu strony
if (body) {
    applyTheme();
}
