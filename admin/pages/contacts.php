<?php
// On pourrait ici charger une liste de contacts existants pour la sidebar si besoin
?>
<div class="editor-container">
    <section id="contact-editor" class="main-editor">
        <div class="editor-header">
            <label>Nom du contact (Identité)</label>
            <input type="text" id="contact-name" class="main-title-input" placeholder="Ex: Jean Dupont">
            <p class="id-preview-container">Fichier : <span id="contact-filename-preview">nouveau.json</span></p>
        </div>

        <div class="editor-section">
            <h3><i class="fas fa-id-card"></i> Informations de base</h3>
            <div class="grid-2-col">
                <div class="input-group">
                    <label>Téléphone</label>
                    <input type="text" id="contact-phone" placeholder="+32(0)485 00 00 00">
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" id="contact-email" placeholder="nom@exemple.be">
                </div>
            </div>
            <div class="grid-2-col">
                <div class="input-group">
                    <label>Rôle (FR)</label>
                    <input type="text" id="contact-role-fr" placeholder="Maître Verrier">
                </div>
                <div class="input-group">
                    <label>Role (EN)</label>
                    <input type="text" id="contact-role-en" placeholder="Master Glassmaker">
                </div>
            </div>
        </div>

        <div class="editor-section">
            <h3><i class="fas fa-share-alt"></i> Réseaux Sociaux & Liens</h3>
            <div id="social-links-container">
                </div>
            <button type="button" id="btn-add-social" class="btn-secondary">
                <i class="fas fa-plus"></i> Ajouter un réseau social
            </button>
        </div>

        <div class="editor-actions-bar">
            <button id="btn-save-contact" class="btn-success">
                <i class="fas fa-save"></i> Enregistrer la fiche contact
            </button>
        </div>
    </section>

    <aside class="editor-sidebar">
        <h3>Fiches existantes</h3>
        <ul id="contacts-list" class="file-list">
            <li class="loading">Chargement des contacts...</li>
        </ul>
    </aside>
</div>

<template id="social-row-template">
    <div class="social-row">
        <select class="social-platform">
            <option value="whatsapp">WhatsApp</option>
            <option value="instagram">Instagram</option>
            <option value="facebook">Facebook</option>
            <option value="linkedin">LinkedIn</option>
            <option value="website">Site Web</option>
        </select>
        <input type="text" class="social-value" placeholder="Identifiant ou lien complet">
        <button class="btn-remove-row" onclick="this.parentElement.remove()">×</button>
    </div>
</template>

<script src="js/contact_editor.js"></script>