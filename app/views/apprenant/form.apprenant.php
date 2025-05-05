<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apprenants - Ajout apprenant</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .form-container {
            width: 100%;
            max-width: 800px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }
        .form-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }
        .form-header h1 {
            color: #00a8a3;
            font-size: 24px;
            font-weight: 500;
        }
        .form-section {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .section-title h2 {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        .edit-icon {
            color: #00a8a3;
            cursor: pointer;
            font-size: 18px;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px 15px;
        }
        .form-group {
            flex: 1;
            min-width: 200px;
            padding: 0 10px;
            margin-bottom: 15px;
        }
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            color: #666;
        }
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
            background-color: #f9f9f9;
        }
        .form-control:focus {
            outline: none;
            border-color: #00a8a3;
        }
        .date-input-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .date-input-container .form-control {
            flex: 1;
        }
        .calendar-icon {
            position: absolute;
            right: 10px;
            color: #00a8a3;
            background-color: white;
            border-radius: 50%;
            padding: 2px;
            cursor: pointer;
        }
        .upload-document {
            border: 1px dashed #00a8a3;
            border-radius: 4px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            margin-top: 10px;
        }
        .upload-icon {
            color: #00a8a3;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .upload-text {
            color: #00a8a3;
            font-size: 14px;
        }
        .form-footer {
            padding: 20px;
            text-align: right;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
        }
        .btn-secondary {
            background-color: #f5f5f5;
            color: #333;
        }
        .btn-primary {
            background-color: #00a8a3;
            color: white;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Ajout apprenant</h1>
        </div>
        
        <div class="form-section">
            <div class="section-title">
                <h2>Informations de l'apprenant</h2>
                <span class="edit-icon">✎</span>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Prénom(s)</label>
                    <input type="text" class="form-control" placeholder="Prénom complet">
                </div>
                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" placeholder="Nom">
                </div>
                <div class="form-group">
                    <label class="form-label">Âge</label>
                    <input type="text" class="form-control" placeholder="Âge">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Date de naissance</label>
                    <div class="date-input-container">
                        <input type="text" class="form-control" placeholder="JJ/MM/AAAA" value="04/10/2004">
                        <span class="calendar-icon">📅</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Lieu de naissance</label>
                    <input type="text" class="form-control" placeholder="Ville">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Adresse</label>
                    <input type="text" class="form-control" placeholder="Adresse complète" value="Sicap Liberté 5 Villa 5523 Dakar, Senegal">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="text" class="form-control" placeholder="+221 XX XXX XX XX" value="+221 77 855 75 30">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="exemple@email.com" value="ibrahimovic7@gmail.com">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group" style="flex: 2;">
                    <!-- Empty space to align with upload button -->
                </div>
                <div class="form-group">
                    <div class="upload-document">
                        <div class="upload-icon">📁</div>
                        <div class="upload-text">Ajouter des documents</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <div class="section-title">
                <h2>Informations du tuteur</h2>
                <span class="edit-icon">✎</span>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Prénom & Nom</label>
                    <input type="text" class="form-control" placeholder="Prénom et nom" value="Mariama Mbaye">
                </div>
                <div class="form-group">
                    <label class="form-label">Lien de parenté</label>
                    <input type="text" class="form-control" placeholder="Lien" value="Mère">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Adresse</label>
                    <input type="text" class="form-control" placeholder="Adresse complète" value="Sicap Liberté 5 Villa 5523 Dakar, Senegal">
                </div>
                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="text" class="form-control" placeholder="+221 XX XXX XX XX" value="+221 77 855 75 30">
                </div>
            </div>
        </div>
        
        <div class="form-footer">
            <button class="btn btn-secondary">Annuler</button>
            <button class="btn btn-primary">Enregistrer</button>
        </div>
    </div>
</body>
</html>