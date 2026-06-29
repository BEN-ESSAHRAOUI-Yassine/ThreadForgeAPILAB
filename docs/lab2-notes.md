# LAB2 Notes

## Capture d'un POST valide → réponse 201 avec la Resource

![Screenshot](docs/images/lab02-01.png)

## Capture d'un POST invalide → réponse 422 avec les erreurs

![Screenshot](docs/images/lab02-02.png)

Model::all() aurait exposé le champ user_id (ainsi que les timestamps created_at et updated_at), tandis que l'API Resource filtre ces informations et ne renvoie que les données nécessaires au client.