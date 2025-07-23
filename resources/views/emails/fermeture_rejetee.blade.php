<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de fermeture de compte rejetée</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #dc3545; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f8f9fa; }
        .reason-box { background-color: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 15px 0; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Demande de fermeture de compte rejetée</h2>
        </div>
        
        <div class="content">
            <p>Bonjour {{ $compte->user->name ?? 'Cher client' }},</p>
            
            <p>Nous vous informons que votre demande de fermeture de compte bancaire ({{ $compte->numero_compte }}) de type <strong>{{ ucfirst($compte->type_compte) }}</strong> a été examinée et ne peut pas être approuvée pour le moment.</p>
            
            @if($raison)
                <div class="reason-box">
                    <h4>Raison du rejet :</h4>
                    <p>{{ $raison }}</p>
                </div>
            @endif
            
            <p>Votre compte reste actif et vous pouvez continuer à effectuer vos opérations bancaires normalement.</p>
            
            <p>Si vous souhaitez toujours fermer votre compte, nous vous invitons à résoudre les points mentionnés ci-dessus et à soumettre une nouvelle demande.</p>
            
            <p>Pour toute question ou assistance, n'hésitez pas à nous contacter.</p>
            
            <p>Cordialement,<br>
            L'équipe de gestion bancaire</p>
        </div>
        
        <div class="footer">
            <p><small>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</small></p>
        </div>
    </div>
</body>
</html>

