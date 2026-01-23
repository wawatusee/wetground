/**
 * page_builder.js
 */

document.addEventListener('DOMContentLoaded', () => {
    const blocksContainer = document.getElementById('page-blocks-container');
    const btnAddBlock = document.getElementById('btn-add-block');
    const selectBlockType = document.getElementById('select-block-type');
    const btnSavePage = document.getElementById('btn-save-page');
    const pageTitleInput = document.getElementById('page-title');

    // 1. Templates des Blocs
    const PageBlockTemplates = {
        article_ref: (id, data = {}) => {
            return `
                <div class="block-item" data-id="${id}" data-type="article_ref">
                    <div class="block-header">
                        <strong>📄 Section : Article</strong>
                        <button class="btn-delete-block" onclick="this.closest('.block-item').remove()">×</button>
                    </div>
                    <div class="block-body">
                        <label>Contenu à injecter :</label>
                        <select class="data-filename">
                            <option value="">-- Sélectionner un article JSON --</option>
                            ${window.availableArticles ? window.availableArticles.map(file => 
                                `<option value="${file}" ${data.filename === file ? 'selected' : ''}>${file}</option>`
                            ).join('') : ''}
                        </select>
                    </div>
                </div>`;
        },
        ui_component: (id, data = {}) => {
            return `
                <div class="block-item" data-id="${id}" data-type="ui_component">
                    <div class="block-header">
                        <strong>⚙️ Composant UI</strong>
                        <button class="btn-delete-block" onclick="this.closest('.block-item').remove()">×</button>
                    </div>
                    <div class="block-body">
                        <select class="data-comp-name">
                            <option value="hero" ${data.name === 'hero' ? 'selected' : ''}>Bannière Hero</option>
                            <option value="contact" ${data.name === 'contact' ? 'selected' : ''}>Formulaire Contact</option>
                            <option value="gallery" ${data.name === 'gallery' ? 'selected' : ''}>Grille Galerie</option>
                        </select>
                    </div>
                </div>`;
        }
    };

    // 2. Récupérer la liste des articles (via l'API existante ou DOM)
    // Pour simplifier, on peut faire un fetch rapide sur ton API existante
    fetch('api/get_articles_list.php') // Il faudra créer ce petit script PHP
        .then(res => res.json())
        .then(articles => {
            window.availableArticles = articles;
        });

    // 3. Ajouter un bloc
    btnAddBlock.addEventListener('click', () => {
        const type = selectBlockType.value;
        const id = 'block_' + Date.now();
        const html = PageBlockTemplates[type](id);
        blocksContainer.insertAdjacentHTML('beforeend', html);
    });

    // 4. Sauvegarde
    btnSavePage.addEventListener('click', () => {
        const blocks = [];
        document.querySelectorAll('.block-item').forEach(el => {
            const type = el.dataset.type;
            const blockData = { type: type };
            if(type === 'article_ref') blockData.filename = el.querySelector('.data-filename').value;
            if(type === 'ui_component') blockData.name = el.querySelector('.data-comp-name').value;
            blocks.push(blockData);
        });

        const payload = {
            title: pageTitleInput.value,
            filename: pageTitleInput.value.toLowerCase().replace(/\s+/g, '-') + '.json',
            layout: blocks
        };

        fetch('api/save_page.php', {
            method: 'POST',
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) alert('Structure de page enregistrée !');
        });
    });
});