
/**
 * Gestionnaire de l'éditeur d'articles multilingue
 */

// Initialisation des données de configuration depuis le DOM
const configEl = document.getElementById('editor-langs');
const SUPPORTED_LANGS = JSON.parse(configEl.dataset.config); // ["fr", "en", "nl"]
let activeLang = 'fr';

// --- Gestion des Blocs (Templates) ---
const BlockTemplates = {
    title: (id, data = null) => createBlockWrapper(id, 'title', 'Titre (H2)', `
    ${generateLangInputs(id, 'input', '', data)}
    <input type="hidden" class="block-level" value="${data ? data.level : 2}">
`),
    text: (id, data = null) => createBlockWrapper(id, 'text', 'Paragraphe', `
        ${generateLangInputs(id, 'textarea', '', data)}
    `),
    list: (id, data = null) => createBlockWrapper(id, 'list', 'Liste à puces', `
        ${generateLangInputs(id, 'textarea', 'Séparez les éléments par une virgule', data)}
    `)
};

// --- Fonctions Utilitaires ---
function addBlock(type, data = null) {
    if (BlockTemplates[type]) {
        // Si on charge, on garde l'ID existant ou on en génère un nouveau
        const id = data ? (data.id || Date.now()) : Date.now();
        const newBlock = BlockTemplates[type](id, data);
        document.getElementById('blocks-workspace').appendChild(newBlock);
    }
}

function generateLangInputs(blockId, tag, placeholderSuffix = '', blockData = null) {
    return SUPPORTED_LANGS.map(lang => {
        // On vérifie si la donnée est dans .content (paragraphes) ou .text (titres)
        let val = '';
        if (blockData) {
            if (blockData.content && blockData.content[lang]) val = blockData.content[lang];
            else if (blockData.text && blockData.text[lang]) val = blockData.text[lang];
        }

        return `
            <div class="lang-field" data-lang="${lang}" style="display: ${lang === activeLang ? 'block' : 'none'}">
                ${tag === 'input'
                ? `<input type="text" class="data-${lang}" value="${val}" ...>`
                : `<textarea class="data-${lang}" ...>${val}</textarea>`
            }
            </div>
        `;
    }).join('');
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
// Fonction pour charger un article depuis le serveur
async function loadArticle(filename) {
    try {
        const response = await fetch(`api/get_article.php?file=${filename}`);
        if (!response.ok) throw new Error('Erreur réseau');

        const data = await response.json();

        // 1. On vide l'éditeur actuel
        const workspace = document.getElementById('blocks-workspace');
        workspace.innerHTML = '';

        // 2. On remplit les métadonnées (ID/Slug)
        // Dans loadArticle
        const idInput = document.getElementById('article-title');
        if (idInput) {
            idInput.value = data.meta.id;
            // On force la mise à jour du petit texte sous le titre
            document.getElementById('generated-id').textContent = data.meta.id;
        }

        // 3. On reconstruit les blocs
        data.content.forEach(block => {
            // Cette fonction devra être adaptée pour remplir les champs
            addBlock(block.type, block);
        });

        console.log("Article chargé avec succès :", filename);
    } catch (error) {
        console.error("Erreur:", error);
        alert("Impossible de charger l'article.");
    }
}
function addTextBlock(container, data = null) {
    const langs = ['fr', 'en', 'nl'];

    langs.forEach(lang => {
        const div = document.createElement('div');
        div.className = `lang-field lang-${lang}`;
        div.style.display = (lang === 'fr') ? 'block' : 'none';

        const textarea = document.createElement('textarea');
        textarea.name = `text_${lang}[]`;
        textarea.placeholder = `Texte en ${lang}...`;

        // --- LA MAGIE EST ICI ---
        // Si data existe, on remplit le champ avec la traduction correspondante
        if (data && data.content && data.content[lang]) {
            textarea.value = data.content[lang];
        }

        div.appendChild(textarea);
        container.appendChild(div);
    });
}

// --- Événements et Logique ---

// 1. Changement d'onglet
window.switchEditorLang = function (lang) {
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
document.getElementById('article-title').addEventListener('input', function (e) {
    const slug = e.target.value
        .toLowerCase()
        .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // Enlève accents
        .replace(/[^a-z0-9]/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
    document.getElementById('generated-id').textContent = slug || '--';
});


// 3. Ajouter un bloc (bouton +)
document.getElementById('add-block-trigger').addEventListener('click', () => {
    const type = document.getElementById('new-block-type').value;
    addBlock(type); // On ne passe pas de data, donc il sera vide
});
// Initialisation des liens de la sidebar au chargement du DOM
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.load-article-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const filename = this.getAttribute('data-filename');

            if (confirm("Charger cet article ? Les modifications non enregistrées seront perdues.")) {
                loadArticle(filename);
            }
        });
    });
});