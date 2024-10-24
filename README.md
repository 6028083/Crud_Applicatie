# CRUD Applicatie

Dit project is een CRUD (Create, Read, Update, Delete) applicatie geschreven in PHP. Volg de onderstaande stappen om het project op te zetten en te draaien.

## Voorvereisten

Zorg ervoor dat je de volgende software hebt geïnstalleerd:

- **XAMPP** of een andere webserver die PHP ondersteunt.
- **PHP** moet correct geïnstalleerd en geconfigureerd zijn.

## Stappen om de applicatie te draaien

1. **Open het bestand**: 
   - Zorg ervoor dat je het `seed_database.php`-bestand opent. Dit bestand bevat de logica om de database te vullen met initiële gegevens.

2. **Voer het script uit**:
   - Open een terminal of command prompt en navigeer naar de map waar het bestand zich bevindt (bijvoorbeeld `C:\xampp\htdocs\Crud_Applicatie`).
   - Voer het volgende commando uit om het script uit te voeren:
     ```bash
     php seed_database.php
     ```

3. **Start de PHP server**:
   - Start de ingebouwde PHP server op poort 8080 met het volgende commando:
     ```bash
     php -S localhost:8080
     ```

4. **Open je webbrowser**:
   - Ga naar `http://localhost:8080` om de CRUD applicatie te openen en te testen.

## Beschrijving

Deze applicatie stelt gebruikers in staat om gegevens te creëren, te lezen, bij te werken en te verwijderen (CRUD-operaties) via een eenvoudige webinterface.

## Licentie

Dit project is gelicenseerd onder de MIT-licentie - zie het [LICENSE.md](LICENSE.md) bestand voor details.
