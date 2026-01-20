
/**
 * Gestionnaire de l'éditeur d'articles multilingue
 */

// Initialisation des données de configuration depuis le DOM
const configEl = document.getElementById('editor-langs');
const SUPPORTED_LANGS = JSON.parse(configEl.dataset.config); // ["fr", "en", "nl"]
let activeLang = 'fr';

// --- Gestion des Blocs (Templates) ---
const BlockTemplates = {
    title: (id) => createBlockWrapper(id, 'title', 'Titre (H2)', `
        ${generateLangInputs(id, 'input')}
        <input type="hidden" class="block-level" value="2">
    `),
    text: (id) => createBlockWrapper(id, 'text', 'Paragraphe', `
        ${generateLangInputs(id, 'textarea')}
    `),
    list: (id) => createBlockWrapper(id, 'list', 'Liste à puces', `
        ${generateLangInputs(id, 'textarea', 'Séparez les éléments par une virgule')}
    `)
};

// --- Fonctions Utilitaires ---

function generateLangInputs(blockId, tag, placeholderSuffix = '') {
    return SUPPORTED_LANGS.map(lang => `
        <div class="lang-field" data-lang="${lang}" style="display: ${lang === activeLang ? 'block' : 'none'}">
            ${tag === 'input' 
                ? `<input type="text" class="data-${lang}" placeholder="Contenu ${lang.toUpperCase()} ${placeholderSuffix}">`
                : `<textarea class="data-${lang}" placeholder="Contenu ${lang.toUpperCase()} ${placeholderSuffix}"></textarea>`
            }
        </div>
    `).join('');
}

function createBlockWrapper(id, type, label, content) {
    const div = document.createElement('div');
    div.className = 'block-item';
    div.dataset.id = id;
    div.dataset.type = type;
    div.innerHTML = `
        <div class="block-header">
            <span class="block-type-label">${label}</span>
            <button type="button" class="btn-delete" onclick="this.closest('.block-item').remove()">×</button>
        </div>
        <div class="block-body">${content}</div>
    `;
    return div;
}

// --- Événements et Logique ---

// 1. Changement d'onglet
window.switchEditorLang = function(lang) {
    activeLang = lang;
    // Update boutons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.lang === lang);
    });
    // Update champs
    document.querySelectorAll('.lang-field').forEach(field => {
        field.style.display = (field.dataset.lang === lang) ? 'block' : 'none';
    });
};

// 2. Génération de l'ID (Slugify)
document.getElementById('article-title').addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // Enlève accents
        .replace(/[^a-z0-9]/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
    document.getElementById('generated-id').textContent = slug || '--';
});

// 3. Ajouter un bloc
document.getElementById('add-block-trigger').addEventListener('click', () => {
    const type = document.getElementById('new-block-type').value;
    if (BlockTemplates[type]) {
        const newBlock = BlockTemplates[type](Date.now());
        document.getElementById('blocks-workspace').appendChild(newBlock);
    }
});